<?php

namespace TaylorNetwork\Console\ServerConnector\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaylorNetwork\Console\ServerConnector\Config;
use TaylorNetwork\Console\ServerConnector\Tunnel\SSH;

class SSHCommand extends Command
{
    /**
     * @var SSH
     */
    protected $ssh;

    /**
     * @var Config
     */
    protected $config;

    protected function configure()
    {
        $this->config = new Config();
        $this->setName('connect:ssh');
        $this->setDescription('Connect via SSH to a defined connection');
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($connection = $this->config->get('connections.'.$input->getArgument('name'))) {
            $output->writeln('Connecting to '.$connection['url'].'...');
            $this->ssh = SSH::newFromConfig($connection);
            $this->ssh->connect();
        } else {
            $output->writeln($input->getArgument('name').' not found.');
        }
    }
}
