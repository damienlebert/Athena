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
	 * R�cup�re toutes les conversations d'un utilisateur
	 * @param integer $userId
	 */
	public function fetchAllConversations($userId)
	{
		
	}
	
	/**
	 * R�cup�re la conversation dont l'identifiant est en param�tre
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
	 * D�sactive la conversation $id
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
	 * Ajoute un message � la conversation $idConversation
	 * @param integer $idConversation
	 * @param string $content
	 */
	public function addMessage($idConversation, $content)
	{
		
	}
	
	/**
	 * R�cup�re tous les messages de la conversation $idConversation
	 * @param integer $idConversation
	 */
	public function fetchAllMessages($idConversation)
	{
		
	}
	
	
	
}