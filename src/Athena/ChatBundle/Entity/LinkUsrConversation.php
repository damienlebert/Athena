<?php 

namespace Athena\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var integer
     *
     * @ORM\Column(name="id_conversation", type="integer")
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Athena\ChatBundle\Entity\Conversation")
     */
    protected $id_conversation;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer")
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Athena\UserBundle\Entity\User")
     */
    protected $id_user;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer")
     */
    protected $statut;
    
    
	/**
	 * @return the $id_conversation
	 */
	public function getId_conversation() {
		return $this->id_conversation;
	}

	/**
	 * @return the $id_user
	 */
	public function getId_user() {
		return $this->id_user;
	}

	/**
	 * @return the $statut
	 */
	public function getStatut() {
		return $this->statut;
	}

	/**
	 * @param number $id_conversation
	 */
	public function setId_conversation($id_conversation) {
		$this->id_conversation = $id_conversation;
		return $this;
	}

	/**
	 * @param number $id_user
	 */
	public function setId_user($id_user) {
		$this->id_user = $id_user;
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