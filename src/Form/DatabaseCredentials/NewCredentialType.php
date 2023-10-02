<?php

namespace App\Form\DatabaseCredentials;

use App\Entity\DatabaseCredentials;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewCredentialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', TextType::class)
            ->add('password', TextType::class)
            ->add('host', TextType::class)
            ->add('port', TextType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Add'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DatabaseCredentials::class
        ]);
    }
}
