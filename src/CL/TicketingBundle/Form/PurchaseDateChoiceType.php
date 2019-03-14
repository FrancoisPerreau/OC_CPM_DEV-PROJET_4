<?php
// src/CL/TicketingBundle/Form/PurchaseDateChoiceType.php

namespace CL\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;


class PurchaseDateChoiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', RepeatedType::class, [
          'type' => EmailType::class,
          'invalid_message' => 'Ces deux champs doivent être identiques',
          'required' => true,
          'first_options'  => ['label' => 'E-mail'],
          'second_options' => ['label' => 'Confirmation de l\'e-mail'],
          'constraints' => [
              new NotBlank(),
              new Email(),
           ]
        ])
        ->add('visitDate', TextType::class, [
          'required' => true,
          'label' => 'Date',

        ])
        ->add('visitType', ChoiceType::class, [
          'required' => true,
          'label' => 'Type de billet',
          'choices' => [
            'Journée' => 0,
            'Demi-journée' => 1
          ]
        ])
        ->add('ticketNb', ChoiceType::class, [
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
        ->remove('createdAt')
        ->remove('code')
        ->remove('price')
        ->remove('tickets')
        ->remove('stripeChargeId')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CL\TicketingBundle\Entity\Purchase',
            // 'csrf_protection' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cl_ticketingbundle_purchase';
    }

}
