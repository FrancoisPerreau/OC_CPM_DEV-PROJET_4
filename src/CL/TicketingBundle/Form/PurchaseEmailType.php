<?php
// ssrc/CL/TicketingBundle/Form/PurchaseEmailType.php

namespace CL\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;


class PurchaseEmailType extends AbstractType
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
          // 'options' => ['attr' => ['class' => 'password-field']],
          'required' => true,
          'first_options'  => ['label' => 'Email'],
          'second_options' => ['label' => 'Confirmation de l\'email'],
          // 'constraints' => [
          //     new NotBlank(),
          //     new Email(),
          //  ],
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
