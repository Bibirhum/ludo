<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/games/search", name="games_search")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
    */
    public function index(Request $request)
    {
        $gameForm = $this->createForm(GameType::class);
        $gameForm->handleRequest($request);
        // Méthode qui permet de récupérer les données des jeux et de les afficher en pâge de recherche
        $game = $this->getDoctrine()->getRepository(Game::class)->findAll();
        return $this->render('game/listgames.html.twig', [
            'game' => $game,
            'game_form' => $gameForm->createView(),
        ]);
    }

    /**
     * @Route("/game/user_games", name="user_games")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    // cette méthode n'a peut-être pas d'utilité ici
    public function userGames(
        GameRepository $gameRepository,
        User $user)
    {
        // A COMPLETER
        $games = $gameRepository->findAll();

        return $this->render('game/user_games.html.twig', [
            'games' => $games,
        ]);
    }

     /**
     * @Route("/game/add", name="add_game")
     * @Route("/game/edit/{id<\d+>}", name="edit_game")
     */
    public function editGame(
        Request $request,
        ObjectManager $objectManager,
        Game $game = null
    )
    {
        // variable pour typer le formulaire et permettre des affichages conditionnels dans le template
        $form_type = 'update';

        if ($game === null) {
            $game = new Game();
            $form_type = 'create';
        }

        $gameForm = $this->createForm(GameType::class, $game);
        $gameForm->handleRequest($request);

        if ($gameForm->isSubmitted() && $gameForm->isValid()) {
            // on ne fait ce traitement que si une image a bien été envoyée
            if ($game->getImageFile() !== null) {
                // on gère ici le déplacement du fichier uploadé depuis la localisation temporaire
                // vers la localisation permanente (public/uploads)
                $imageFile = $game->getImageFile();
                $folder = 'uploads/game';
                $fileName = uniqid();
                $imageFile->move($folder, $fileName);
                $game->setImage($folder . DIRECTORY_SEPARATOR . $fileName);
                $game->setThumbnail($folder . DIRECTORY_SEPARATOR . $fileName);
            }
            // on insère le nouveau jeu dans la BDD
            $objectManager->persist($game);
            $objectManager->flush();
            // on redirige vers la page d'administration des jeux
            return $this->redirectToRoute('admin_games');
        }

        return $this->render('game/editgame.html.twig', [
            'game_form' => $gameForm->createView(),
            'game' => $game,
            'form_type' => $form_type,
        ]);
    }

    /**
     * @Route("/game/delete/{id<\d+>}", name="delete_game")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
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
