<?php
/**
 * Created by PhpStorm.
 * User: Struc Razvan
 * Date: 5/29/2019
 * Time: 12:27 AM
 */

namespace ConferenceBundle\Controller;


use ConferenceBundle\Entity\Conference;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ConferenceController extends Controller
{


    private function createSerializer()
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = new ObjectNormalizer();
        $normalizers->setCircularReferenceHandler(function ( $object ) {
            return $object->getId();
        });
        $normalizers = array(new DateTimeNormalizer(), $normalizers);
        return new Serializer($normalizers, $encoders);
    }

    /**
     *
     * @ApiDoc(
     *  description="Returns a Conference",
     *  section="Conference"
     * )
     * @param $id
     * @return Response
     */
    public function getConferenceByIdAction($id)
    {
        $conferences = $this->getDoctrine()->getRepository(Conference::class)->findOneBy(['id'=>$id]);
        $serializer = $this->createSerializer();
        $jsonContent = $serializer->serialize($conferences,'json');
        return new Response($jsonContent);
    }
    /**
     *
     * @ApiDoc(
     *  description="Returns a user",
     *  section="Conference"
     * )
     * @return Response
     * @internal param $token
     * @internal param $username
     * @internal param $email
     * @internal param $userLoginToken
     * @internal param $date
     */
    public function getConferencesAction()
    {
        $conferences = $this->getDoctrine()->getRepository(Conference::class)->findAll();
        $serializer = $this->createSerializer();
        $jsonContent = $serializer->serialize($conferences,'json');
            return new Response($jsonContent);

    }
}