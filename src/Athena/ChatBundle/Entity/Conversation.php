<?php 

namespace Athena\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="conversation")
 * @ORM\Entity(repositoryClass="Athena\ChatBundle\Entity\ConversationRepository")
 * 
 */
class Conversation
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id_conversation", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id_conversation; 
    
    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="conversation", cascade={"persist", "remove"})
     *
     */
    protected $messages;
    
    /**
     * @ORM\OneToMany(targetEntity="LinkUsrConversation", mappedBy="conversation", cascade={"persist", "remove"})
     */
    protected $user_conversation;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->user_conversation = new \Doctrine\Common\Collections\ArrayCollection();
		$this->messages = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
	/**
	 * @return the $id_conversation
	 */
	public function getId_conversation()
	{
		return $this->id_conversation;
	}

	/**
	 * @return the $messages
	 */
	public function getMessages()
	{
		return $this->messages;
	}

	/**
	 * @return the $user_conversation
	 */
	public function getUser_conversation()
	{
		return $this->user_conversation;
	}

	/**
	 * @param number $id_conversation
	 */
	public function setId_conversation($id_conversation)
	{
		$this->id_conversation = $id_conversation;
		return $this;
	}

	/**
	 * @param field_type $messages
	 */
	public function setMessages($messages)
	{
		$this->messages = $messages;
		return $this;
	}

	public function addMessage(Message $message)
	{
		$this->messages->add($message);
		return $this;
	}



	/**
	 * @param field_type $user_conversation
	 */
	public function setUser_conversation($user_conversation)
	{
		$this->user_conversation = $user_conversation;
		return $this;
	}

	/**
	 * Returns all the users who belong the conversation
	 * @return array of Conversation
	 */
	public function getUsers()
	{
		return array_map(
				function ($usr_conversation) {
					return $usr_conversation->getUser();
				},
				$this->user_conversation->toArray()
		);
	}


}