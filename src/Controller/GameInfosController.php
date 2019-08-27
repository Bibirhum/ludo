<?php

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
     * @Route("/game/infos/{id}", name="Game_infos")
     * 
     */
    public function show(Game $game)
    {
        
        return $this->render('game_infos/game_infos.html.twig', [
        'game' => $game
    ]);
    }

     /**
     * @Route("/game/infos/edit/{id}", name="Game_infos")
     * 
     */
    public function update($id, Request $request, Game $game = null)
{
    $entityManager = $this->getDoctrine()->getManager();
    $editGame = $entityManager->getRepository(UserGameAssociation::class)->find($id);

    $form = $this->createForm(FormEditMyGamesType::class, $editGame);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $entityManager->persist($editGame);
        $entityManager->flush();


        return $this->redirectToRoute('user_profile');
    }

    return $this->render('game_infos/edit_game.html.twig', [
        'NewGameForm' => $form->createView(),
        'game' => $game,
        'editgame' => $editGame,
    ]);
}}
