<?php

namespace App\Form\Receipt;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType, TextareaType};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CaptureFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file_path', TextType::class, [
                'label' => 'File Path',
                'data' => $options['path_data']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Capture file'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'path_data' => null,
            ]
        );
    }
}