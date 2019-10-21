<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Repository\Feed;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Feed;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Word;

/**
 * @method Word|null find($id, $lockMode = null, $lockVersion = null)
 * @method Word|null findOneBy(array $criteria, array $orderBy = null)
 * @method Word[]    findAll()
 * @method Word[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Word::class);
    }

    public function findOneByWord(string $word, Feed $feed): ?Word
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.word = :word')
            ->andWhere('e.feed = :feed')
            ->setParameters(['word' => $word, 'feed' => $feed])
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findTopxByFeed(int $count, Feed $feed)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.feed = :feed')
            ->orderBy('e.count', 'DESC')
            ->setMaxResults($count)
            ->setParameters(['feed' => $feed])
            ->getQuery()
            ->getResult();
    }

}
