<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlayerSearchController extends AbstractController
{
    /**
     * @Route("/player/search", name="player_search")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function playerSearch(
        Request $request,
        GameRepository $gameRepository,
        UserRepository $userRepository,
        Game $game = null,
        User $user = null
    )
    {
        //$players = $userRepository->findAll();

        $playerSearchForm = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'label' => 'Titre du jeu',
                'required' => false,
            ])
            ->add('username', TextType::class, [
                'label' => 'Pseudo',
                'required' => false,
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Code postal',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Rechercher'])
        ->getForm();

        //$playerSearchForm = $this->createForm(PlayerSearchType::class; $user);
        $playerSearchForm->handleRequest($request);

        if ($playerSearchForm->isSubmitted() && $playerSearchForm->isValid()) {

            $data = $playerSearchForm->getData();

            $paramGame = $data['name'];
            $paramUsername = $data['username'];
            $paramZipCode = $data['zipCode'];
            $paramCity = $data['city'];


            $game = $gameRepository->findOneBy(['name' => $paramGame]);

            $user = $userRepository->findByFields(
                $paramUsername,
                $paramZipCode,
                $paramCity
            );
        }
        return $this->render('player_search/player_search.html.twig', [
            'playersearch_form' => $playerSearchForm->createView(),
            'players' => $user,
            'game' => $game,
        ]);
    }
}
