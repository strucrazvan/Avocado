<?php

namespace ConferenceBundle\Entity;

/**
 * Proposal
 */
class Proposal
{
    private $bidding;
    private $conference;
    private $user;
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $keywords;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $finalPaper;

    /**
     * @var bool
     */
    private $accepted;

    /**
     * @var bool
     */
    private $type;

    public function __construct()
    {
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
     * Set name
     *
     * @param string $name
     *
     * @return Proposal
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Proposal
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set finalPaper
     *
     * @param string $finalPaper
     *
     * @return Proposal
     */
    public function setFinalPaper($finalPaper)
    {
        $this->finalPaper = $finalPaper;

        return $this;
    }

    /**
     * Get finalPaper
     *
     * @return string
     */
    public function getFinalPaper()
    {
        return $this->finalPaper;
    }

    /**
     * Set accepted
     *
     * @param boolean $accepted
     *
     * @return Proposal
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return bool
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set type
     *
     * @param boolean $type
     *
     * @return Proposal
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return bool
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     */
    public function setKeywords( $keywords )
    {
        $this->keywords = $keywords;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser( $user )
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getConference()
    {
        return $this->conference;
    }

    /**
     * @param mixed $conference
     */
    public function setConference( $conference )
    {
        $this->conference = $conference;
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

