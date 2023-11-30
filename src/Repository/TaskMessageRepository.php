<?php

namespace App\Repository;

use App\Entity\TaskMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaskMessage>
 *
 * @method TaskMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskMessage[]    findAll()
 * @method TaskMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskMessage::class);
    }
}