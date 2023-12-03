<?php


declare(strict_types=1);

namespace App\Form\Something;

use Symfony\Component\Form\AbstractType;
use Some\Namespace;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YourEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('submit', SubmitType::class, [
                'label' => options['submit_label']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Environment::class
        ]);

        $resolver->setRequired([
            'submit_label'
        ]);
    }
}
