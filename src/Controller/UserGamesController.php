<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\UserGameAssociation;
use App\Form\UserGameType;
use App\Repository\GameRepository;
use App\Repository\UserGameAssociationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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
     * @Route("/usergame/add/{id<\d+>}", name="add_user_game")
     * @Route("/usergame/edit/{id<\d+>}", name="edit_user_game")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function editUserGame(
        Request $request,
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

        // DEBUT REPRISE CODE AXEL
        $form_type = 'update';

        if ($userGame === null) {
            $userGame = new UserGameAssociation();
            $form_type = 'create';
        }

        $form = $this->createForm(UserGameType::class, $userGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($userGame->getUsers() === null) {
                $userGame->setUsers($this->getUser());
            }
            if ($userGame->getGames() === null) {
                $userGame->setGames($game);
            }
            $entityManager->persist($userGame);
            $entityManager->flush();

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('game_infos/edit_game.html.twig', [
            'NewGameForm' => $form->createView(),
            'game' => $game,
            'usergame' => $userGame,
            'form_type' => $form_type,
        ]);

        // FIN CODE AXEL

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

namespace App\Controller;

use App\Entity\Game;
use App\Form\FormEditMyGamesType;
use App\Repository\GameRepository;
use App\Entity\UserGameAssociation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class GameInfosController extends AbstractController
{

    /**
     * @Route("/usergame/add/{id<\d+>}", name="add_user_game")
     * @Route("/usergame/edit/{id<\d+>}", name="edit_user_game")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function update(Request $request, Game $game = null)
    {
       /* $entityManager = $this->getDoctrine()->getManager();

        $userGame = $entityManager->getRepository(UserGameAssociation::class)->findOneBy([
                'games' => $game->getId(),
                'users' => $this->getUser()->getId(),
            ]
        );*/

/*        $form_type = 'update';*/

        /*if ($userGame === null) {
            $userGame = new UserGameAssociation();
            $form_type = 'create';
        }*/

       /* $form = $this->createForm(FormEditMyGamesType::class, $userGame);
        $form->handleRequest($request);*/

        /*if ($form->isSubmitted() && $form->isValid()) {

            if ($userGame->getUsers() === null) {
                $userGame->setUsers($this->getUser());
            }
            if ($userGame->getGames() === null) {
                $userGame->setGames($game);
            }
            $entityManager->persist($userGame);
            $entityManager->flush();

            return $this->redirectToRoute('user_profile');
        }*/

       /* return $this->render('game_infos/edit_game.html.twig', [
            'NewGameForm' => $form->createView(),
            'game' => $game,
            'usergame' => $userGame,
            'form_type' => $form_type,
        ]);*/
    }}
