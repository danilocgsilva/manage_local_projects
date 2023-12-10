<?php

declare(strict_types=1);

namespace App\Form\Deploy;

use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{TextType, SubmitType};
use App\Entity\Deploy;

class DeployEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fileSystemProjectPath', TextType::class)
            ->add('dockerVolumeMountPath', TextType::class, [
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Atualizar'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Deploy::class,
            'currentFileSystemPathValue' => ''
        ]);
    }
}
