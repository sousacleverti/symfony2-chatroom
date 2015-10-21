<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Chat
 *
 * @author sousa
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class ChatRoom {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=150)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=2147483647)
     */
    protected $text;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=500)
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="chatroom", cascade={"persist", "remove"})
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="chatroom", cascade={"persist", "remove"})
     */
    protected $messages;

    public function __construct() {
        $this->users = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ChatRoom
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return ChatRoom
     */
    public function setText($text) {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ChatRoom
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set users
     *
     * @param string $users
     *
     * @return ChatRoom
     */
    public function setUsers($users) {
        $this->users = $users;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getUsers() {
        return $this->users;
    }

    /**
     * Set messages
     *
     * @param string $messages
     *
     * @return ChatRoom
     */
    public function setMessages($messages) {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get messages
     *
     * @return string
     */
    public function getMessages() {
        return $this->messages;
    }

}
