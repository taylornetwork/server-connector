<?php

namespace TaylorNetwork\Console\ServerConnector\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaylorNetwork\Console\ServerConnector\Config;
use TaylorNetwork\Console\ServerConnector\Tunnel\SFTP;

class SFTPCommand extends Command
{
    protected $sftp;

    protected $config;

    protected function configure()
    {
        $this->config = new Config();
        $this->setName('connect:sftp');
        $this->setDescription('Connect via SFTP to a defined connection');
        $this->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($connection = $this->config->get('connections.'.$input->getArgument('name'))) {
            $this->sftp = SFTP::newFromConfig($connection);
            $output->writeln('Attempting to connect to '.$connection['url'].' on port '.$this->sftp->getPort().'...');
            $this->sftp->connect();
        } else {
            $output->writeln($input->getArgument('name').' not found.');
        }
    }
}
