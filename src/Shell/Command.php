<?php

namespace TaylorNetwork\Console\ServerConnector\Shell;

use TaylorNetwork\Console\ServerConnector\Config;
use TaylorNetwork\Console\ServerConnector\Contracts\CommandContract;

abstract class Command implements CommandContract
{
    /**
     * @var Config
     */
    protected Config $config;

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
        $this->config = new Config();

        $this->command = '';

        if($before = implode(';', $this->config->get('defaults.connect_hooks.before') ?? [])) {
            $this->command .= $before.';';
        }

        $this->command .= $command;

        if($after = implode(';', $this->config->get('defaults.connect_hooks.after') ?? [])) {
            $this->command .= ';'.$after;
        }

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
