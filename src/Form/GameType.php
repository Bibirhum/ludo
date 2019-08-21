<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du jeu'
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Choisir une image'
            ])
            ->add('theme', TextType::class, [
                'label' => 'Thème du jeu',
                'required' => false,
            ])
            ->add('short_description', TextType::class, [
                'label' => 'Présentation du jeu'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du jeu',
                'required' => false,
            ])
            ->add('numPlayerMin', IntegerType::class, [
                'label' => 'Nombre minimal de joueurs'
            ])
            ->add('numPlayerMax', IntegerType::class, [
                'label' => 'Nombre maximal de joueurs'
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée d\'une partie en minutes'
            ])
            ->add('ageMin', IntegerType::class, [
                'label' => 'Âge minimum'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Choisir une catégorie',
            ])
            ->add('submit', SubmitType::class, ['label' => 'Envoyer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
