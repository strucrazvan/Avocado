<?php
/**
 * Created by PhpStorm.
 * User: Struc Razvan
 * Date: 5/29/2019
 * Time: 4:46 PM
 */

namespace ConferenceBundle\ViewModel;

use Symfony\Component\Validator\Constraints as Assert;


class ProposalDetailsViewModel
{

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $userId;
    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $conferenceId;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $keyWords;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $text;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $finalPaper;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $type;

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId( $userId )
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType( $type )
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getFinalPaper()
    {
        return $this->finalPaper;
    }

    /**
     * @param string $finalPaper
     */
    public function setFinalPaper( $finalPaper )
    {
        $this->finalPaper = $finalPaper;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText( $text )
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getKeyWords()
    {
        return $this->keyWords;
    }

    /**
     * @param string $keyWords
     */
    public function setKeyWords( $keyWords )
    {
        $this->keyWords = $keyWords;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getConferenceId()
    {
        return $this->conferenceId;
    }

    /**
     * @param string $conferenceId
     */
    public function setConferenceId( $conferenceId )
    {
        $this->conferenceId = $conferenceId;
    }


}