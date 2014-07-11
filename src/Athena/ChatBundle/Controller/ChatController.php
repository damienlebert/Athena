<?php

namespace Athena\ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChatController extends Controller
{
    public function welcomeAction()
    {
        return $this->render('AthenaChatBundle:Pages:index.html.twig');
    }
}