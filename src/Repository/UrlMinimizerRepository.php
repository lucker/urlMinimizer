<?php

namespace App\Repository;

use App\Entity\UrlMinimizer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UrlMinimizer>
 *
 * @method UrlMinimizer|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlMinimizer|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlMinimizer[]    findAll()
 * @method UrlMinimizer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlMinimizerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlMinimizer::class);
    }

    public function add(UrlMinimizer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UrlMinimizer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
