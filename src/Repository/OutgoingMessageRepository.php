<?php

namespace App\Repository;

use App\Entity\OutgoingMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OutgoingMessage>
 *
 * @method OutgoingMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutgoingMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutgoingMessage[]    findAll()
 * @method OutgoingMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutgoingMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OutgoingMessage::class);
    }
}