<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Tests\Unit\Infrastructure\Gateway;

use Codeception\Test\Unit;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\AtomGateway;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Model\Feed as FeedDTO;

class FeedGatewayTest extends Unit
{
    /**
     * @var AtomGateway
     */
    private $gateway;

    public function _before()
    {
        $this->gateway = $this->tester->grabSymfonyService(AtomGateway::class);
    }

    public function testRequestFeed()
    {
        $feed = $this->gateway->requestFeed('https://xkcd.com/atom.xml');
        $this->assertInstanceOf(FeedDTO::class, $feed);
    }
}
