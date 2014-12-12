<?php

namespace Athena\AjaxBundle\Controller;

use Athena\UserBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;

class DefaultController extends FOSRestController
{

    /**
     * @View()
     *
     * @Get("/hello/{name}", name="athena_ajax_index")
     */
    public function indexAction($name)
    {

        if($this->getRequest()->isXmlHttpRequest()) {
            return $this->render('AthenaAjaxBundle:Default:index.html.twig', array('name' => " XHR"));
        } else {
            return $this->render('AthenaAjaxBundle:Default:index.html.twig', array('name' => $name));
        }

    }

    /**
     * @View()
     *
     */
    public function conversationsAction()
    {
        $service = $this->get('athena_chat.chat');

        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $connectedUser = $this->get('security.context')->getToken()->getUser();
            return $service->fetchAllConversations($connectedUser->getId());

        } else {
            return null;
        }
    }

    /**
     * @View()
     *
     * @GET("/conversation/get/{idOther}")
     */
    public function getConversationAction($idOther)
    {
        $service = $this->get('athena_chat.chat');

        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $connectedUser = $this->get('security.context')->getToken()->getUser();
            $conversation = $service->findConversationByTwoUsers($connectedUser, $idOther);

            $service->enableConversation($conversation->getId_conversation(), $connectedUser->getId());
            $service->enableConversation($conversation->getId_conversation(), $idOther);

            return $conversation;

        } else {
            return null;
        }
    }

    /**
     * @View()
     *
     * @GET("/conversation/remove/{idConversation}")
     */
    public function removeConversationAction($idConversation)
    {

        $service = $this->get('athena_chat.chat');

        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $connectedUser = $this->get('security.context')->getToken()->getUser();
            $service->disableConversation($idConversation, $connectedUser->getId());
            return true;
        } else {
            return false;
        }

    }

    /**
     * @View()
     *
     */
    public function addConversationAction()
    {
        $service = $this->get('athena_chat.chat');

        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $connectedUser = $this->get('security.context')->getToken()->getUser();
            return $service->fetchAllConversations($connectedUser->getId());
        } else {
            return null;
        }
    }

    /**
     * @View()
     *
     */
    public function addMessageAction()
    {
        $service = $this->get('athena_chat.chat');

        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $connectedUser = $this->get('security.context')->getToken()->getUser();
            return $service->fetchAllConversations($connectedUser->getId());
        } else {
            return null;
        }
    }

}
