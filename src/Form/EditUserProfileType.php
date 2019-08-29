<?php
namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class EditUserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => 'Pseudo'])
            ->add('first_name', TextType::class, ['label' => "Prénom"])
            ->add('last_name', TextType::class, ['label' => 'Nom'])
            ->add('email', EmailType::class, ['label' => 'Adresse email'])
            ->add('bio', TextareaType::class, ['label' => 'Bio'])
            ->add('avatarFile', FileType::class, array('label'=>'Avatar','data_class' =>null,'required' =>false)) //[
                // 'label' =>'Votre avatar (.jpg, .png, .jpeg)',
                // 'mapped'=> false,
                //'required'=> false,
                // 'constraints' => [
                //     new File([
                //         'maxSize' => '2000k',
                //         'mimeTypes' => [
                //             'application/jpg',
                //             'application/png',
                //             'application/jpeg'
                //         ],
                //         'mimeTypesMessage' => 'Veuillez charger une image valide .png, .jpg. ou .jpeg de 2Mo maximum',
                //     ])
                // ],

            //]) //fin add 'avatar'
            ->add('address', TextareaType::class, ['label' => 'Adresse'])
            ->add('zip_code', TextType::class, ['label' => 'Code Postal'])
            ->add('city', TextType::class, ['label' => 'Ville'])
            ->add('submit', SubmitType::class, ['label' => 'Je valide !'])
            
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}