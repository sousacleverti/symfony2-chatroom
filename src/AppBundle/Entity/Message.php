<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Message
 *
 * @author sousa
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="message")
 */
class Message {
    /**
     * Allowed tags in user message
     *
     * @var string
     */
    private $allowedTags = '<img>|<strong>|<p>|<a>';

    /**
     * @ORM\ManyToOne(targetEntity="ChatRoom", inversedBy="messages")
     * @ORM\JoinColumn(name="chatroom_id", referencedColumnName="id")
     **/
    private $chatroom;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(type="string", name="text") */
    protected $text;

    /** @ORM\Column(type="string", name="created_by") */
    protected $createdBy;

    /**
     * created Time/Date
     *
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * updated Time/Date
     *
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    protected $updatedAt;

     /**
     * Get formattedText
     *
     * Formats this message text with html, in order to
     * be presented to the user at the client side
     *
     * @return string
     */
    public function getFormattedText() {
        // [dd-mm-aaaa@hh:mm:ss] userName:
        $date = $this->createdAt->format("d-m-Y"); // full year format
        $time = $this->createdAt->format("H:m:s"); // 24H format
        return '[' . $date . '<strong>@</strong>' . $time . '] <strong>' .
                $this->createdBy . '</strong>: ' . $this->text . '<br>';
    }

     /**
     * injectionFilter
     *
     * filters the input string and prevents any user from
     * performing code injection
     *
     * @return string
     */
    private function injectionFilter($text) {
        // TODO: implement a good code injection filter
        return \strip_tags($text, $this->allowedTags);
    }
    /**
     * Set createdAt
     *
     * @ORM\PrePersist
     */
    public function setCreatedAt() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @ORM\PreUpdate
     */
    public function setUpdatedAt() {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Message
     */
    public function setText($text)
    {
        $this->text = $this->injectionFilter($text);

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
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return Message
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set chatroom
     *
     * @param ChatRoom $chatroom
     *
     * @return Message
     */
    public function setChatRoom($chatroom)
    {
        $this->chatroom = $chatroom;

        return $this;
    }

    /**
     * Get chatroom
     *
     * @return ChatRoom
     */
    public function getChatRoom()
    {
        return $this->chatroom;
    }
}
