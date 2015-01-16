<?php

namespace Athena\ChatBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //parent::buildForm($builder, $options);
        $builder
            ->add('firstName', null, array('label' => 'Nom :', 'attr' => array('class' => 'form-control', 'placeholder' => 'Nom')))
            ->add('lastName', null, array('label' => 'Prénom :', 'attr' => array('class' => 'form-control', 'placeholder' => 'Prénom')))
            ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle', 'attr' => array('class' => 'form-control', 'placeholder' => 'E-Mail')))
            ->add('avatar', 'hidden', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'athena_user';
    }
}