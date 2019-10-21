<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Service;


use Doctrine\ORM\EntityManagerInterface;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Entry;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Feed;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Word;
use KacperWojtaszczyk\SimpleRssReader\Repository\Feed\WordRepository;

final class WordUpdateService
{
    /**
     * @var WordRepository
     */
    private $wordRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var array
     */
    private $blacklist;

    public function __construct(EntityManagerInterface $em, WordRepository $wordRepository, array $blacklist)
    {
        $this->em = $em;
        $this->wordRepository = $wordRepository;
        $this->blacklist = $blacklist;
    }

    /**
     * Parse Entry in search for unique words
     *
     * ALWAYS flush entity manager after this. The method calls flush only for new entities to keep the keys up to date
     * @param Entry $entry
     */
    public function forEntry(Entry $entry): void
    {
        if($entry->getSummary())
        {
            $this->processString(strip_tags($entry->getSummary()), $entry->getFeed());
        }
        if($entry->getTitle())
        {
            $this->processString($entry->getTitle(), $entry->getFeed());
        }
        if($entry->getContent())
        {
            $this->processString(strip_tags($entry->getContent()->getText()), $entry->getFeed());
        }

    }

    private function processString(string $string, Feed $feed): void
    {
        $words = str_word_count($string, 1);

        foreach($words as $word) {
            if (in_array($word, $this->blacklist, true)) {
                continue;
            }
            if (($persistantWord = $this->wordRepository->findOneByWord($word, $feed)) === null) {
                $persistantWord = Word::withWord($word, $feed);
                $this->em->persist($persistantWord);
                $this->em->flush();
            }
            $persistantWord->addCount();
        }
    }
}