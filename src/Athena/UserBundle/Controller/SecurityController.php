<?php

namespace Athena\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseSecurity;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends BaseSecurity
{
    protected function renderLogin(array $data)
    {
        if ($this->container->get('security.context')->isGranted('ROLE_USER')) {
            return new RedirectResponse($this->container->get('router')->generate('default'));
        }
        return parent::renderLogin($data);

    }
}
