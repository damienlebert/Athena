<?php

namespace Athena\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="Athena\ChatBundle\Entity\MessageRepository")
 *
 */
class Message
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id_msg", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /** 
     * @var string
     * 
     * @ORM\Column(name="contenu_msg", type="text", nullable=false) 
     */
    protected $contenu;
    
    /** 
     * @var date
     * 
     * @ORM\Column(name="date_msg", type="datetime", nullable=false) 
     */
    protected $date;
    
    /**
     * @var integer 
     * 
     * @ORM\Column(name="usr_msg", type="integer", nullable=false) 
     */
    protected $userId;
    
    /** 
     * @var integer
     * 
     * @ORM\Column(name="id_conversation", type="integer", nullable=false) 
     */
    protected $conversation;
    
    
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $contenu
	 */
	public function getContenu() {
		return $this->contenu;
	}

	/**
	 * @return the $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @return the $userId
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @return the $conversation
	 */
	public function getConversation() {
		return $this->conversation;
	}

	/**
	 * @param number $id
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @param string $contenu
	 */
	public function setContenu($contenu) {
		$this->contenu = $contenu;
		return $this;
	}

	/**
	 * @param \Athena\ChatBundle\Entity\date $date
	 */
	public function setDate($date) {
		$this->date = $date;
		return $this;
	}

	/**
	 * @param number $userId
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
		return $this;
	}

	/**
	 * @param number $conversation
	 */
	public function setConversation($conversation) {
		$this->conversation = $conversation;
		return $this;
	}

    
    

}