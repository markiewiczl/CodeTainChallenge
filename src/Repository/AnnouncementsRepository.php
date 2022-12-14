<?php

namespace App\Repository;

use App\Entity\Announcements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Announcements>
 *
 * @method Announcements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Announcements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Announcements[]    findAll()
 * @method Announcements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnouncementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Announcements::class);
    }

    public function add(Announcements $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Announcements $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Announcements[] Returns an array of Announcements objects
     */
    public function orderByColumn($order, $column): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.'. $column, $order)
            ->getQuery()
            ->getResult()
        ;
    }
}
