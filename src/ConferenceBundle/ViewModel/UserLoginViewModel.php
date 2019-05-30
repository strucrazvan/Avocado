<?php
/**
 * Created by PhpStorm.
 * User: Struc Razvan
 * Date: 5/28/2019
 * Time: 10:54 PM
 */

namespace ConferenceBundle\ViewModel;
use Symfony\Component\Validator\Constraints as Assert;


class UserLoginViewModel
{
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
}