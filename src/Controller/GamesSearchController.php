<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GamesSearchController extends AbstractController
{
    /**
     * @Route("/games/search", name="games_search")
     */
    public function index()
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $game = $this->getDoctrine()->getRepository(Game::class)->findAll();
        return $this->render('games_search/index.html.twig', [
            'game' => $game,
            'controller_name' => 'GamesSearchController',
        ]);
    }
}

