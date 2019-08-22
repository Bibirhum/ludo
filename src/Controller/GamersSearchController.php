<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GamersSearchController extends AbstractController
{
    /**
     * @Route("/gamerssearch", name="gamers_search")
     */
    public function index()
    {
        return $this->render('gamers_search/index.html.twig', [
            'controller_name' => 'GamersSearchController',
        ]);
    }
    }
