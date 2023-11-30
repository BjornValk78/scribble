<?php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'scribble:setup',description: 'Setup the Scribble app for use',aliases: ['app:setup'])]
class SetupCommand extends Command
{
    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setHelp('This command allows you to setup the Scribble app for first time use...');
    }

    /**
     * @throws \Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $section = $output->section();
        $section->writeln([
            'Running Scribble setup',
            '======================',
            'Setting up database with migrations',
        ]);
        $migrationInput = new ArrayInput([
            'command'           => 'doctrine:migrations:migrate',
            '-n'  => true,
        ]);

        $returnCode = $this->getApplication()->doRun($migrationInput, $output);
        if ($returnCode !== Command::SUCCESS) {
            return $returnCode;
        }
        sleep(1);
        $section->clear();
        $section->writeln(['Setting up database tables with fixtures']);


        $migrationInput = new ArrayInput([
            'command'           => 'doctrine:fixtures:load',
            '--append'          => true,
            '-n'                => true,
        ]);

        $returnCode = $this->getApplication()->doRun($migrationInput, $output);
        if ($returnCode !== Command::SUCCESS) {
            return $returnCode;
        }

        return Command::SUCCESS;

        // return Command::FAILURE;
        // return Command::INVALID
    }
}