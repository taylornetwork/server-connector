<?php

namespace TaylorNetwork\Console\ServerConnector\Shell;

class TerminalCommand extends Command
{
    /**
     * Is this running from command line?
     *
     * @return bool
     */
    public function is_cli()
    {
        return php_sapi_name() === 'cli';
    }

    /**
     * Execute the command.
     */
    public function execute()
    {
        if ($this->is_cli()) {
            return $this->executePassthru();
        }

        return $this->executeShellCommand();
    }

    /**
     * Execute as a Shell Command.
     *
     * @return ShellCommand
     */
    public function executeShellCommand()
    {
        return new ShellCommand($this->command);
    }

    /**
     * Execute a passthru command.
     *
     * @return mixed
     */
    public function executePassthru()
    {
        passthru($this->command, $return);

        return $return;
    }
}
