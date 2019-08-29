<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Repository\MessageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message/read", name="message_read")
     */
    public function index(MessageRepository $messageRepository)
    {
        $user = $this->getUser();

        $messages = $messageRepository->usersMessages($user);

        /*$messages = $messageRepository->findBy([
            'sender' => $user,
        ], [
            'creationDate' => 'DESC',
        ]);*/

        /*$messages = $messageRepository->findBy([
            'recipient' => $user,
        ], [
            'creationDate' => 'DESC',
        ]);*/

        return $this->render('message/read.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("/message/write/{id<\d+>}", name="message_write")
     */
    public function main(
        Request $request,
        MessageRepository $messageRepository,
        User $recipient,
        ObjectManager $objectManager
    )
    {
        $message = new Message();

        $writeMessageForm = $this->createFormBuilder($message)
            ->add('message', TextareaType::class, [
                'label' => false,
                'required' => true,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Envoyer'])
        ->getForm();

        $writeMessageForm->handleRequest($request);

        if ($writeMessageForm->isSubmitted() && $writeMessageForm->isValid()) {

            $sender = $this->getUser();
            $message->setSender($sender);

            $message->setRecipient($recipient);

            $message->setCreationDate(new \DateTime('NOW'));

            $objectManager->persist($message);
            $objectManager->flush();

            $this->addFlash(
                'success',
                'Votre message a bien été envoyé'
            );

            return $this->redirectToRoute('message_read');

        }

        return $this->render('message/write.html.twig', [
            'write_form' => $writeMessageForm->createView(),
            'recipient' => $recipient,
        ]);
    }

}
