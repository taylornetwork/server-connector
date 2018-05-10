<?php

namespace TaylorNetwork\Console\ServerConnector\Commands;

use TaylorNetwork\Console\ServerConnector\Shell\ShellCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RegisterCommand extends Command
{
    protected function configure()
    {
        $this->setName('register');
        $this->setDescription('Register an alias in ~/.profile to make connecting easier');
        $this->addArgument(
            'alias',
            InputArgument::OPTIONAL,
            'Alias name to register',
            'connect'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $alias = $input->getArgument('alias');
        $bashAlias = 'alias ' . $alias . '="server-connector connect"';

        $bash = 'echo \'' . $bashAlias .'\' >> ~/.profile';

        $io = new SymfonyStyle($input, $output);

        $io->warning('This command will add an alias \'' . $alias .'\' to ~/.profile');

        if($io->confirm('Do you want to view the code that will be added?', false)) {
            $io->text('<comment>'.$bashAlias.'</comment>');
        }

        if($io->confirm('Do you want to continue?', false)) {
            if((new ShellCommand($bash))->exitCode === 0) {
                $io->success([
                    'Successfully added alias ' . $alias . ' to ~/.profile',
                    'Restart your terminal for the changes to take effect.',
                    'To use type \'' . $alias . ' <type> <name>\'',
                ]);
            } else {
                $io->error('An error occurred and the command was not registered.');
                $io->section('Manual Registration:');
                $io->text('<info>Add the following code to ~/.profile:</info>');
                $io->text($bashAlias);
            }
        } else  {
            $io->text('<comment>Action Cancelled.</comment>');
        }
    }

}