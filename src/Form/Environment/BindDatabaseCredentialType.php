<?php

declare(strict_types=1);

namespace App\Form\Environment;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType, ChoiceType, CollectionType};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Environment;
use App\Entity\DatabaseCredentials;

class BindDatabaseCredentialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('databaseCredentials', ChoiceType::class, [
                'choices' => $options['database_credential_list'],
                'choice_label' => 'name',
                'data' => [],
                'expanded' => false,
                'label' => 'Database Credentials',
                'multiple' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Bind'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Environment::class,
            'database_credential_list' => null
        ]);
    }
}
