<?php
namespace Athena\ChatBundle\Services;

/**
 * Service Chat
 * 
 * 
 * @author Pierre/Damien
 */
class Chat
{
	
	/**
	 * Récupère toutes les conversations d'un utilisateur
	 * @param integer $userId
	 */
	public function fetchAllConversations($userId)
	{
		
	}
	
	/**
	 * Récupère la conversation dont l'identifiant est en paramètre
	 * @param integer $id
	 */
	public function findConversation($id)
	{
		
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