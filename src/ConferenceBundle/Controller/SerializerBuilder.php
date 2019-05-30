<?php
/**
 * Created by PhpStorm.
 * User: Struc Razvan
 * Date: 5/16/2019
 * Time: 10:34 PM
 */

namespace ConferenceBundle\Controller;


class SerializerBuilder
{
    private $metadataDirs = array();
    private $handlerRegistry;
    private $handlersConfigured = false;
    private $eventDispatcher;
    private $listenersConfigured = false;
    private $objectConstructor;
    private $serializationVisitors;
    private $deserializationVisitors;
    private $visitorsAdded = false;
    private $propertyNamingStrategy;
    private $debug = false;
    private $cacheDir;
    private $annotationReader;
    private $includeInterfaceMetadata = false;
    private $driverFactory;
    private $serializationContextFactory;
    private $deserializationContextFactory;

    public static function create()
    {
        return new static();
    }

    public function __construct()
    {
        $this->handlerRegistry = new HandlerRegistry();
        $this->eventDispatcher = new EventDispatcher();
        $this->driverFactory = new DefaultDriverFactory();
        $this->serializationVisitors = new Map();
        $this->deserializationVisitors = new Map();
    }

    public function setAnnotationReader(Reader $reader)
    {
        $this->annotationReader = $reader;

        return $this;
    }

    public function setDebug($bool)
    {
        $this->debug = (boolean) $bool;

        return $this;
    }

    public function setCacheDir($dir)
    {
        if ( ! is_dir($dir)) {
            $this->createDir($dir);
        }
        if ( ! is_writable($dir)) {
            throw new InvalidArgumentException(sprintf('The cache directory "%s" is not writable.', $dir));
        }

        $this->cacheDir = $dir;

        return $this;
    }

    public function addDefaultHandlers()
    {
        $this->handlersConfigured = true;
        $this->handlerRegistry->registerSubscribingHandler(new DateHandler());
        $this->handlerRegistry->registerSubscribingHandler(new PhpCollectionHandler());
        $this->handlerRegistry->registerSubscribingHandler(new ArrayCollectionHandler());
        $this->handlerRegistry->registerSubscribingHandler(new PropelCollectionHandler());

        return $this;
    }

    public function configureHandlers(\Closure $closure)
    {
        $this->handlersConfigured = true;
        $closure($this->handlerRegistry);

        return $this;
    }

    public function addDefaultListeners()
    {
        $this->listenersConfigured = true;
        $this->eventDispatcher->addSubscriber(new DoctrineProxySubscriber());

        return $this;
    }

    public function configureListeners(\Closure $closure)
    {
        $this->listenersConfigured = true;
        $closure($this->eventDispatcher);

        return $this;
    }

    public function setObjectConstructor(ObjectConstructorInterface $constructor)
    {
        $this->objectConstructor = $constructor;

        return $this;
    }

    public function setPropertyNamingStrategy(PropertyNamingStrategyInterface $propertyNamingStrategy)
    {
        $this->propertyNamingStrategy = $propertyNamingStrategy;

        return $this;
    }

    public function setSerializationVisitor($format, VisitorInterface $visitor)
    {
        $this->visitorsAdded = true;
        $this->serializationVisitors->set($format, $visitor);

        return $this;
    }

    public function setDeserializationVisitor($format, VisitorInterface $visitor)
    {
        $this->visitorsAdded = true;
        $this->deserializationVisitors->set($format, $visitor);

        return $this;
    }

    public function addDefaultSerializationVisitors()
    {
        $this->initializePropertyNamingStrategy();

        $this->visitorsAdded = true;
        $this->serializationVisitors->setAll(array(
            'xml' => new XmlSerializationVisitor($this->propertyNamingStrategy),
            'yml' => new YamlSerializationVisitor($this->propertyNamingStrategy),
            'json' => new JsonSerializationVisitor($this->propertyNamingStrategy),
        ));

        return $this;
    }

