<?php

namespace App\Form;

use App\Entity\Support;
use App\Models\SupportModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', ChoiceType::class, [
                'choices' => [
                    'DVD' => 'DVD',
                    'Blu-Ray' => 'Blu-Ray',
                    'Blu-Ray 3D' => 'Blu-Ray 3D',
                    'Blu-Ray 4K' => 'Blu-Ray 4K',
                    'HD-DVD' => 'HD-DVD',
                    'Laser Disc' => 'Laser Disc',
                    'VHS' => 'VHS',
                    'DivX' => 'DivX',
                ]
            ])
            ->add('idMovie', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data-class' => SupportModel::class
        ]);
    }
}
