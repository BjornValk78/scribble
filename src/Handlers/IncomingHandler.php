<?php

namespace App\Handlers;


use App\Entity\IncomingMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app.command_handler.incoming')]
class IncomingHandler extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // configure an argument
            ->addArgument('id', InputArgument::REQUIRED, 'The ID of the message to handle.')
            // ...
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $message = $this->entityManager->getRepository(IncomingMessage::class)->find($input->getArgument('id'));
        if ($message) {
            $message->setHandled(new \DateTimeImmutable());
            $message->setHandler(get_class($this));
            $this->entityManager->persist($message);
            $this->entityManager->flush();
            return Command::SUCCESS;
        }

        return Command::INVALID;
    }
}