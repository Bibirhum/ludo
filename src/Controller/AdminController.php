<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {

        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function displayUsers(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render('admin/admin_users.html.twig', [
            'users' => $users,
        ]);
    }
    //@IsGranted("IS_AUTHENTICATED_FULLY")

    /**
     * @Route("/admin/games", name="admin_games")
     */
    public function displayGames(GameRepository $gameRepository)
    {
        $games = $gameRepository->findAll();

        return $this->render('admin/admin_games.html.twig', [
            'games' => $games,
        ]);
    }
    //@IsGranted("IS_AUTHENTICATED_FULLY")

}
