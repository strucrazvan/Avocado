<?php

namespace ConferenceBundle\Entity;

/**
 * Sections
 */
class Sections
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $topic;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set topic
     *
     * @param string $topic
     *
     * @return Sections
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }
}

