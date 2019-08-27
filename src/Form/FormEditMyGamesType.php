<?php

namespace App\Form;

use App\Entity\UserGameAssociation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormEditMyGamesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rating', IntegerType::class, ['label' => 'Votre note'])
            ->add('commentary', TextareaType::class, ['label' => 'Votre commentaire'])

            ->add('playsGame',ChoiceType::class, 
                 [
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => [
                    'yes' => 1,
                    'no' => 0],
                'label' => 'jouez vous au jeu?'])

            ->add('ownsGame',ChoiceType::class, 
                [
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => [
                    'yes' => 1,
                    'no' => 0],
                'label' => 'possedez vous le jeu?'])

            ->add('submit', SubmitType::class, ['label' => 'Soumettre'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserGameAssociation::class,
        ]);
    }
}
