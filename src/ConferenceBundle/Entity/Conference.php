<?php

namespace ConferenceBundle\Entity;

/**
 * Conference
 */
class Conference
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $endDate;

    /**
     * @var string
     */
    private $callForPapers;

    /**
     * @var \DateTime
     */
    private $abstractDeadline;

    /**
     * @var \DateTime
     */
    private $proposalDeadline;

    private $proposalsC;

    public function __construct()
    {        $this->proposalsC = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Conference
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
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Conference
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Conference
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set callForPapers
     *
     * @param string $callForPapers
     *
     * @return Conference
     */
    public function setCallForPapers($callForPapers)
    {
        $this->callForPapers = $callForPapers;

        return $this;
    }

    /**
     * Get callForPapers
     *
     * @return string
     */
    public function getCallForPapers()
    {
        return $this->callForPapers;
    }

    /**
     * Set abstractDeadline
     *
     * @param \DateTime $abstractDeadline
     *
     * @return Conference
     */
    public function setAbstractDeadline($abstractDeadline)
    {
        $this->abstractDeadline = $abstractDeadline;

        return $this;
    }

    /**
     * Get abstractDeadline
     *
     * @return \DateTime
     */
    public function getAbstractDeadline()
    {
        return $this->abstractDeadline;
    }

    /**
     * Set proposalDeadline
     *
     * @param \DateTime $proposalDeadline
     *
     * @return Conference
     */
    public function setProposalDeadline($proposalDeadline)
    {
        $this->proposalDeadline = $proposalDeadline;

        return $this;
    }

    /**
     * Get proposalDeadline
     *
     * @return \DateTime
     */
    public function getProposalDeadline()
    {
        return $this->proposalDeadline;
    }
    /**
     * @return mixed
     */
    public function getProposals()
    {

        return $this->proposalsC;
    }

    /**
     * @param mixed $proposals
     * @return $this
     */
    public function setProposals( $proposals )
    {
        $this->proposalsC[] = $proposals;
        return $this;
    }
}

