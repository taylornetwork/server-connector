<?php

namespace TaylorNetwork\Console\ServerConnector\Shell;

use TaylorNetwork\Console\ServerConnector\Contracts\CommandContract;

abstract class Command implements CommandContract
{
    /**
     * Command to run.
     *
     * @var string
     */
    protected string $command;

    /**
     * Command contructor.
     *
     * @param string $command
     * @param bool $defer
     */
    public function __construct(string $command, bool $defer = false)
    {
        $this->command = $command;

        if (!$defer) {
            $this->execute();
        }
    }

    /**
     * __get.
     *
     * @param string $property
     * @return mixed
     */
    public function __get(string $property)
    {
        return $this->$property;
    }

}
