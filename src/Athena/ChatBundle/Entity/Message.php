<?php

namespace Athena\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="Message")
 * @ORM\Entity(repositoryClass="Athena\ChatBundle\Entity\MessageRepository")
 *
 */
class Message
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /** @ORM\Column(name="contenu", type="string", length=255, nullable=true) */
    protected $contenu;
    
    protected $date;

}