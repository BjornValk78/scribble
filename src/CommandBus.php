<?php
namespace App;

use App\Handlers\IncomingHandler;
use App\Handlers\OutgoingHandler;
use App\Handlers\TaskHandler;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class CommandBus implements ServiceSubscriberInterface
{
    public function __construct(
        private ContainerInterface $locator,
    ) {
    }

    public static function getSubscribedServices(): array
    {
        return [
            'Scribble\IncomingHandler' => IncomingHandler::class,
            'Scribble\OutgoingHandler' => OutgoingHandler::class,
            'Scribble\TaskHandler'     => TaskHandler::class,
        ];
    }

    public function handle(Command $command): mixed
    {
        $commandClass = get_class($command);

        if ($this->locator->has($commandClass)) {
            return $this->locator->get($commandClass)->handle($command);
        }
    }
}