<?php

namespace App\Entity;

use App\Repository\MessageTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MessageTypeRepository::class)]
class MessageType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['main'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['main'])]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: IncomingMessage::class, orphanRemoval: true)]
    private Collection $incomingMessages;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: OutgoingMessage::class, orphanRemoval: true)]
    private Collection $outgoingMessages;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: TaskMessage::class, orphanRemoval: true)]
    private Collection $taskMessages;

    public function __construct()
    {
        $this->incomingMessages = new ArrayCollection();
        $this->outgoingMessages = new ArrayCollection();
        $this->taskMessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, IncomingMessage>
     */
    public function getIncomingMessages(): Collection
    {
        return $this->incomingMessages;
    }

    /**
     * @return Collection<int, IncomingMessage>
     */
    public function getOutgoingMessages(): Collection
    {
        return $this->outgoingMessages;
    }

    /**
     * @return Collection<int, IncomingMessage>
     */
    public function getTaskMessages(): Collection
    {
        return $this->taskMessages;
    }

    public function addIncomingMessages(IncomingMessage $incomingMessage): static
    {
        if (!$this->incomingMessages->contains($incomingMessage)) {
            $this->incomingMessages->add($incomingMessage);
            $incomingMessage->setType($this);
        }

        return $this;
    }

    public function addOutgoingMessages(OutgoingMessage $outgoingMessage): static
    {
        if (!$this->outgoingMessages->contains($outgoingMessage)) {
            $this->outgoingMessages->add($outgoingMessage);
            $outgoingMessage->setType($this);
        }

        return $this;
    }

    public function addTaskMessages(TaskMessage $taskMessage): static
    {
        if (!$this->taskMessages->contains($taskMessage)) {
            $this->taskMessages->add($taskMessage);
            $taskMessage->setType($this);
        }

        return $this;
    }

    public function removeIncomingMessage(IncomingMessage $incomingMessage): static
    {
        // set the owning side to null (unless already changed)
        if ($this->incomingMessages->removeElement($incomingMessage) && $incomingMessage->getType() === $this) {
            $incomingMessage->setType(null);
        }

        return $this;
    }

    public function removeOutgoingMessage(IncomingMessage $outgoingMessage): static
    {
        // set the owning side to null (unless already changed)
        if ($this->outgoingMessages->removeElement($outgoingMessage) && $outgoingMessage->getType() === $this) {
            $outgoingMessage->setType(null);
        }

        return $this;
    }

    public function removeTaskMessage(TaskMessage $taskMessage): static
    {
        // set the owning side to null (unless already changed)
        if ($this->taskMessages->removeElement($taskMessage) && $taskMessage->getType() === $this) {
            $taskMessage->setType(null);
        }

        return $this;
    }
}
