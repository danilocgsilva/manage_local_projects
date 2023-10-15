<?php

declare(strict_types=1);

namespace App\Form\GitAddress;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType, TextareaType};

class EnvironmentFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('path', TextType::class, [
                'label' => 'Path'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Content',
                'attr' => [
                    "rows" => 20
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Add a file to the receipt'
            ])
        ;
    }

    
    // public function configureOptions(OptionsResolver $resolver): void
    // {
    //     $resolver->setRequired([
    //         'project_name'
    //     ]);
    // }
}
