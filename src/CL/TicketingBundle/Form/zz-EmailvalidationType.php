<?php
// src/CL/TicketingBundle/Form/EmailvalidationType.php

namespace CL\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;


class EmailvalidationType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder->add('email', RepeatedType::class, [
        'type' => EmailType::class,
        'invalid_message' => 'Ces deux champs doivent être identiques',
        // 'options' => ['attr' => ['class' => 'password-field']],
        'required' => true,
        'first_options'  => ['label' => 'Email'],
        'second_options' => ['label' => 'Confirmation de l\'email'],
        'constraints' => [
            new NotBlank(),
            new Email(),
         ],
      ]);
    }
}
