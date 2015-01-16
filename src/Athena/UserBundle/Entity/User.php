<?php

namespace Athena\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Athena\ChatBundle\Entity\Conversation;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;

/**
 * User
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="Athena\UserBundle\Entity\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="This email is already in use.",
 *     groups={"AthenaRegistration"} 
 * )
 * @ExclusionPolicy("none")
 */
class User  extends BaseUser
{

    public function __construct()
    {
        parent::__construct();
        $this->user_conversation = new ArrayCollection();
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(name="facebookId", type="string", length=255, nullable=true) */
    protected $facebookId;
 
    /** @ORM\Column(name="facebookAccessToken", type="string", length=255, nullable=true) */
    protected $facebookAccessToken;
 
    /** @ORM\Column(name="googleId", type="string", length=255, nullable=true) */
    protected $googleId;
 
    /** @ORM\Column(name="googleAccessToken", type="string", length=255, nullable=true) */
    protected $googleAccessToken;

    /** @ORM\Column(name="avatar", type="string", length=255, nullable=true, options={"default":"avatar.png"}) */
    protected $avatar;

    /** @ORM\Column(name="firstName", type="string", length=255, nullable=true) 
     *
     * @Assert\NotBlank(message="Entrez votre nom s'il vous plait.", groups={"AthenaRegistration", "Profile"})
     * @Assert\Length(
     *     min="3",
     *     max="25",
     *     minMessage="Le prénom est trop long.",
     *     maxMessage="Le prénom est trop long.",
     *     groups={"AthenaRegistration", "Profile"}
     * )
     */
    protected $firstName;

    /** @ORM\Column(name="lastName", type="string", length=255, nullable=true) 
     *
     * @Assert\NotBlank(message="Entrez votre prénom s'il vous plait.", groups={"AthenaRegistration"})
     * @Assert\Length(
     *     min="3",
     *     max="25",
     *     minMessage="Le nom est trop long.",
     *     maxMessage="Le nom est trop long.",
     *     groups={"AthenaRegistration", "Profile"}
     * )
     */
    protected $lastName;

    /** 
     * @Assert\NotBlank(message="Entrez votre mot de passe s'il vous plait.", groups={"AthenaRegistration"})
     * @Assert\Length(
     *     min="6",
     *     max="15",
     *     minMessage="Le mot de passe doit contenir au moins 6 caractères.",
     *     maxMessage="Le nom est trop long.",
     *     groups={"AthenaRegistration", "Profile"}
     * )
     */
    protected $plainPassword;
    
    /**
     * @ORM\OneToMany(targetEntity="Athena\ChatBundle\Entity\LinkUsrConversation", mappedBy="user", cascade={"persist", "remove"})
     * @Exclude
     */
    protected $user_conversation;


    public function setEmail($email)
    {
        parent::setEmail($email);
        $this->setUsername($email);
    }      

    /**
     * Gets the value of googleId.
     *
     * @return mixed
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }
    
    /**
     * Sets the value of googleId.
     *
     * @param mixed $googleId the google id 
     *
     * @return self
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Gets the value of googleAccessToken.
     *
     * @return mixed
     */
    public function getGoogleAccessToken()
    {
        return $this->googleAccessToken;
    }
    
    /**
     * Sets the value of googleAccessToken.
     *
     * @param mixed $googleAccessToken the google access token 
     *
     * @return self
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->googleAccessToken = $googleAccessToken;

        return $this;
    }

    /**
     * Gets the value of avatar.
     *
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
    
    /**
     * Sets the value of avatar.
     *
     * @param mixed $avatar the avatar 
     *
     * @return self
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Gets the value of firstName.
     *
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    /**
     * Sets the value of firstName.
     *
     * @param mixed $firstName the first name 
     *
     * @return self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Gets the value of lastName.
     *
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * Sets the value of lastName.
     *
     * @param mixed $lastName the last name 
     *
     * @return self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }
    
    /**
     * Returns all the user's conversations
     * @return array of Conversation
     */
    public function getConversations()
    {

    	return array_map(
    			function ($usr_conversation) {
    				return $usr_conversation->getConversation();
    			},
    			$this->user_conversation->toArray()
    	);

    }

    public function getFullname()
    {
        return ucfirst($this->lastName) . ' ' . ucfirst($this->firstName);
    }

}
