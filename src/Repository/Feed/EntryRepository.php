<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Repository\Feed;

use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Entry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Feed;

/**
 * @method Entry|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entry|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entry[]    findAll()
 * @method Entry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entry::class);
    }

    public function findOneById(string $id, Feed $feed): Entry
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id = :id')
            ->andWhere('e.feed = :feed')
            ->setParameters(['id' => $id, 'feed' => $feed])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
