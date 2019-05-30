<?php
namespace ConferenceBundle\ViewModel;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Created by PhpStorm.
 * User: Struc Razvan
 * Date: 5/16/2019
 * Time: 10:04 PM
 */
class UserDetailsViewModel
{
    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $firstName;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $lastName;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $affiliation;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $webPage;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $password;

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword( $password )
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername( $username )
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getWebPage()
    {
        return $this->webPage;
    }

    /**
     * @param string $webPage
     */
    public function setWebPage( $webPage )
    {
        $this->webPage = $webPage;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail( $email )
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName( $lastName )
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getAffiliation()
    {
        return $this->affiliation;
    }

    /**
     * @param string $affiliation
     */
    public function setAffiliation( $affiliation )
    {
        $this->affiliation = $affiliation;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName( $firstName )
    {
        $this->firstName = $firstName;
    }


}