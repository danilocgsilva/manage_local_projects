<?php

namespace App\Form\Receipt;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType};
use Symfony\Component\Form\FormBuilderInterface;

class RemoveReceiptType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('submit', SubmitType::class, [
                'label' => 'Yes, I am pretty sure!!!',
                'attr' => [
                    'class' => 'btn-danger btn',
                ],
            ])
        ;
    }
}
