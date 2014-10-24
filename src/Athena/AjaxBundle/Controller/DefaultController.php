<?php

namespace Athena\AjaxBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {

        if($this->getRequest()->isXmlHttpRequest()) {
            return $this->render('AthenaAjaxBundle:Default:index.html.twig', array('name' => "Hello XHR"));
        } else {
            return $this->render('AthenaAjaxBundle:Default:index.html.twig', array('name' => $name));
        }

    }

    /**
     * @View()
     *
     * @Get("/conversations")
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
     * @Get("/conversations/add")
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
     * @Get("/messages/add")
     */
    public function addMessage()
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
