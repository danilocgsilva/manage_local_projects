<?php

namespace App\Form\Receipt;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReceiptType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('receipt', TextareaType::class, [
                'label' => 'Receipt'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Add new receipt'
            ])
        ;
    }
}
