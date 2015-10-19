<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="name", message="User name already taken!")
 */
class User implements UserInterface, \Serializable {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     */
    protected $username;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max = 4096)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max = 4096)
     */
    protected $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $userImage;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $updated;

    public function __construct() {
        $this->updated = false;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->username;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setName($name) {
        $this->username = $name;
        $this->name = $name;
    }

    public function setUsername($name) {
        $this->username = $name;
        $this->name = $name;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($pass) {
        $this->password = $pass;
        $this->plainPassword = $pass;
    }

    public function getRoles() {
        return array('ROLE_USER');
    }

    public function eraseCredentials() {

    }

    /** @see \Serializable::serialize() */
    public function serialize() {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
                // see section on salt below
                // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized) {
        list (
                $this->id,
                $this->username,
                $this->password,
                // see section on salt below
                // $this->salt
                ) = unserialize($serialized);
    }

    public function getSalt() {
        return null;
    }

    public function __toString() {
        return $this->username;
    }

    public function getPlainPassword()
    {
        return $this->password;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
        $this->password = $password;
    }

    /**
     * Set updated
     *
     * @param boolean $updated
     *
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return boolean
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set userImage
     *
     * @param string $userImage
     *
     * @return User
     */
    public function setUserImage($userImage)
    {
        $this->userImage = $userImage;

        return $this;
    }

    /**
     * Get userImage
     *
     * @return string
     */
    public function getUserImage()
    {
        return $this->userImage;
    }
}
