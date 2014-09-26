<?php

namespace Athena\ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Athena\UserBundle\Entity\UserRepository;
use Athena\ChatBundle\Services\Chat;

class ChatController extends Controller
{
    
    protected $chatSvc;
    
    public function preExecute()
    {
        // Le code écrit ici sera executé avant chacune des actions de ce controlleur.
        $this->chatSvc = new Chat($this->getDoctrine()->getManager());
    }
    
    public function welcomeAction()
    {
        return $this->render('AthenaChatBundle:Pages:index.html.twig');
    }
    
    
    public function usersAction()
    { 	
        $this->chatSvc = new Chat($this->getDoctrine()->getManager());
    	return $this->render('AthenaChatBundle:Pages:users.html.twig', array('msg' => $this->chatSvc->fetchAllUsers()));
    }
}