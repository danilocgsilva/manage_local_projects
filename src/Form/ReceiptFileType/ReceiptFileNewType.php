<?php

namespace App\Form\Receipt;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType, TextareaType};
use Symfony\Component\Form\FormBuilderInterface;

class ReceiptFileNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('path', TextType::class, [
                'label' => 'Path',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'File Content',
                'attr' => [
                    'rows' => 25
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Create new receipt file'
            ]);
        ;
    }
}