<?php

namespace TaylorNetwork\Console\ServerConnector\Shell;

class ShellCommand extends Command
{
    /**
     * Returned from running exec.
     *
     * @var mixed
     */
    protected $exec;

    /**
     * Output from running exec.
     *
     * @var mixed
     */
    protected $output;

    /**
     * Exit code from exec.
     *
     * @var int
     */
    protected int $exitCode;

    /**
     * Execute the command.
     */
    public function execute(): void
    {
        $this->exec = exec($this->command, $this->output, $this->exitCode);
    }
}
