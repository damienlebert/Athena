<?php

namespace Athena\ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Athena\UserBundle\Entity\UserRepository;

class ChatController extends Controller
{
    public function welcomeAction()
    {
        return $this->render('AthenaChatBundle:Pages:index.html.twig');
    }
    
    
    public function usersAction()
    {
    	
    	$liste_users = $this->getDoctrine()
                         ->getManager()
                         ->getRepository('AthenaUserBundle:User')
                         ->findAll();
    	
    	return $this->render('AthenaChatBundle:Pages:users.html.twig', array('msg' => $liste_users));
    }
}