<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class FeedController
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    /**
     * @Route("/", name="feed")
     * @IsGranted("ROLE_USER")
     */
    public function initializeFeed(): Response
    {
        $content = $this->twig->render('feed/feed.html.twig');
        return Response::create($content, Response::HTTP_OK);
    }
}
