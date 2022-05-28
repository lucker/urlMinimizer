<?php
namespace App\Command;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:url-minimizer',
    description: 'Command that disable links by lifetime',
    aliases: ['app:url-minimizer'],
    hidden: false
)]

class UrlMinimizerCommand extends Command
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sql = "
            UPDATE url_minimizer
            SET active = false, life_time_ended = NOW()
            WHERE created + interval '1 SEC' * life_time < NOW()
            AND active = true
        ";

        $this->doctrine->getConnection()
            ->prepare($sql)
            ->execute();

        return Command::SUCCESS;
    }
}
