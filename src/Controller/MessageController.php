<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message/read", name="message_read")
     */
    public function index(MessageRepository $messageRepository)
    {
        $messages = $messageRepository->findAll();

        return $this->render('message/read.html.twig', [
            'messages' => '$messages',
        ]);
    }
}
