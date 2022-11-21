<?php

namespace TaylorNetwork\Console\ServerConnector\Contracts;

interface CommandContract
{
    /**
     * Command constructor.
     *
     * @param string $command
     * @param bool   $defer
     */
    public function __construct(string $command, bool $defer = false);

    /**
     * Execute the command.
     *
     * @return mixed
     */
    public function execute();

    /**
     * __get.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get(string $property);
}
