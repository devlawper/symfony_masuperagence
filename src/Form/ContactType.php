<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstName', TextType::class, [
            'label' => 'Prénom'
        ])
        ->add('lastName', TextType::class, [
            'label' => 'Nom'
        ])
        ->add('phone', TextType::class, [
            'label' => 'Téléphone'
        ])
        ->add('email', TextType::class, [
            'label' => 'Email'
        ])
        ->add('message', TextareaType::class, [
            'label' => 'Message'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
