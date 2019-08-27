<?php
namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Form\EditUserProfileType;
use App\Controller\UserController;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use App\Entity\UserGameAssociation;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserGameAssociationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserProfileController extends AbstractController
{
    /**
     * @Route("/user/profile", name="user_profile")
     */
    public function index(
        UserRepository $userRepository,
    UserGameAssociationRepository $userGameRepository,
    //UserGameAssociation $userGameAssociation,
    GameRepository $gameRepository
    //Game $game)
    )
    {
        $user = $this->getUser();
        $userGames = $userGameRepository->findBy(
            ['users' => $user]);
        
        //$gameName = $userGames->getGames()->getName();

        // $games = $gameRepository->findBy([
        //     ['associated_users' => $user]
        // ]);

        //$games = $user->getAssociatedGames();
        
         return $this->render('user_profile/index.html.twig', [
             'user' => $user,
             //'games' => $games,
             'user_game' => $userGames,
         ]);
    }

    // public function showUserGames(
        
    //     UserGameAssociationRepository $userGameRepository,
    //      UserGameAssociation $userGameAssociation,
    //      GameRepository $gameRepository,
    //      Game $game
    //     // UserRepository $userRepository,
    //     // User $user
    // )
    // {
    //     $currentUser = $this->getUser ();

    //     $userGames = $userGameRepository->findBy(
    //         array('users' => $currentUser));
    //     $games = $userGames->getGames();
    //     return $this->render('user_games/user_games_collection.html.twig', [
    //         'user' => $currentUser,
    //         'games' => $games
    //     ]);
    // }

// Modification du profil par l'utilisateur
    /**
     * @Route("/user/edit_profile", name="edit_user_profile")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function editUser (
        ObjectManager $objectManager,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
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

                $user->setPassword(
                     $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
    
            
    

                $objectManager->persist($user);
                $objectManager->flush();
                
                return $this->redirectToRoute('user_profile');
    
            }
    
            return $this->render('user_profile/edit_user_profile.html.twig', [
                'edit_user_form' => $form->createView(),
            ]);
        }


      
    

}
