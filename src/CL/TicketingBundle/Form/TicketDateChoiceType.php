<?php
// src/CL/TicketingBundle/Form/TicketDateChoiceType.php

namespace CL\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

// use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class TicketDateChoiceType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ticketDate', TextType::class, [
              'error_bubbling' => true,
              'required' => true,
              'label' => 'Date'
            ])
            ->add('ticketDayType', ChoiceType::class, [
              'error_bubbling' => true,
              'required' => true,
              'label' => 'Type de billet',
              'choices' => [
                'Journée' => 0,
                'Demi-journée' => 1
              ]
            ])
            ->add('TicketNb', ChoiceType::class, [
              'error_bubbling' => true,
              'required' => true,
              'label' =>'Nombre de billet(s)',
              'choices' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
                '6' => 6,
                '7' => 7,
                '8' => 8,
                '9' => 9
              ]
            ])
            // ->add('save', SubmitType::class)
        ;
    }
}