    public function addDefaultDeserializationVisitors()
    {
        $this->initializePropertyNamingStrategy();

        $this->visitorsAdded = true;
        $this->deserializationVisitors->setAll(array(
            'xml' => new XmlDeserializationVisitor($this->propertyNamingStrategy),
            'json' => new JsonDeserializationVisitor($this->propertyNamingStrategy),
        ));

        return $this;
    }

    /**
     * @param Boolean $include Whether to include the metadata from the interfaces
     *
     * @return SerializerBuilder
     */
    public function includeInterfaceMetadata($include)
    {
        $this->includeInterfaceMetadata = (Boolean) $include;

        return $this;
    }

    /**
     * Sets a map of namespace prefixes to directories.
     *
     * This method overrides any previously defined directories.
     *
     * @param array<string,string> $namespacePrefixToDirMap
     *
     * @return SerializerBuilder
     *
     * @throws InvalidArgumentException When a directory does not exist
     */
    public function setMetadataDirs(array $namespacePrefixToDirMap)
    {
        foreach ($namespacePrefixToDirMap as $dir) {
            if ( ! is_dir($dir)) {
                throw new InvalidArgumentException(sprintf('The directory "%s" does not exist.', $dir));
            }
        }

        $this->metadataDirs = $namespacePrefixToDirMap;

        return $this;
    }

    /**
     * Adds a directory where the serializer will look for class metadata.
     *
     * The namespace prefix will make the names of the actual metadata files a bit shorter. For example, let's assume
     * that you have a directory where you only store metadata files for the ``MyApplication\Entity`` namespace.
     *
     * If you use an empty prefix, your metadata files would need to look like:
     *
     * ``my-dir/MyApplication.Entity.SomeObject.yml``
     * ``my-dir/MyApplication.Entity.OtherObject.xml``
     *
     * If you use ``MyApplication\Entity`` as prefix, your metadata files would need to look like:
     *
     * ``my-dir/SomeObject.yml``
     * ``my-dir/OtherObject.yml``
     *
     * Please keep in mind that you currently may only have one directory per namespace prefix.
     *
     * @param string $dir The directory where metadata files are located.
     * @param string $namespacePrefix An optional prefix if you only store metadata for specific namespaces in this directory.
     *
     * @return SerializerBuilder
     *
     * @throws InvalidArgumentException When a directory does not exist
     * @throws InvalidArgumentException When a directory has already been registered
     */
    public function addMetadataDir($dir, $namespacePrefix = '')
    {
        if ( ! is_dir($dir)) {
            throw new InvalidArgumentException(sprintf('The directory "%s" does not exist.', $dir));
        }

        if (isset($this->metadataDirs[$namespacePrefix])) {
            throw new InvalidArgumentException(sprintf('There is already a directory configured for the namespace prefix "%s". Please use replaceMetadataDir() to override directories.', $namespacePrefix));
        }

        $this->metadataDirs[$namespacePrefix] = $dir;

        return $this;
    }

    /**
     * Adds a map of namespace prefixes to directories.
     *
     * @param array<string,string> $namespacePrefixToDirMap
     *
     * @return SerializerBuilder
     */
    public function addMetadataDirs(array $namespacePrefixToDirMap)
    {
        foreach ($namespacePrefixToDirMap as $prefix => $dir) {
            $this->addMetadataDir($dir, $prefix);
        }

        return $this;
    }

    /**
     * Similar to addMetadataDir(), but overrides an existing entry.
     *
     * @param string $dir
     * @param string $namespacePrefix
     *
     * @return SerializerBuilder
     *
     * @throws InvalidArgumentException When a directory does not exist
     * @throws InvalidArgumentException When no directory is configured for the ns prefix
     */
    public function replaceMetadataDir($dir, $namespacePrefix = '')
    {
        if ( ! is_dir($dir)) {
            throw new InvalidArgumentException(sprintf('The directory "%s" does not exist.', $dir));
        }

        if ( ! isset($this->metadataDirs[$namespacePrefix])) {
            throw new InvalidArgumentException(sprintf('There is no directory configured for namespace prefix "%s". Please use addMetadataDir() for adding new directories.', $namespacePrefix));
        }

        $this->metadataDirs[$namespacePrefix] = $dir;

        return $this;
    }

