<?php

declare(strict_types=1);

namespace App\Form\Deploy;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{ChoiceType, SubmitType, TextType};

use App\Entity\Deploy;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeployNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Alias to determine the deploy',
                'required' => true,
                'data' => $options['default_deploy_name']
            ])
            ->add('environments', ChoiceType::class, [
                'choices' => $options['environment_list'],
                'choice_label' => 'name',
                'label' => 'Environment',
                'expanded' => true,
                'multiple' => true,
                'data' => [],
            ])
            ->add('receipts', ChoiceType::class, [
                'choices' => $options['receipt_list'],
                'choice_label' => 'receipt',
                'label' => 'Receipt',
                'expanded' => true,
                'multiple' => true,
                'data' => [],
            ])
            ->add('fileSystemPath', TextType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Save'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Deploy::class,
            'environment_list' => null,
            'receipt_list' => null,
            'default_deploy_name' => ''
        ]);
    }
}
