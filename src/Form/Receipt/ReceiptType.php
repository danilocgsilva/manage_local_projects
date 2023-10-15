<?php

namespace App\Form\Receipt;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType};
use Symfony\Component\Form\FormBuilderInterface;

class ReceiptType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('receipt', TextType::class, [
                'label' => 'Receipt name (eg.: production, test, local, dev, qa, anything else)'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Add new receipt'
            ])
        ;
    }
}
