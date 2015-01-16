<?php

namespace Athena\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Athena\UserBundle\Entity\User;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;


/**
 * User
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="Athena\ChatBundle\Entity\MessageRepository")
 * @ExclusionPolicy("none")
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
    protected $id_msg;
    
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
     * @ORM\ManyToOne(targetEntity="Athena\UserBundle\Entity\User")
   	 * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
	 *
	 * @Exclude
     */
    protected $id_user; 
    
    /** 
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Athena\ChatBundle\Entity\Conversation")
     * @ORM\JoinColumn(name="id_conversation", referencedColumnName="id_conversation", nullable=false)
	 * @Exclude
     */
    protected $conversation;
    
    
	/**
	 * @return the $id_msg
	 */
	public function getId_msg() {
		return $this->id_msg;
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
	 * @return the $id_user
	 */
	public function getId_user() {
		return $this->id_user;
	}

	/**
	 * @return the $conversation
	 */
	public function getConversation() {
		return $this->conversation;
	}

	/**
	 * @param number $id_msg
	 */
	public function setId_msg($id_msg) {
		$this->id_msg = $id_msg;
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
	 * @param \DateTime $date
	 */
	public function setDate($date) {
		$this->date = $date;
		return $this;
	}

	/**
	 * @param User $id_user
	 */
	public function setId_user(User $id_user) {
		$this->id_user = $id_user;
		return $this;
	}

	/**
	 * @param number $conversation
	 */
	public function setConversation($conversation) {
		$this->conversation = $conversation;
		return $this;
	}

	/**
	 * @return mixed
	 *
	 *
	 * @VirtualProperty
	 * @SerializedName("user_message")
	 */
	public function getUserIdForSerialization()
	{
		return $this->id_user->getId();
	}
    

    

}