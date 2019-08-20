<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        $user = new User();
        $user->setUsername('toto');
        $user->setPassword($this->encoder->encodePassword($user, 'toto'));
        $user->setEmail('toto@toto.fr');
        $user->setLastname('toto');
        $user->setFirstname('toto');
        $user->setAddress('toto');
        $user->setZipCode(75014);
        $user->setCity('toto');
        $user->setStatus(1);

        $manager->persist($user);

        $manager->flush();
    }
}
