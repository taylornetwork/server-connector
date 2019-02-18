<?php

namespace TaylorNetwork\Console\ServerConnector\Shell;

class ShellCommand
{
    /**
     * Returned from running exec.
     *
     * @var mixed
     */
    protected $exec;

    /**
     * Command to run.
     *
     * @var string
     */
    protected $command;

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
    protected $exitCode;

    /**
     * ShellCommand constructor.
     *
     * @param string $command
     * @param bool   $defer
     */
    public function __construct($command, $defer = false)
    {
        $this->command = $command;

        if (!$defer) {
            $this->execute();
        }
    }

    /**
     * Execute the command.
     */
    public function execute()
    {
        $this->exec = exec($this->command, $this->output, $this->exitCode);
    }

    /**
     * Get a property.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }
}
