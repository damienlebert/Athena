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
    	
    	/*echo "<pre>";
    	 \Doctrine\Common\Util\Debug::dump($service->findUsers('DAM'));
    	 echo "</pre>";exit;*/
    	
    	$user = $this->get('security.context')->getToken()->getUser();
    	//$service->addMessage(1, $user, "Hello world!!!");
    	//$service->addConversation($user, 2);
    	echo "<pre>";
    	\Doctrine\Common\Util\Debug::dump($service->fetchAllMessages(1));
    	echo "</pre>";
    	//var_dump($service->enableConversation(1, 3));exit;
    	
    	return $this->render('AthenaChatBundle:Pages:sandbox.html.twig', array('test' => $service->findUsers('pierre')));
    } 
}