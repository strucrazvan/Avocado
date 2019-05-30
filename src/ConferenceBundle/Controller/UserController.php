<?php

namespace ConferenceBundle\Controller;

use ConferenceBundle\Entity\User;
use ConferenceBundle\ViewModel\UserDetailsViewModel;
use ConferenceBundle\ViewModel\UserLoginViewModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class UserController extends Controller
{


    private function validateUserToken( $token )
    {
        return true;
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

    /**
     *
     * @ApiDoc(
     *  description="Returns a user",
     *  section="User"
     * )
     * @param $token
     * @param $username
     * @return Response
     * @internal param $email
     * @internal param $userLoginToken
     * @internal param $date
     */
    public function getUserAction( $token, $username )
    {
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $username]);
            if($user!=null)
            {
                $serializer = $this->createSerializer();
                $jsonContent = $serializer->serialize($user,'json');
                return new Response($jsonContent);
            }
        return new JsonResponse(["error" => true, "code" => "invalidUser", "message" => "Invalid user"], JsonResponse::HTTP_BAD_REQUEST);

    }

    /**
     *
     * @ApiDoc(
     *  description="Returns a list of users",
     *  section="User"
     * )
     * @return Response
     * @internal param $email
     * @internal param $userLoginToken
     * @internal param $date
     */
    public function getUsersAction( )
    {
            $users = $this->getDoctrine()->getRepository(User::class)->findAll();
            if($users!=null)
            {
                $serializer = $this->createSerializer();
                $jsonContent = $serializer->serialize($users,'json');
                return new Response($jsonContent);
            }
        return new JsonResponse(["error" => true, "code" => "invalidUser", "message" => "Invalid user"], JsonResponse::HTTP_BAD_REQUEST);

    }

    private function sanitizeUser( $user)
    {

        print_r($user);
        die($user);
        $args = array('username' => FILTER_SANITIZE_STRING);
        return filter_var_array($user, $args);
    }
    function getToken($randomIdLength = 10)
    {
        $token = '';
        do {
            $bytes = random_bytes($randomIdLength);
            $token .= str_replace(
                ['.','/','='],
                '',
                base64_encode($bytes)
            );
        } while (strlen($token) < $randomIdLength);
        return $token;
    }

    /**
     * @ApiDoc(
     *     description="Creates a new user",
     *     section="User",
     *     input="ConferenceBundle\ViewModel\UserDetailsViewModel"
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function addNewUserAction( Request $request )
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers,$encoders);

//        die($request->getContent());
        /** @var UserDetailsViewModel $userRequest */
        $userRequest = $serializer->deserialize( $request->getContent(), UserDetailsViewModel::class,'json');

        $user = new User();
        /** @var UserDetailsViewModel $content */
        $user->setUsername($userRequest->getUsername());
        $user->setPassword(hash('ripemd160',$userRequest->getPassword()));
        $user->setEmail($userRequest->getEmail());
        $user->setFirstName($userRequest->getFirstName());
        $user->setLastName($userRequest->getLastName());
        $user->setToken($this->getToken());
        $user->setAffiliation($userRequest->getAffiliation());
        $user->setWebPage($userRequest->getWebPage());
//        die($userRequest->getUsername());
        try{
            $this->getDoctrine()->getRepository(User::class)->addNewUser($user);
            return new JsonResponse(["error" => false, "code" => "success", "message" => "Item added"], JsonResponse::HTTP_OK);
        } catch (\Exception $e)
        {
            return new JsonResponse(["error" => true, "code" => "wrong", "message" => $e->getMessage()]);
        }
    }
    /**
     * @ApiDoc(
     *     description="Login",
     *     section="User",
     *     input="ConferenceBundle\ViewModel\UserLoginViewModel"
     * )
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers,$encoders);

        /** @var UserLoginViewModel $userRequest */
        $userRequest = $serializer->deserialize( $request->getContent(), UserLoginViewModel::class,'json');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $userRequest->getUsername()]);
        if($user!=null)
        {
            if($user->getPassword() == hash('ripemd160',$userRequest->getPassword()))
            {
                $serializer = $this->createSerializer();
//                $user->setProposals(null);
//                    $user->setBidding(null);
                $jsonContent = $serializer->serialize($user,'json');
                return new Response($jsonContent);

            }
        }
        return new JsonResponse(["error" => true, "code" => "invalidUser", "message" => "Invalid user credentials"]);
    }


}
