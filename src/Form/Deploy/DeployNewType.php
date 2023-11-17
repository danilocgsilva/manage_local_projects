<?php

declare(strict_types=1);

namespace App\Form\Deploy;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{ChoiceType, SubmitType};

use App\Entity\Deploy;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeployNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('environments', ChoiceType::class, [
                'choices' => $options['environment_list']
            ])
            ->add('receipts', ChoiceType::class, [
                'choices' => $options['receipt_list']
            ])
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
            'receipt_list' => null
        ]);
    }
}
