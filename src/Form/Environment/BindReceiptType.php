<?php

declare(strict_types=1);

namespace App\Form\Environment;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BindReceiptType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('receipts', ChoiceType::class, [
                'choices' => [
                    'receipt1' => 'receipt1',
                    'receipt2' => 'receipt2',
                ]
            ])
        ;
    }
}

