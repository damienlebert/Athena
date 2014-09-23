<?php
namespace Athena\ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Athena\ChatBundle\Services\Chat;
//use Doctrine\Common\Util\Debug;

class SandboxController extends Controller
{
    public function welcomeAction()
    {
    	
    	$service = $this->container->get('athena_chat.chat');
    	/*echo "<pre>";
    	\Doctrine\Common\Util\Debug::dump($service->fetchAllConversations(3));
    	echo "</pre>";exit;*/
    	return $this->render('AthenaChatBundle:Pages:sandbox.html.twig', array('test' => $service->fetchAllConversations(3)));
    } 
}