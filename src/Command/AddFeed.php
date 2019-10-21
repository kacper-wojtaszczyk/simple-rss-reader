<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Command;

use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Message\CreateFeed;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class AddFeed extends Command
{
    protected static $defaultName = 'srr:feed:add';
    /**
     * @var MessageBusInterface
     */
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Adds a new feed')
            ->setHelp('This command adds a new RSS feed')
            ->addArgument('url', InputArgument::REQUIRED, 'url to RSS feed');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');

        $output->writeln('Adding a feed. This might take a minute');

        try {
            $this->bus->dispatch(CreateFeed::forUrl($url));
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return;
        }
        $output->writeln('Successfully created feed. Go to frontend to see it in action');

    }
}