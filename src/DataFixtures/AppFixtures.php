<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Game;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component;

class AppFixtures extends Fixture

{
    /**
     * @var UserPasswordEncoderInterface
     */
   private $encoder;

     public function __construct(UserPasswordEncoderInterface $encoder)
     {
         $this->encoder = $encoder;
     }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
        for ($i=0;$i<20;$i++)
        {
            $user = new User();
            $user->setUsername($faker->userName);
            $username = $user->getUsername();
            $user->setPassword($this->encoder->encodePassword($user,$username));
            $user->setLastName($faker->lastName);
            $user->setFirstName($faker->firstNameMale);
            $user->setBio($faker->catchphrase);
            $user->setAvatar($faker->imageUrl);
            $user->setEmail($faker->email);
            $user->setAddress($faker->streetAddress);
            $user->setZipCode($faker->postcode);
            $user->setCity($faker->city);
            $user->setStatus(random_int(0,1));
            $manager->persist($user);
        }

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
