<?php


declare(strict_types=1);

namespace App\Form\Project;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType, ChoiceType};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Environment;
use App\Entity\Project;

class BindEnvironmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('environment', ChoiceType::class, [
                'choices' => $options['environments_list'],
                'choice_label' => 'name',
                'label' => 'Choose environments to bind',
                'expanded' => true,
                'multiple' => true,
                'data' => [],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Bind'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            'environments_list' => null,
        ]);
    }
}
