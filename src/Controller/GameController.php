<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Repository\GameRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/admin/games", name="user_games")
     */
    public function userGames(
        GameRepository $gameRepository,
        User $user)
    {
        // A COMPLETER
        $games = $gameRepository->findAll();

        return $this->render('admin/admin_games.html.twig', [
            'games' => $games,
        ]);
    }

     /**
     * @Route("/game/add", name="add_game")
     * @Route("/game/edit/{id<\d+>}", name="edit_game")
     */
    public function editGame(
        ObjectManager $objectManager,
        Game $game,
        Request $request
    )
    {
        // TODO :
        if ($game === null) {
            $game = new Game();
        }



        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }

    /**
     * @Route("/game/delete/{id<\d+>}", name="delete_game")
     */
    // TODO : l'utilisateur doit être connecté pour pouvoir accéder à cette page
    // d'où l'annotation IsGranted
    public function deleteGame(
        Game $game,
        ObjectManager $objectManager
    )
    {
        // on supprime le produit
        $objectManager->remove($game);
        $objectManager->flush();
        // on redirige vers la liste des produits
        return $this->redirectToRoute('admin_games');
    }
}
