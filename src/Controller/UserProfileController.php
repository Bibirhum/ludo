<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserProfileType;
use App\Controller\UserController;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserProfileController extends AbstractController
{
    /**
     * @Route("/user/profile", name="user_profile")
     */
    public function index(UserRepository $userRepository)
    {
        $user = $this->getUser();
        return $this->render('user_profile/index.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * @Route("/user/edit_profile", name="edit_user_profile")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function editUser (
        ObjectManager $objectManager,
        Request $request
        // User $user = null
        )
    {   
        $user = $this->getUser();
        $form = $this->createForm(EditUserProfileType::class,$user);
    
            $form->handleRequest($request);
    
           
    
            if ($form->isSubmitted() && $form->isValid()) {
                // $avatar = $form['avatar']->getData();
                // $bio = $form['bio']->getData();
               
                if ($user->getAvatarFile() !== null) {

                $avatarFile = $user->getAvatarFile();
                $folder='uploads/avatar';
                $filename = uniqid();
                $avatarFile-> move($folder,$filename);
                $user->setAvatar($folder.DIRECTORY_SEPARATOR.$filename);
                }

                $objectManager->persist($user);
                $objectManager->flush();
                
                return $this->redirectToRoute('user_profile');
    
            }
    
            return $this->render('user_profile/edit_user_profile.html.twig', [
                'edit_user_form' => $form->createView(),
            ]);
        }

}
