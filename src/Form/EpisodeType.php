<?php

namespace App\Form;

use App\Entity\Episode;
use App\Entity\Season;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EpisodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('number', IntegerType::class)
            ->add('synopsis', TextType::class)
            ->add('season', EntityType::class, [
                'class' => Season::class,
                'choice_label' => function (Season $season) {
                    return $season->getProgram()->getTitle() . ' - season # ' . $season->getNumber();
                },
                'label' => 'Season'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Episode::class,
        ]);
    }
}
/*->add('season', EntityType::class, [
    'class' => Season::class,
    'choice_label' => function (Season $season) {
        return $season->getProgram()->getTitle() . ' - Saison ' . $season->getNumber();
    },
    'label' => 'Saison'
])*/