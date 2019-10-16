<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Tests;

use Codeception\Scenario;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class UnitTester extends \Codeception\Actor
{
    /**
     * @var ContainerInterface
     */
    private $container;

    use _generated\UnitTesterActions;

   /**
    * Define custom actions here
    */

    public function __construct(Scenario $scenario)
    {
        parent::__construct($scenario);
        $this->container = $this->grabService('test.service_container');
    }

    public function grabSymfonyService($serviceName)
    {
        return $this->container->get($serviceName);
    }
}
