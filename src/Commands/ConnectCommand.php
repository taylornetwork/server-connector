<?php

namespace TaylorNetwork\Console\ServerConnector\Commands;


use TaylorNetwork\Console\ServerConnector\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConnectCommand extends Command
{
    /**
     * @var Config
     */
    protected $config;

    protected function configure()
    {
        $this->config = new Config;
        $this->setName('connect');
        $this->setDescription('Connect to a defined connection');
        $this->addArgument('name_type', InputArgument::REQUIRED, 'Connection type or name.');
        $this->addArgument('name', InputArgument::OPTIONAL, 'Connection name.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nameOrType = $input->getArgument('name_type');
        $name = $input->getArgument('name');

        if($name) {
            $type = $nameOrType;
        } else {
            $name = $nameOrType;
            $type = $this->config->get('defaults.type');
        }

        $command = $this->getApplication()->find('connect:' . strtolower($type));

        return $command->run(new ArrayInput([ 'command' => 'connect:' . strtolower($type), 'name' => $name ]), $output);
    }

}