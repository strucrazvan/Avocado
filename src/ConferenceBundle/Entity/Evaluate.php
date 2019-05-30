<?php

namespace ConferenceBundle\Entity;

/**
 * Evaluate
 */
class Evaluate
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $grade;

    /**
     * @var string
     */
    private $recommendations;


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
     * Set grade
     *
     * @param integer $grade
     *
     * @return Evaluate
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return int
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set recommendations
     *
     * @param string $recommendations
     *
     * @return Evaluate
     */
    public function setRecommendations($recommendations)
    {
        $this->recommendations = $recommendations;

        return $this;
    }

    /**
     * Get recommendations
     *
     * @return string
     */
    public function getRecommendations()
    {
        return $this->recommendations;
    }
}

