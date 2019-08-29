<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\UserGameAssociation;
use App\Repository\GameRepository;
use App\Repository\UserGameAssociationRepository;
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
     * @Route("/player/search/game/{id<\d+>}", name="player_search_by_game")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function playerSearch(
        Request $request,
        UserGameAssociationRepository $userGameRepository,
        GameRepository $gameRepository,
        UserRepository $userRepository,
        UserGameAssociation $userGameAssociation = null,
        Game $game = null,
        User $user = null
    )
    {
        //$players = $userRepository->findAll();

        $playerSearchForm = $this->createFormBuilder($game)
            ->add('name', TextType::class, [
                'label' => 'Nom du jeu',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Rechercher'])
        ->getForm();

        $playerSearchForm->handleRequest($request);

        if ($playerSearchForm->isSubmitted() && $playerSearchForm->isValid()) {

            $data = $playerSearchForm->getData();

            $paramGame = ($data['name'] === null ? '%' : $data['name']);
            $paramCity = ($data['city'] === null ? '%' : $data['city']);

            if ($paramGame === '%') {
                $user = $userRepository->findByCity($paramCity);
            } else {
                $userGameAssociation = $userGameRepository->findByFields(
                    $paramGame,
                    $paramCity
                );
            }

            if ($user || $userGameAssociation) {
                $this->addFlash(
                    'success',
                    'Voici la liste des joueurs qui correspondent à vos critères de recherche'
                );
            } else {
                $this->addFlash(
                    'warning',
                    'Aucun joueur ne correspond à vos critères de recherche'
                );
            }

        }
        return $this->render('player_search/player_search.html.twig', [
            'playersearch_form' => $playerSearchForm->createView(),
            'usergames' => $userGameAssociation,
            'players' => $user,
        ]);
    }

    /**
     * @Route("/player/infos/{id<\d+>}", name="player_infos")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function playerInfos(
        UserRepository $userRepository,
        UserGameAssociationRepository $userGameAssociationRepository,
        User $user
    )
    {
        return $this->render('user_profile/user_infos.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/player/searchbycity", name="searchby_user_city")
     */
    public function searchByCity(Request $request, UserRepository $userRepository)
    {
        $search = $request->get('search');
        // si l'utilisateur n'envoie pas de recherche, on retourne la page 404
        if (!$search) {
            throw $this->createNotFoundException();
        }

        $users = $userRepository->findByCity($search);

        $users = array_map(function(User $user){
            return [
                'id' => $user->getId(),
                'city' => $user->getCity(),
            ];
        }, $users);

        //dd($tags);

        return $this->json($users);
    }
}
