<?php

namespace ConferenceBundle\Controller;

use ConferenceBundle\Entity\Conference;
use ConferenceBundle\Entity\Proposal;
use ConferenceBundle\Entity\User;
use ConferenceBundle\Repository\UserRepository;
use ConferenceBundle\ViewModel\ProposalDetailsViewModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class ProposalController extends Controller
{

    private function createSerializer1()
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
     *     description="Add New Proposal",
     *     section="Proposal",
     *     input="ConferenceBundle\ViewModel\ProposalDetailsViewModel"
     * )
     * @param Request $request
     * @return Response
     */
    public function addProposalAction(Request $request)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers,$encoders);
        $proposalRequest = $serializer->deserialize( $request->getContent(), ProposalDetailsViewModel::class,'json');
//        die($proposalRequest->getUserId)
        /** @var User $user */
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $proposalRequest->getUserId()]);
        $conference = $this->getDoctrine()->getRepository(Conference::class)->findOneBy(['id' => $proposalRequest->getConferenceId()]);
//        die($user->getUsername());
        $proposal = new Proposal();
        $proposal->setName($proposalRequest->getName());
        $proposal->setKeywords($proposalRequest->getKeyWords());
        $proposal->setText($proposalRequest->getText());
        $proposal->setType($proposalRequest->getType());
        $proposal->setFinalPaper($proposalRequest->getFinalPaper());
        $proposal->setAccepted(0);
        $proposal->setUser($user);
        $proposal->setConference($conference);
        $this->getDoctrine()->getRepository(Proposal::class)->persist($proposal);
//        $this->getDoctrine()->getRepository(User::class)->persist($user);
//        die("test");
//        die($user->getProposals()[0]->getName());
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $proposalRequest->getUserId()]);
        $ser = $this->createSerializer1();
            $jsonContent = $ser->serialize($user,'json');
            return new Response($jsonContent);

//        return new JsonResponse(["error" => true, "code" => "invalidProposal", "message" => "Already sent a proposal with this name!"]);
    }
    /**
     *
     * @ApiDoc(
     *  description="Add a new program com",
     *  section="Comitee"
     * )
     * @return Response
     * @internal param $token
     * @internal param $id
     * @internal param $username
     * @internal param $email
     * @internal param $userLoginToken
     * @internal param $date
     */
    public function addProgramComiteeAction()
    {
        return $this->render('ConferenceBundle:Proposal:add_proposal.html.twig', array(
            // ...
        ));
    }
    /**
     *
     * @ApiDoc(
     *  description="Get program comitee",
     *  section="Comitee"
     * )
     * @return Response
     * @internal param $token
     * @internal param $id
     * @internal param $username
     * @internal param $email
     * @internal param $userLoginToken
     * @internal param $date
     */
    public function getProgramComiteeAction($id)
    {
        return $this->render('ConferenceBundle:Proposal:add_proposal.html.twig', array(
            // ...
        ));
    }

    /**
     *
     * @ApiDoc(
     *  description="Returns a proposal",
     *  section="Proposal"
     * )
     * @param $token
     * @param $id
     * @return Response
     * @internal param $username
     * @internal param $email
     * @internal param $userLoginToken
     * @internal param $date
     */
    public function getProposalByIdAction($token,$id)
    {
        $proposal = $this->getDoctrine()->getRepository(Proposal::class)->findOneBy(['id'=>$id]);
        if($proposal!=null)
        {
            $serializer = $this->createSerializer();
            $jsonContent = $serializer->serialize($proposal,'json');
            return new Response($jsonContent);
        }
        return new JsonResponse(["error" => true, "code" => "noProposal", "message" => "No proposal found"], JsonResponse::HTTP_BAD_REQUEST);

    }

    /**
     *
     * @ApiDoc(
     *  description="Returns a list of proposals",
     *  section="Proposal"
     * )
     * @return JsonResponse|Response
     */
    public function getProposalsAction( )
    {
        $proposals = $this->getDoctrine()->getRepository(Proposal::class)->findAll();
        if($proposals!=null)
        {
            $serializer = $this->createSerializer();
            $jsonContent = $serializer->serialize($proposals,'json');
            return new Response($jsonContent);
        }
        return new JsonResponse(["error" => true, "code" => "noProposals", "message" => "No proposals found"], JsonResponse::HTTP_BAD_REQUEST);

    }

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
}
