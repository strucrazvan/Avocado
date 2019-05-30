<?php
/**
 * Created by PhpStorm.
 * User: Struc Razvan
 * Date: 5/30/2019
 * Time: 12:08 AM
 */

namespace ConferenceBundle\Controller;


use ConferenceBundle\Entity\Bidding;
use ConferenceBundle\Entity\Proposal;
use ConferenceBundle\Entity\User;
use ConferenceBundle\ViewModel\AddBiddingViewModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class BiddingController extends Controller
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
     * @ApiDoc(
     *     description="Add a bidding",
     *     section="Bidding",
     *     input="ConferenceBundle\ViewModel\AddBiddingViewModel"
     * )
     * @param Request $request
     * @return Response
     */
    public function addBiddingAction(Request $request)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers,$encoders);
        $biddingRequest= $serializer->deserialize( $request->getContent(), AddBiddingViewModel::class,'json');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=> $biddingRequest->getUserId()]);
        $proposal = $this->getDoctrine()->getRepository(Proposal::class)->findOneBy(['id'=> $biddingRequest->getProposalId()]);
        $bidding = new Bidding();
        $bidding->setUser($user);
        $bidding->setProposal($proposal);
        $bidding->setVote($biddingRequest->getResult());
        $this->getDoctrine()->getRepository(Bidding::class)->persist($bidding);

        $serializer = $this->createSerializer();
        $jsonContent = $serializer->serialize($user,'json');
        return new Response($jsonContent);
    }

    /**
     * @ApiDoc(
     *     description="Get users who voted yes",
     *     section="User",
     * )
     * @param $proposalId
     * @return Response
     */
    public function getBiddersWithYesAction($proposalId)
    {
        $users = $this->getDoctrine()->getRepository(Bidding::class)->getProposalByUserIdWhoVotedYes($proposalId);
        $serializer = $this->createSerializer();
        $jsonContent = $serializer->serialize($users,'json');
        return new Response($jsonContent);
    }
    /**
     * @ApiDoc(
     *     description="Get users who voted maybe",
     *     section="User",
     * )
     * @param $proposalId
     * @return Response
     */
    public function getBiddersWithMaybeAction($proposalId)
    {
        $users = $this->getDoctrine()->getRepository(Bidding::class)->getProposalByUserIdWhoVotedMaybe($proposalId);
        $serializer = $this->createSerializer();
        $jsonContent = $serializer->serialize($users,'json');
        return new Response($jsonContent);
    }

}