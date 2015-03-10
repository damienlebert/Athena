<?php

namespace Athena\ChatBundle\Controller;

use Athena\ChatBundle\Form\Type\ChangePasswordType;
use Athena\ChatBundle\Form\Type\UserType;
use FOS\UserBundle\Form\Type\ChangePasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Athena\UserBundle\Entity\UserRepository;
use Athena\ChatBundle\Services\Chat;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


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

        $formPassword = $this->createForm(new ChangePasswordType(get_class($user)), $user);

        if ($request->isMethod('post')) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $user = $form->getData();
                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Vos informations ont bien été mises à jour');
            } else {
                $this->get('session')->getFlashBag()->add('error', "Vos informations n'ont pas été mises à jour, vérifiez les données envoyées");
            }
        }


        return $this->render(
            'AthenaChatBundle:Pages:index.html.twig',
            array(
                'form' => $form->createView(),
                'formPassword' => $formPassword->createView(),
            )
        );
    }

    /**
     * Change user password
     */
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
//        $formFactory = $this->get('fos_user.change_password.form.factory');

//        $form = $formFactory->createForm();
        $form = $this->createForm(new ChangePasswordType(get_class($user)), $user);
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('default');
                $response = new RedirectResponse($url);
            }


            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Votre mot de passe n\'a pas été mise à jour, vérifiez les données envoyées.');
            $url = $this->generateUrl('default');
            return new RedirectResponse($url);
        }

    }
    
    
    public function usersAction()
    { 	
        $this->chatSvc = new Chat($this->getDoctrine()->getManager());

        $connectedUser = $this->get('security.context')->getToken()->getUser();

    	return $this->render('AthenaChatBundle:Pages:users.html.twig', array('msg' => $this->chatSvc->fetchAllUsers($connectedUser->getId())));
    }
}