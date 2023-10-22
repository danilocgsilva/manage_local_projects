<?php

declare(strict_types=1);

namespace App\Form\Environment;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{ChoiceType, SubmitType};
use Symfony\Component\OptionsResolver\OptionsResolver;

class BindReceiptType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('receipts', ChoiceType::class, [
                'choices' => $options['choices']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Add Environment'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('choices');
    }
}

