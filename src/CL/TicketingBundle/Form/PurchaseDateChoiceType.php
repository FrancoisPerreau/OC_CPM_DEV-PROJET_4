<?php
// src/CL/TicketingBundle/Form/PurchaseDateChoiceType.php

namespace CL\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class PurchaseDateChoiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('visitDate', TextType::class, [
          'required' => true,
          'label' => 'Date',
          // 'constraints' => [
          //     new NotBlank(),
          //     new IsOpen(),
          //     new EntireDay()
          //  ],

        ])
        ->add('visitType', ChoiceType::class, [
          'required' => true,
          'label' => 'Type de billet',
          'choices' => [
            'Journée' => 0,
            'Demi-journée' => 1
          ],
          // 'constraints' => [
          //     new NotBlank(),
          //     new Choice([0, 1])
          //  ],
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
          ],
          // 'constraints' => [
          //     new NotBlank(),
          //     new Choice([0, 1, 2, 3, 4, 5, 6, 7, 8, 9])
          //  ]
        ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CL\TicketingBundle\Entity\Purchase',
            // 'cascade_validation' => true
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
