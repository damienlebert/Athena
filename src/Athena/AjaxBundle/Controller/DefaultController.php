<?php

namespace Athena\AjaxBundle\Controller;

use Athena\ChatBundle\Entity\Conversation;
use Athena\ChatBundle\Entity\Message;
use Athena\UserBundle\Entity\User;
use Symfony\Component\Finder\Finder;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;


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

//    /**
//     * @View()
//     *
//     */
//    public function conversationsAction()
//    {
//        $service = $this->get('athena_chat.chat');
//
//        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
//            $connectedUser = $this->get('security.context')->getToken()->getUser();
//            return $service->fetchAllConversations($connectedUser->getId());
//
//        } else {
//            return null;
//        }
//    }

    /**
     * @View()
     *
     * @GET("/conversation/get/{idOther}", options={"expose"=true})
     */
    public function getConversationAction($idOther)
    {



        $service = $this->get('athena_chat.chat');

//        if($this->getRequest()->isXmlHttpRequest()) {
            if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $connectedUser = $this->get('security.context')->getToken()->getUser();
                $conversation = $service->findConversationByTwoUsers($connectedUser, $idOther);

                $service->enableConversation($conversation->getId_conversation(), $connectedUser->getId());
                $service->enableConversation($conversation->getId_conversation(), $idOther);

//                var_dump($conversation);exit;
                return $conversation;
            } else {
                return null;
            }
//        }
    }

    /**
     * @View()
     *
     * @GET("/conversation/remove/{idConversation}", options={"expose"=true})
     */
    public function removeConversationAction($idConversation)
    {

        $service = $this->get('athena_chat.chat');

        if($this->getRequest()->isXmlHttpRequest()) {
            if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $connectedUser = $this->get('security.context')->getToken()->getUser();
                $service->disableConversation($idConversation, $connectedUser->getId());
                return true;
            } else {
                return false;
            }
        }

    }

//    /**
//     * @View()
//     *
//     */
//    public function addConversationAction()
//    {
//        $service = $this->get('athena_chat.chat');
//
//        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
//            $connectedUser = $this->get('security.context')->getToken()->getUser();
//            return $service->fetchAllConversations($connectedUser->getId());
//        } else {
//            return null;
//        }
//    }

    /**
     * @View()
     *
     * @POST("/messages/add/{idConversation}", name="athena_ajax_new_message", options={"expose"=true})
     */
    public function addMessageAction(Request $request, $idConversation)
    {
        $service = $this->get('athena_chat.chat');

        if($this->getRequest()->isXmlHttpRequest()) {
            if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $connectedUser = $this->get('security.context')->getToken()->getUser();
                $conversation = $service->findConversation($idConversation);

                $message = $request->request->get('message');

                if ($conversation instanceof Conversation && !empty($message)) {
                    $messageObj = new Message();
                    $messageObj->setContenu($message)
                        ->setConversation($conversation)
                        ->setDate(new \DateTime('now'))
                        ->setId_user($connectedUser);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($messageObj);
                    $em->flush();

                } else {
                    throw new \Exception("La conversion n'a pas été trouvée");
                }

            } else {
                throw new \Exception("Vous devez vous connecter!");
            }
        }
    }

    /**
     * @View()
     *
     * @Get("/user/search/{search}", options={"expose"=true}, defaults={"search"=null})
     */
    public function searchUserAction(Request $request, $search)
    {
        $service = $this->get('athena_chat.chat');
        if($this->getRequest()->isXmlHttpRequest()) {
            if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {

                return $service->findUsers($search, $this->getUser());

            }
        }
    }

    /**
     * @View()
     *
     * @GET("/avatars/list")
     */
    public function getAvatarsAction(Request $request)
    {
        if($this->getRequest()->isXmlHttpRequest()) {
            if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $user = $this->get('security.context')->getToken()->getUser();
                $fichiers = array();

                $finder = new Finder();
                $finder->files()->in('/home/www/athena/web/bundles/athenachat/images/avatars');
                foreach ($finder as $file) {
                    $filename = $file->getFilename();
                    $fichiers[] = array(
                        'value' => $filename,
                        'selected' => ($filename == $user->getAvatar()),
                        'imageSrc' => "/bundles/athenachat/images/avatars/" . $filename
                    );
                }

                return $fichiers;
            }
        }
    }




}
