<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\UserGameAssociation;
use App\Repository\GameRepository;
use App\Repository\UserGameAssociationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserGamesController extends AbstractController
{
    /**
     * @Route("/user/games", name="user_games")
     */
    public function index()
    {
        return $this->render('user_games/usergames.html.twig', [
            'controller_name' => 'UserGamesController',
        ]);
    }

    /**
     * @Route("/user/addgame/{id<\d+>}", name="user_addgame")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function userAddGame(
        ObjectManager $objectManager,
        UserGameAssociationRepository $userGameRepository,
        Game $game
    )
    {
        $user = $this->getUser();

        $userGame = $userGameRepository->findOneBy([
            'users' => $user,
            'games' => $game,
        ]);

        if ($userGame) {
            return $this->render('user_games/usergames.html.twig', [
                'user' => $user,
                'game' => $game,
                'user_game' => $userGame,
                'message' => 'le joueur a déjà mis ce jeu dans sa ludothèque !',
            ]);
        } else {

        $userGame = new UserGameAssociation();

        // METTRE EN PLACE UN TEST POUR NE PAS AJOUTER DEUX FOIS UN MEME JEU POUR UN UTILISATEUR

            $userGame->setUsers($user);
            $userGame->setGames($game);
            $userGame->setCommentary('');
            $userGame->setRating(null);
            $userGame->setPlaysGame(1);
            $userGame->setOwnsGame(0);
            $objectManager->persist($userGame);
            $objectManager->flush();

            // A METTRE EN PLACE QUAND LA PAGE DE RECHERCHE DE JEUX SERA PRETE
            // on redirige vers la page du profil du joueur
            //return $this->redirectToRoute('user_profile');

            // A SUPPRIMER : PERMET UN CONTROLE DU FONCTIONNEMENT
            return $this->render('user_games/usergames.html.twig', [
                'user' => $user,
                'game' => $game,
                'user_game' => $userGame,
                'message' => 'nouvelle association réussie !',
            ]);}
    }

    /**
     * @Route("/user/deletegame/{id<\d+>}", name="user_deletegame")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function userDeleteGame(
        ObjectManager $objectManager,
        UserGameAssociationRepository $userGameRepository,
        GameRepository $gameRepository,
        Game $game
    )
    {
        $user = $this->getUser();
        $userGame = new UserGameAssociation();
        $userGame = $userGameRepository->findOneBy([
            'users' => $user,
            'games' => $game,
            ]);

        $objectManager->remove($userGame);
        $objectManager->flush();

        // A METTRE EN PLACE QUAND LA PAGE DE RECHERCHE DE JEUX SERA PRETE
        // on redirige vers la page du profil du joueur
        //return $this->redirectToRoute('user_profile');

        // A SUPPRIMER : PERMET UN CONTROLE DU FONCTIONNEMENT
        return $this->render('user_games/usergames.html.twig', [
            'user' => $user,
            'game' => $game,
            'user_game' => $userGame,
            'message' => 'suppression de l\'association réussie !',
        ]);
    }
}
