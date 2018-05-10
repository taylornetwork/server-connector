<?php

namespace TaylorNetwork\Console\ServerConnector\Commands;


use TaylorNetwork\Console\ServerConnector\Config;
use TaylorNetwork\Console\ServerConnector\Tunnel\SFTP;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SFTPCommand extends Command
{
    protected $sftp;

    protected $config;

    protected function configure()
    {
        $this->config = new Config;
        $this->setName('connect:sftp');
        $this->setDescription('Connect via SFTP to a defined connection');
        $this->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if($connection = $this->config->get('connections.'.$input->getArgument('name'))) {
            $output->writeln('Connecting to ' . $connection['url'] . '...');
            $this->sftp = new SFTP();
            $this->sftp->setURL($connection['url'])->setCredentials($connection['credentials']);
            $this->sftp->connect();
        } else {
            $output->writeln($input->getArgument('name') . ' not found.');
        }
    }

}