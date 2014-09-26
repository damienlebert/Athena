<?php
namespace Athena\ChatBundle\Services;

use Doctrine\ORM\EntityManager;
use Athena\ChatBundle\Entity\LinkUsrConversation;
use Athena\ChatBundle\Entity\Message;
use Athena\UserBundle\Entity\User;
use Athena\ChatBundle\Entity\Conversation;

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
	 * Récupère tous les utilisateurs
	 */
	public function fetchAllUsers()
	{
	    $liste_users = $this->em->getRepository('AthenaUserBundle:User')
            	       ->findAll();
	    
	    return $liste_users;
	}
	
	/**
	 * Recherche des utilisateurs à partir du nom, du prénom ou du mail
	 * @param unknown $keyword
	 */
	public function findUsers($keyword)
	{
	    $liste_users = $this->em->getRepository('AthenaUserBundle:User')
	                   ->createQueryBuilder('u')
                       ->where('u.username like :keyword')
                       ->orWhere('u.firstName like :keyword')
                       ->orWhere('u.lastName like :keyword')
                       ->setParameter('keyword', '%'.$keyword.'%')
                       ->getQuery()
                       ->getResult();
	     
	    return $liste_users;
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
	 * Ajoute une conversation entre $userConnecte (objet User) et $userOther (id_user/number)
	 * @param User $userConnecte
	 * @param integer $userOther
	 */
	public function addConversation($userConnecte, $userOther)
	{
	    if(0 === (int) $userOther){
	        throw new \InvalidArgumentException("L'utilisateur n'existe pas.");
	    }	    
	    
		$conversation = new Conversation();
		$this->em->persist($conversation);
		$this->em->flush();

		$linkConversationUserConnecte = new LinkUsrConversation();
		$linkConversationUserConnecte->setStatut(1)
		                             ->setConversation($conversation)
		                             ->setUser($userConnecte);
		//Debug
		//\Doctrine\Common\Util\Debug::dump($linkConversationUserConnecte);
		
		$linkConversationUserOther = new LinkUsrConversation();
		$linkConversationUserOther->setStatut(1)
		                          ->setConversation($conversation)
		                          ->setUser($this->em->getRepository('AthenaUserBundle:User')->find($userOther));
		//Debug
		//\Doctrine\Common\Util\Debug::dump($linkConversationUserOther);
		
		$this->em->persist($linkConversationUserConnecte);
		$this->em->persist($linkConversationUserOther);
		$this->em->flush();
	}
	
	/**
	 * Désactive la conversation $id
	 * @param integer $idConversation
	 * @param integer $idUser
	 */
	public function disableConversation($idConversation, $idUser)
	{
	    $this->modifyConversationStatus($idConversation, $idUser, 0);
	}
	
	/**
	 * Active la conversation $id
	 * @param integer $idConversation
	 * @param integer $idUser
	 */
	public function enableConversation($idConversation, $idUser)
	{
	    $this->modifyConversationStatus($idConversation, $idUser, 1);
	}
	
	/**
	 * Modifie le statut d'une conversation
	 * 1 =  ouverte
	 * 0 = fermée
	 * @param integer $idConversation
	 * @param integer $idUser
	 * @param integer $statut
	 * @throws \InvalidArgumentException
	 */
	public function modifyConversationStatus($idConversation, $idUser, $statut)
	{
	    if(0 === (int) $idConversation){
	        throw new \InvalidArgumentException("La conversation n'existe pas.");
	    }
	    
	    if(0 === (int) $idUser){
	        throw new \InvalidArgumentException("L'utilisateur n'existe pas.");
	    }
	    
	    if($statut != 0 && $statut != 1){
	        throw new \InvalidArgumentException("Le statut de la conversation doit être 0 ou 1.");
	    }
	    
	    //LinkUsrConversation
	    $linkUsrConv = $this->em
                    	    ->getRepository('AthenaChatBundle:LinkUsrConversation')
                    	    ->find(array('conversation' => $idConversation, "user" => $idUser));
	     
	    
	    
	    $linkUsrConv->setStatut($statut);
	    
	    $this->em->persist($linkUsrConv);
	    $this->em->flush();
	}
	
	/**
	 * Ajoute un message à la conversation $idConversation, date courante et utilisateur connecté
	 * @param integer $idConversation
	 * @param User $user
	 * @param string $content
	 */
	public function addMessage($idConversation, User $user, $content)
	{
	    if(0 === (int) $idConversation){
	        throw new \InvalidArgumentException("La conversation n'existe pas.");
	    }
	    
		$message = new Message();
		$message->setContenu($content)
		        ->setConversation($idConversation)
		        ->setId_user($user)
		        ->setDate(new \DateTime("now"));
		
		$this->em->persist($message);
		$this->em->flush();
	}
	
	/**
	 * Récupère tous les messages de la conversation $idConversation
	 * @param integer $idConversation
	 */
	public function fetchAllMessages($idConversation)
	{
	    if(0 === (int) $idConversation){
	        throw new \InvalidArgumentException("La conversation n'existe pas.");
	    }
	    
	    return $this->em
	                ->getRepository('AthenaChatBundle:Message')
	                ->findAll(array("id_conversation" => $idConversation));
	}
	
	
	
}