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
    protected $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="Athena\ChatBundle\Entity\Message", cascade={"persist"})
     */
    protected $messages;
    
    
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $messages
	 */
	public function getMessages() {
		return $this->messages;
	}

	/**
	 * @param number $id
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @param field_type $messages
	 */
	public function setMessages($messages) {
		$this->messages = $messages;
		return $this;
	}

}