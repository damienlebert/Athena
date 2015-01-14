<?php

namespace Athena\ChatBundle\Controller;

use Athena\ChatBundle\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
    
    public function welcomeAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new UserType(), $user);

        if ($request->isMethod('post')) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $user = $form->getData();
                $em->persist($user);
                $em->flush();


            }
        }


        return $this->render(
            'AthenaChatBundle:Pages:index.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }
    
    
    public function usersAction()
    { 	
        $this->chatSvc = new Chat($this->getDoctrine()->getManager());

        $connectedUser = $this->get('security.context')->getToken()->getUser();

    	return $this->render('AthenaChatBundle:Pages:users.html.twig', array('msg' => $this->chatSvc->fetchAllUsers($connectedUser->getId())));
    }
}