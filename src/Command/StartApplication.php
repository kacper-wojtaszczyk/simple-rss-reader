<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class StartApplication extends Command
{
    protected static $defaultName = 'srr:start';

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Starts the application')
            ->setHelp('This command starts the application on Symfony Web Server')
            ->addOption('cache', 'c', InputOption::VALUE_NONE,
                "Run in cached mode (feed entries will be persisted to DB)")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ...
    }
}