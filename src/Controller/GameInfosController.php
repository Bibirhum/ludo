<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Entity\UserGameAssociation;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class GameInfosController extends AbstractController
{
    /**
     * @Route("/game/infos/{id}", name="Game_infos")
     * 
     */
    public function show(Game $game)
    {
        
        return $this->render('game_infos/game_infos.html.twig', [
        'game' => $game
    ]);
    }

}