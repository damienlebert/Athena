<?php 

namespace Athena\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Athena\UserBundle\Entity\User;

/**
 * User
 *
 * @ORM\Table(name="link_usr_conversation")
 * @ORM\Entity(repositoryClass="Athena\ChatBundle\Entity\LinkUsrConversationRepository")
 * 
 */
class LinkUsrConversation
{

    /**
     * @var Conversation
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Athena\ChatBundle\Entity\Conversation", inversedBy="user_conversation")
     * @ORM\JoinColumn(name="id_conversation", referencedColumnName="id_conversation")
     */
    protected $conversation;
    
    /**
     * @var User
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Athena\UserBundle\Entity\User", inversedBy="user_conversation")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    protected $user;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer")
     */
    protected $statut;
    
    
	/**
	 * @return the $conversation
	 */
	public function getConversation() {
		return $this->conversation;
	}

	/**
	 * @return the $user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @return the $statut
	 */
	public function getStatut() {
		return $this->statut;
	}

	/**
	 * @param \Athena\ChatBundle\Entity\Conversation $conversation
	 */
	public function setConversation(\Athena\ChatBundle\Entity\Conversation $conversation) {
		$this->conversation = $conversation;
		return $this;
	}

	/**
	 * @param \Athena\UserBundle\Entity\User $user
	 */
	public function setUser(\Athena\UserBundle\Entity\User $user) {
		$this->user = $user;
		return $this;
	}

	/**
	 * @param number $statut
	 */
	public function setStatut($statut) {
		$this->statut = $statut;
		return $this;
	}

}