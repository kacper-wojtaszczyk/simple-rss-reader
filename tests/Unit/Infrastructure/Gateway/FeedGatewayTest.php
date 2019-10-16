<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Tests\Unit\Infrastructure\Gateway;

use Codeception\Test\Unit;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\FeedGateway;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Feed;
use KacperWojtaszczyk\SimpleRssReader\Tests\UnitTester;

class FeedGatewayTest extends Unit
{
    /**
     * @var FeedGateway
     */
    private $gateway;

    public function _before()
    {
        $this->gateway = $this->tester->grabSymfonyService(FeedGateway::class);
    }

    public function testRequestFeed()
    {
        $feed = $this->gateway->requestFeed('https://www.theregister.co.uk/software/headlines.atom');
        $this->assertInstanceOf(Feed::class, $feed);
    }
}
