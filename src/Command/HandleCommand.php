<?php
namespace App\Command;

use App\Entity\Message;
use App\Entity\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'scribble:handle',description: 'Handle pending messages')]
class HandleCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setHelp('This command allows you to handle all pending messages of all types...');
    }

    /**
     * @throws \Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $section = $output->section();
        $section->writeln([
            'Running Scribble Messages Handler',
            '=================================',
            'Finding all pending messages',
        ]);
        $messages = $this->entityManager->getRepository(Message::class)->findBy(['handled' => null]);
        if ($messages) {
            $section->writeln([
                'Found '. count($messages) .' messages to be handled',
                'Processing '. count($messages) .' messages',
            ]);
            foreach($messages as $message) {
                $type = $message->getType()->getType();
                $handler = 'app.command_handler.' . $type;
                $handleInput = new ArrayInput([
                    'command' => $handler,
                    'id' => $message->getId(),
                ]);
                $returnCode = $this->getApplication()->doRun($handleInput, $output);
                if ($returnCode !== Command::SUCCESS) {
                    return $returnCode;
                }
            }
        } else {
            $section->writeln('No messages found to handle');
        }
        return Command::SUCCESS;
    }
}