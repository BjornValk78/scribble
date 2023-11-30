<?php

namespace App\Entity;

use App\Repository\TaskMessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TaskMessageRepository::class)]
class TaskMessage extends Message
{
    #[ORM\Column(length: 255)]
    #[Groups(['main'])]
    protected ?string $subject = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['main'])]
    protected ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['main'])]
    protected ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    #[Groups(['main'])]
    protected ?string $sender = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(string $sender): static
    {
        $this->sender = $sender;

        return $this;
    }
}
