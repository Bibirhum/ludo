<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');

        for ($j = 0; $j < 10; $j++) {
            $category = new Category();
            $category->setName('categorie_num_'.$j);
            $category->setDescription($faker->paragraph(6, true));

            $manager->persist($category);

            for ($i = 0; $i < 5; $i++) {
                $game = new Game();

                $game->setName('jeu_num_'.$j.$i);
                $game->setImage($faker->imageUrl());
                $game->setThumbnail($faker->imageUrl(300,225));
                $game->setTheme($faker->sentence(12, true));
                $game->setShortDescription($faker->sentence(24, true));
                $game->setDescription($faker->paragraph(6, true));
                $game->setNumPlayerMin(rand(1,2));
                $game->setNumPlayerMax(rand(2,6));
                $game->setDuration(rand(20,90));
                $game->setAgeMin(rand(4,18));
                $game->setCategory($category);

                $manager->persist($game);
            }
        }

        $manager->flush();
    }
}
