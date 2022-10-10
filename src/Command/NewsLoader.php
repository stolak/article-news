<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Controller\NewsApiController;

#[AsCommand(
    name: 'app:news:loader',
    description: 'The command is to load new news',
)]
class NewsLoader extends Command
{
    private $fetchedRepository;

    protected static $defaultName = 'app:news:loader';

    public function __construct(NewsApiController $fetchedRepository)
    {
        $this->fetchedRepository = $fetchedRepository;

        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->setDescription('Fetch new through API')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('dry-run')) {
            $io->note('Dry mode enabled');


        } else {
            $this->fetchedRepository->index();
        }

        $io->success(sprintf('Record successfully downloaded'));

        return 0;
    }
}
