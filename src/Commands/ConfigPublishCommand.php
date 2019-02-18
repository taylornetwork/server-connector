<?php

namespace TaylorNetwork\Console\ServerConnector\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TaylorNetwork\Console\ServerConnector\Config;

class ConfigPublishCommand extends Command
{
    protected function configure()
    {
        $this->setName('config:publish');
        $this->setDescription('Publish the config files, if it wasn\'t done automatically');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $publish = true;

        if (file_exists(Config::getLocalConfigPath().'/connections.php')) {
            $publish = $io->confirm('Looks like config has already been published, overwrite existing config?', false);
        }

        if ($publish) {
            Config::publish();
            $io->success('Config published successfully to '.Config::getLocalConfigPath());
        } else {
            $io->text('<comment>Publish Cancelled!</comment>');
        }
    }
}
