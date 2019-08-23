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
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GameController extends AbstractController
{
    /**
     * @Route("/games/search", name="games_search")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
    */
    public function searchGames(Request $request, GameRepository $gameRepository, Game $game = null)
    {
        $gameSearchForm = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'label' => 'Nom du jeu',
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Choisir une catégorie',
                'required' => false,
            ])
            ->add('numPlayerMin', IntegerType::class, [
                'label' => 'Nombre minimal de joueurs',
                'required' => false,
            ])
            ->add('numPlayerMax', IntegerType::class, [
                'label' => 'Nombre maximal de joueurs',
                'required' => false,
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée d\'une partie en minutes',
                'required' => false,
            ])
            ->add('ageMin', IntegerType::class, [
                'label' => 'Âge minimum',
                'required' => false,
            ])
            ->add('submit', SubmitType::class)
            ->getForm();
        $gameSearchForm->handleRequest($request);
        
        if ($gameSearchForm->isSubmitted() && $gameSearchForm->isValid()) {
            $data = $gameSearchForm->getData();
            $paramName = $data['name'];
            $paramCategory = $data['category']; 
            $paramNumPlayerMin = $data['numPlayerMin'];
            $paramNumPlayerMax = $data['numPlayerMax'];
            $paramDuration = $data['duration'];
            $paramAgeMin = $data['ageMin'];
            $game = $gameRepository->findBy([
                'category' => $paramCategory,
            ]);
        } else {
            $game = $gameRepository->findAll();
        }

        return $this->render('game/listgames.html.twig', [
            'game_form' => $gameSearchForm->createView(),
            'game' => $game,
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
