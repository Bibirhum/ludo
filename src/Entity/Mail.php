<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MailRepository")
 */
class Mail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    private $id_username;

    private $message;

    private $date_message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdUsername()
    {
        return $this->id_username;
    }

    public function setIdUsername($id_username)
    {
        $this->id_username = $id_username;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getDateMessage()
    {
        return $this->date_message;
    }

    public function setDateMessage($date_message)
    {
        $this->date_message = $date_message;
    }
}
