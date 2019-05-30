<?php
/**
 * Created by PhpStorm.
 * User: Struc Razvan
 * Date: 5/30/2019
 * Time: 12:05 AM
 */

namespace ConferenceBundle\ViewModel;
use Symfony\Component\Validator\Constraints as Assert;


class AddBiddingViewModel
{
    /**
     * @Assert\NotBlank()
     * @var int
     */
    private $userId;

    /**
     * @Assert\NotBlank()
     * @var int
     */
    private $proposalId;
    /**
     * @Assert\NotBlank()
     * @var int
     */
    private $result;

    /**
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param int $result
     */
    public function setResult( $result )
    {
        $this->result = $result;
    }

    /**
     * @return int
     */
    public function getProposalId()
    {
        return $this->proposalId;
    }

    /**
     * @param int $proposalId
     */
    public function setProposalId( $proposalId )
    {
        $this->proposalId = $proposalId;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId( $userId )
    {
        $this->userId = $userId;
    }


}