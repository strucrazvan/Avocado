<?php

namespace ConferenceBundle\Entity;

/**
 * User
 */
class User
{
    private $bidding;
    private $proposals;
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $affiliation;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $webPage;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    public function __construct()
    {
        $this->proposals = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bidding = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName( $firstName )
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName( $lastName )
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set affiliation
     *
     * @param string $affiliation
     *
     * @return User
     */
    public function setAffiliation( $affiliation )
    {
        $this->affiliation = $affiliation;

        return $this;
    }

    /**
     * Get affiliation
     *
     * @return string
     */
    public function getAffiliation()
    {
        return $this->affiliation;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail( $email )
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return User
     */
    public function setToken( $token )
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set webPage
     *
     * @param string $webPage
     *
     * @return User
     */
    public function setWebPage( $webPage )
    {
        $this->webPage = $webPage;

        return $this;
    }

    /**
     * Get webPage
     *
     * @return string
     */
    public function getWebPage()
    {
        return $this->webPage;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername( $username )
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword( $password )
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getProposals()
    {

        return $this->proposals;
    }

    /**
     * @param mixed $proposals
     * @return $this
     */
    public function setProposals( $proposals )
    {
        $this->proposals[] = $proposals;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBidding()
    {
        return $this->bidding;
    }

    /**
     * @param mixed $bidding
     * @return $this
     */
    public function setBidding( $bidding )
    {
        $this->bidding[] = $bidding;
        return $this;
    }
}

