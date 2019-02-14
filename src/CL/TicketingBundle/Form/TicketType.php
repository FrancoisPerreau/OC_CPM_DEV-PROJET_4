<?php
// src/CL/TicketingBundle/Form/TicketType.php

namespace CL\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname', TextType::class, [
            'error_bubbling' => true,
            'required' => true,
            'label' => 'Prénom'
        ])
        ->add('lastname', TextType::class, [
            'error_bubbling' => true,
            'required' => true,
            'label' => 'Nom'
        ])
        ->add('country', CountryType::class, [
            'error_bubbling' => true,
            'required' => true,
            'label' => 'Pays',
            'preferred_choices' =>['FR']
        ])
        ->add('birthday', BirthdayType::class, [
            'error_bubbling' => true,
            'required' => true,
            'label' => 'Date de naissance'
        ])
        ->add('reducedPrice', CheckboxType::class, [
            'required' => false,
            'label' => 'Tarif réduit'
        ])
        // ->add('visitDate')
        // ->add('type')
        // ->add('code')
        // ->add('purchase')
        ;

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CL\TicketingBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cl_ticketingbundle_ticket';
    }


}
