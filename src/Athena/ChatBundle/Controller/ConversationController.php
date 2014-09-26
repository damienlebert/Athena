<?php

namespace Athena\ChatBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConversationController extends Controller implements ClassResourceInterface
{
    /**
     * @View()
     * Get all conversation
     * /conversation
     */
    public function cgetAction()
    {
        $service = $this->get('athena_chat.chat');
        return $service->fetchAllConversations(22);
    }

    /**
     * /conversations/{id}
     */
    public function getAction($slug)
    {
        return $slug;
    }



}