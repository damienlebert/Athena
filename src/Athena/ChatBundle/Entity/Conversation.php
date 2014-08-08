<?php 

namespace Athena\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="conversation")
 * @ORM\Entity(repositoryClass="Athena\ChatBundle\Entity\ConversationRepository")
 * 
 */
class Conversation
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
}