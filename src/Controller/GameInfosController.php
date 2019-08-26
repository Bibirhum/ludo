<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Entity\UserGameAssociation;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserGameAssociationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    
    class GameInfosController extends AbstractController
    {
        /**
         * @Route("/game/infos/{id}/{games_id}", name="game_infos")
         */
        public function detail(
        UserGameAssociationRepository $userGameRepository,
        GameRepository $gameRepository, $id, $games_id
    
        )
        {
            $game = $this->getDoctrine()
            ->getRepository(game::class)
            ->find($id);

            $comment = $this->getDoctrine()
            ->getRepository(UserGameAssociation::class)
            ->find($games_id);
    
             return $this->render('game_infos/game.infos.html.twig', [
                
                 'game' => $game,
                 'gameComments' => $comment,
             ]);
        }

}