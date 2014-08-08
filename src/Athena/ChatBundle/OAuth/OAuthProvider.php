<?php
namespace Athena\ChatBundle\OAuth;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Athena\ChatBundle\Entity\User;

class OAuthProvider extends OAuthUserProvider
{
    protected $session, $doctrine, $admins;
    public function __construct($session, $doctrine, $service_container)
    {
        $this->session = $session;
        $this->doctrine = $doctrine;
        $this->container = $service_container;
    }
    public function loadUserByUsername($username)
    {
        $user = new User();
        $this->session->get('email');
        $this->session->get('nickname');
        $this->session->get('realname');
        $this->session->get('avatar');
    }
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {

        //Data from Google response
        $google_id = $response->getUsername(); /* An ID like: 112259658235204980084 */
        $email = $response->getEmail();
        $nickname = $response->getNickname();
        $realname = $response->getRealName();
        $avatar = $response->getProfilePicture();
        //set data in session
        $this->session->set('email', $email);
        $this->session->set('nickname', $nickname);
        $this->session->set('realname', $realname);
        $this->session->set('avatar', $avatar);

        $user = new User();
        $user->setLogin($email);
        $user->setNom($nickname);

        return $user;

    }
    public function supportsClass($class)
    {
        return $class === 'Athena\\ChatBundle\\Entity\\User';
    }

    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation if it decides to reload the user data
     * from the database, or if it simply merges the passed User into the
     * identity map of an entity manager.
     *
     * @throws UnsupportedUserException if the account is not supported
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user) {
        var_dump($user);
        
        return $user;
    }
}