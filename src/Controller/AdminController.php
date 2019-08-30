<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(UserRepository $userRepository)
    {
        $user = $this->getUser();
        return $this->render('admin/admin.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/users", name="admin_users")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function displayUsers(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render('admin/admin_users.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/user/{id<\d+>}", name="admin_one_user")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function editUser(
        Request $request,
        ObjectManager $objectManager,
        UserPasswordEncoderInterface $passwordEncoder,
        User $user = null
    )
    {
        if ($user === null) {
            $user = new User();
        }

        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $userForm->get('password')->getData()
                )
            );
            // on met à jour le joueur dans la BDD
            $objectManager->persist($user);
            $objectManager->flush();

            // msg flash confirmation
            $this->addFlash(
                'success',
                'Le joueur a bien été mis à jour !'
            );
            // on redirige vers la page d'administration des joueurs
             return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/admin_one_user.html.twig', [
            'user_form' => $userForm->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/delete_user/{id<\d+>}", name="delete_user")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    // l'utilisateur doit être connecté pour pouvoir accéder à cette page d'où l'annotation IsGranted
    public function deleteUser(
        User $user,
        ObjectManager $objectManager
    )
    {
        // on supprime le joueur
        $objectManager->remove($user);
        $objectManager->flush();
        // msg flash confirmation
        $this->addFlash(
            'success',
            'Le joueur a bien été supprimé !'
        );
        // on redirige vers la liste des joueurs
        return $this->redirectToRoute('admin_users');
    }

    /**
     * @Route("/admin/games", name="admin_games")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function displayGames(GameRepository $gameRepository)
    {
        $games = $gameRepository->findAll();

        return $this->render('admin/admin_games.html.twig', [
            'games' => $games,
        ]);
    }

    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function displayCategories(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/category.html.twig', [
            'categories' => $categories,
        ]);
    }

}