    public function setMetadataDriverFactory(DriverFactoryInterface $driverFactory)
    {
        $this->driverFactory = $driverFactory;

        return $this;
    }

    /**
     * @param SerializationContextFactoryInterface|callable $serializationContextFactory
     *
     * @return self
     */
    public function setSerializationContextFactory($serializationContextFactory)
    {
        if ($serializationContextFactory instanceof SerializationContextFactoryInterface) {
            $this->serializationContextFactory = $serializationContextFactory;
        } elseif (is_callable($serializationContextFactory)) {
            $this->serializationContextFactory = new CallableSerializationContextFactory(
                $serializationContextFactory
            );
        } else {
            throw new InvalidArgumentException('expected SerializationContextFactoryInterface or callable.');
        }

        return $this;
    }

    /**
     * @param DeserializationContextFactoryInterface|callable $deserializationContextFactory
     *
     * @return self
     */
    public function setDeserializationContextFactory($deserializationContextFactory)
    {
        if ($deserializationContextFactory instanceof DeserializationContextFactoryInterface) {
            $this->deserializationContextFactory = $deserializationContextFactory;
        } elseif (is_callable($deserializationContextFactory)) {
            $this->deserializationContextFactory = new CallableDeserializationContextFactory(
                $deserializationContextFactory
            );
        } else {
            throw new InvalidArgumentException('expected DeserializationContextFactoryInterface or callable.');
        }

        return $this;
    }

    public function build()
    {
        $annotationReader = $this->annotationReader;
        if (null === $annotationReader) {
            $annotationReader = new AnnotationReader();

            if (null !== $this->cacheDir) {
                $this->createDir($this->cacheDir.'/annotations');
                $annotationsCache = new FilesystemCache($this->cacheDir.'/annotations');
                $annotationReader = new CachedReader($annotationReader, $annotationsCache, $this->debug);
            }
        }

        $metadataDriver = $this->driverFactory->createDriver($this->metadataDirs, $annotationReader);
        $metadataFactory = new MetadataFactory($metadataDriver, null, $this->debug);

        $metadataFactory->setIncludeInterfaces($this->includeInterfaceMetadata);

        if (null !== $this->cacheDir) {
            $this->createDir($this->cacheDir.'/metadata');
            $metadataFactory->setCache(new FileCache($this->cacheDir.'/metadata'));
        }

        if ( ! $this->handlersConfigured) {
            $this->addDefaultHandlers();
        }

        if ( ! $this->listenersConfigured) {
            $this->addDefaultListeners();
        }

        if ( ! $this->visitorsAdded) {
            $this->addDefaultSerializationVisitors();
            $this->addDefaultDeserializationVisitors();
        }

        $serializer = new Serializer(
            $metadataFactory,
            $this->handlerRegistry,
            $this->objectConstructor ?: new UnserializeObjectConstructor(),
            $this->serializationVisitors,
            $this->deserializationVisitors,
            $this->eventDispatcher
        );

        if (null !== $this->serializationContextFactory) {
            $serializer->setSerializationContextFactory($this->serializationContextFactory);
        }

        if (null !== $this->deserializationContextFactory) {
            $serializer->setDeserializationContextFactory($this->deserializationContextFactory);
        }

        return $serializer;
    }

    private function initializePropertyNamingStrategy()
    {
        if (null !== $this->propertyNamingStrategy) {
            return;
        }

        $this->propertyNamingStrategy = new SerializedNameAnnotationStrategy(new CamelCaseNamingStrategy());
    }

    private function createDir($dir)
    {
        if (is_dir($dir)) {
            return;
        }

        if (false === @mkdir($dir, 0777, true)) {
            throw new RuntimeException(sprintf('Could not create directory "%s".', $dir));
        }
    }
}