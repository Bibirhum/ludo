<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\NamedAddress;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController
{
    /**
     * @Route("/mailer", name="mailer")
     */
    public function index()
    {
        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }

    /**
     * @Route("/email")
     */
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from(new NamedAddress('baptistegomart@gmail.com','Baptiste de Ludo'))
            ->to(new NamedAddress('{{user.email}}','{{user.first_name}}'))
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Bienvenue sur Ludo !')
            ->text('La communauté Ludo vous souhaite la bienvenue!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);


    }

    public function index($name, \Swift_Mailer $mailer)
{
    $message = (new \Swift_Message('Hello Email'))
        ->setFrom('send@example.com')
        ->setTo('recipient@example.com')
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'emails/registration.html.twig',
                ['name' => $name]
            ),
            'text/html'
        )

        // you can remove the following code if you don't define a text version for your emails
        ->addPart(
            $this->renderView(
                // templates/emails/registration.txt.twig
                'emails/registration.txt.twig',
                ['name' => $name]
            ),
            'text/plain'
        )
    ;

    $mailer->send($message);

    return $this->render(...);
}

}
