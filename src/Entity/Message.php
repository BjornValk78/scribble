<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn('messageobject', 'string')]
#[ORM\DiscriminatorMap(['incoming'=>IncomingMessage::class, 'outgoing'=>OutgoingMessage::class, 'task'=>TaskMessage::class])]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['main'])]
    protected ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Messages')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?MessageType $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['main'])]
    protected ?\DateTimeInterface $handled = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['main'])]
    protected ?string $handler = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?MessageType
    {
        return $this->type;
    }

    public function setType(?MessageType $type): static
    {
        $this->type = $type;

        return $this;
    }


    public function getHandled(): ?\DateTimeInterface
    {
        return $this->handled;
    }

    public function setHandled(?\DateTimeInterface $handled): static
    {
        $this->handled = $handled;

        return $this;
    }

    public function getHandler(): ?string
    {
        return $this->handler;
    }

    public function setHandler(?string $handler): static
    {
        $this->handler = $handler;

        return $this;
    }
}
