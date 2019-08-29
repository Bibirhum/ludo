<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/category/add", name="add_category")
     * @Route("/admin/category/edit/{id<\d+>}", name="edit_category")
     */
    public function editCategory(
        Request $request,
        ObjectManager $objectManager,
        Category $category = null
    )
    {
        // variable pour typer le formulaire et permettre des affichages conditionnels dans le template
        $form_type = 'update';

        if ($category === null) {
            $category = new Category();
            $form_type = 'create';
        }

        $categoryForm = $this->createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {

            // on insère le nouveau jeu dans la BDD
            $objectManager->persist($category);
            $objectManager->flush();

            if ($form_type === 'update') {
                $this->addFlash(
                    'success',
                    'La catégorie a bien été mise à jour'
                );
            } else {
                $this->addFlash(
                    'success',
                    'La nouvelle catégorie a bien été ajoutée'
                );
            }

            // on redirige vers la page d'administration des catégories
            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('category/editcategory.html.twig', [
            'category_form' => $categoryForm->createView(),
            'category' => $category,
            'form_type' => $form_type,
        ]);
    }

    /**
     * @Route("/admin/category/delete/{id<\d+>}", name="delete_category")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function deleteCategory(
        Category $category,
        ObjectManager $objectManager
    )
    {
        // on récupère les jeux associés à la catégorie à supprimer
        $games = $category->getRelatedGames()->toArray();

        //dd($games);
        // on ne peut supprimer la catégorie que si aucun jeu n'y est associé
        if (empty($games)) {
            // on supprime la catégorie
            $objectManager->remove($category);
            $objectManager->flush();

            $this->addFlash(
                'success',
                'La catégorie a bien été supprimée'
            );
        } else {
            $this->addFlash(
                'warning',
                'La catégorie ne peut pas être supprimée car elle est associée à un ou plusieurs jeux de la base de données'
            );
        }

        // on 'vide' la catégorie
        // -> suppression d'un enregistrement interdit à cause des contraintes d'intégrité
        //$category->setName('Catégorie supprimée');
        //$category->setDescription('Catégorie supprimée');
        //$objectManager->persist($category);
        //$objectManager->flush();

        // on redirige vers la liste des catégories
        return $this->redirectToRoute('admin_categories');
    }
}
