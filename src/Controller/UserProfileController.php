<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserProfileController extends AbstractController
{
    /**
     * @Route("/user/profile", name="user_profile")
     */

    public function index(UserRepository $userRepository)
    {
        $user = $this->getUser();
        return $this->render('user_profile/index.html.twig', [
            'user' => $user,
        ]);
    }
}
