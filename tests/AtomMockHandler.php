<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Util\FileLoader;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AtomMockHandler extends MockHandler
{
    public function __invoke(RequestInterface $request, array $options)
    {
        $this->append($this->getFeed($request, $options));

        return parent::__invoke($request, $options);
    }
    private function getFeed(RequestInterface $request, array $options)
    {
        $data = file_get_contents('tests/_data/sample.xml');

        return new Response(HttpResponse::HTTP_OK, [], $data);
    }
}