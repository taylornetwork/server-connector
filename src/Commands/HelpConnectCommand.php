<?php

namespace TaylorNetwork\Console\ServerConnector\Commands;


use TaylorNetwork\Console\ServerConnector\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class HelpConnectCommand extends Command
{
    protected function configure()
    {
        $this->setName('help:connect');
        $this->setDescription('Get help with the connect command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Server Connector');

        $io->text('Easily connect to predefined connections via SSH or SFTP.');

        $io->section('Usage');

        $io->text(['connect']);
        $io->listing([
             'server-connector connect <name>         - Connect to the <name> connection using the default connection type.',
             'server-connector connect <type> <name>  - Connect to the <name> connection using the <type> connection type.',
        ]);

        $io->text('connect:ssh');
        $io->listing([
            'server-connector connect:ssh <name>     - Connect via SSH to the <name> connection.',
        ]);

        $io->text('connect:sftp');
        $io->listing([
            'server-connector connect:sftp <name>    - Connect via SFTP to the <name> connection.',
        ]);

        $io->note('You can use either the connection name or an alias as the <name> argument');

        $io->section('Available Connections');

        $connections = (new Config)->get('connections');

        $cells = [];
        foreach($connections as $name => $connection) {
            $cells[] = [ $name, $connection['url'], implode(', ', $connection['aliases']) ];
        }

        $io->table([ 'Connection Name', 'URL', 'Aliases' ], $cells);

        $io->text('Connections are stored in ' . getenv('HOME').'/ServerConnector/config/connections.php');
    }

}