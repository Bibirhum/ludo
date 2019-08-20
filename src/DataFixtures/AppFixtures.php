<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture

{   private $encoder;

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
            $user->setPassword($this->encoder->encodePassword($user,$faker->userName ));
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

        $manager->flush();
    }
}
