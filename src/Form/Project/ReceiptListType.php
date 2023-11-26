<?php

namespace App\Form\Project;

use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{ChoiceType, SubmitType};
use App\Entity\Receipt;

class ReceiptListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('receipt', ChoiceType::class, [
                'choices'  => $options['receipt_list'],
                'label' => $options['label']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'receipt_list' => null,
            'data_class' => Receipt::class
        ]);
    }
}