<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Controller;

use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Exception\FeedNotExistsException;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Exception\NoFeedExistsException;
use KacperWojtaszczyk\SimpleRssReader\Repository\Feed\FeedRepository;
use KacperWojtaszczyk\SimpleRssReader\Repository\Feed\WordRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class FeedController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var FeedRepository
     */
    private $feedRepository;

    /**
     * @var WordRepository
     */
    private $wordRepository;

    public function __construct(Environment $twig, FeedRepository $feedRepository, WordRepository $wordRepository)
    {
        $this->feedRepository = $feedRepository;
        $this->twig = $twig;
        $this->wordRepository = $wordRepository;
    }

    /**
     * @Route("/", name="feed")
     * @IsGranted("ROLE_USER")
     */
    public function initializeFeed(): Response
    {
        $feedsHeadings = $this->feedRepository->findAllHeadings();
        if (!$feedsHeadings) {
            throw NoFeedExistsException::create();
        }
        $content = $this->twig->render('feed/feed.html.twig', ['feeds' => json_encode($feedsHeadings, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)]);
        return Response::create($content, Response::HTTP_OK);
    }

    /**
     * @Route("/_ajax/single-feed", name="single_feed")
     * @IsGranted("ROLE_USER")
     */
    public function renderSingleFeed(Request $request)
    {
        $id = $request->request->get('id');
        $feed = $this->feedRepository->findOneBy(['id' => $id]);
        if($feed === null)
        {
            throw FeedNotExistsException::withFeedId($id);
        }
        $topWords = $this->wordRepository->findTopxByFeed(10, $feed);
        $content = $this->twig->render('feed/singleFeed.html.twig', ['feed' => $feed, 'topWords' => $topWords]);
        return Response::create($content, Response::HTTP_OK);
    }
}
