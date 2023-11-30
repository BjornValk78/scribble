<?php

namespace App\DataFixtures;

use App\Entity\MessageType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MessageTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $type = new MessageType();
        $type->setType('incoming');
        $manager->persist($type);

        $type = new MessageType();
        $type->setType('outgoing');
        $manager->persist($type);

        $type = new MessageType();
        $type->setType('task');
        $manager->persist($type);

        $manager->flush();
    }
}
