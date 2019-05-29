<?php

namespace Commands;

use App\Events\ImportOracleEvent;
use Bootstrap\Events\Dispatcher;
use HyveMobileTest\Models\Oracle\Claim;
use Illuminate\Queue\Capsule\Manager as Queue;
use Illuminate\Support\Facades\DB;
use Predis\Client;
use Simpleue\Queue\RedisQueue;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportCommand
 *
 * Manages database migrations
 *
 * @package Commands
 */
class ImportCommand extends Command
{
    /**
     *  Command configuration
     *
     */
    protected function configure()
    {
        $this->setName('import');
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('max_execution_time', 600);

        $output->writeln('Oracle Database import started.');

      $dispatcher = new Dispatcher();
      $dispatcher->fire(new ImportOracleEvent());

        $output->writeln('Oracle Database import completed.');
    }
}
