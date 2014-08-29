<?php

namespace Athena\ChatBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Routing\ClassResourceInterface;

class ConversationController implements ClassResourceInterface
{
    /**
     * Get all conversation
     * /conversation
     */
    public function cgetAction()
    {
        return array('lalalalalala');
    }

    /**
     * /conversations/{id}
     */
    public function getAction($slug)
    {
        return $slug;
    }



}