<?php
// src/CL/TicketingBundle/Form/ContactType.php

namespace CL\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;



class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
      ->add('firstname', TextType::class,[
        // 'attr' => ['placeholder' => 'Votre prénom'],
        'required' => true,
        'label' => 'Prénom',
        'constraints' => [
            new NotBlank()
         ],
      ])
      ->add('lastname', TextType::class,[
        // 'attr' => ['placeholder' => 'Votre nom'],
        'required' => true,
        'label' => 'Nom',
        'constraints' => [
            new NotBlank()
         ],
      ])
      ->add('email', EmailType::class,[
        // 'attr' => ['placeholder' => 'Votre e-mail'],
        'required' => true,
        'label' => 'E-mail',
        'constraints' => [
            new NotBlank(),
            new Email()
         ],
      ])
      ->add('subject', TextType::class,[
        // 'attr' => ['placeholder' => 'Sujet'],
        'required' => true,
        'label' => 'Sujet de votre message',
        'constraints' => [
            new NotBlank()
         ],
      ])
      ->add('message', TextareaType::class,[
        'attr' => ['placeholder' => 'Votre message'],
        'required' => true,
        'label' => 'Votre message',
        'constraints' => [
            new NotBlank()
         ],
      ])
      ;

    }


    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'error_bubbling' => true
        ]);
    }



    public function getName()
    {
        return 'contact_form';
    }

}
