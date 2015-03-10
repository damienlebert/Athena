<?php

namespace Athena\ChatBundle\Form\Type;

use FOS\UserBundle\Form\Type\ChangePasswordFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ChangePasswordType extends ChangePasswordFormType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('current_password', 'password', array(
            'label' => 'form.current_password',
            'attr' => array('class' => 'form-control', 'placeholder' => 'Mot de passe actuel'),
            'translation_domain' => 'FOSUserBundle',
            'mapped' => false,
            'constraints' => new UserPassword(),
        ));
        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => 'Nouveau mot de passe :', 'attr' => array('class' => 'form-control', 'placeholder' => 'Nouveau mot de passe')),
            'second_options' => array('label' => 'Répétez :', 'attr' => array('class' => 'form-control', 'placeholder' => 'Répétez le nouveau mot de passe')),
            'invalid_message' => 'fos_user.password.mismatch',
        ));
    }


}