<?php

namespace App\Repository;

use App\Entity\IncomingMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IncomingMessage>
 *
 * @method IncomingMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method IncomingMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method IncomingMessage[]    findAll()
 * @method IncomingMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncomingMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IncomingMessage::class);
    }
}