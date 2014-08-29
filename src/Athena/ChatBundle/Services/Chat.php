<?php
namespace Athena\ChatBundle\Services;

use Doctrine\ORM\EntityManager;

/**
 * Service Chat
 * 
 * 
 * @author PierreVassoilles/DamienLebert
 */
class Chat
{
	
	protected $em;
	
	/**
	 * Constructeur
	 * @param EntityManager $em
	 */
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}
	
	/**
	 * Récupère toutes les conversations d'un utilisateur
	 * @param integer $userId
	 */
	public function fetchAllConversations($userId)
	{
		if(0 === (int) $userId){
			throw new \InvalidArgumentException("L'utilisateur n'existe pas.");
		}
		
		return $this->em->getRepository('AthenaUserBundle:User')
				 ->find(array('id' => $userId))->getConversations();	
	}
	
	/**
	 * Récupère la conversation dont l'identifiant est en paramètre
	 * @param integer $id
	 */
	public function findConversation($id)
	{
		if(0 === (int) $id){
			throw new \InvalidArgumentException("La conversation n'existe pas.");
		}
		
		return $this->em->getRepository('AthenaChatBundle:Conversation')
						->find($id);
		
	} 
	
	/**
	 * Ajoute une conversation entre $userId et $userOther
	 * @param integer $userId
	 * @param integer $userOther
	 */
	public function addConversation($userId, $userOther)
	{
		
	}
	
	/**
	 * Désactive la conversation $id
	 * @param integer $id
	 */
	public function disableConversation($id)
	{
		
	}
	
	/**
	 * Active la conversation $id
	 * @param integer $id
	 */
	public function enableConversation($id)
	{
		
	}
	
	/**
	 * Ajoute un message à la conversation $idConversation
	 * @param integer $idConversation
	 * @param string $content
	 */
	public function addMessage($idConversation, $content)
	{
		
	}
	
	/**
	 * Récupère tous les messages de la conversation $idConversation
	 * @param integer $idConversation
	 */
	public function fetchAllMessages($idConversation)
	{
		
	}
	
	
	
}