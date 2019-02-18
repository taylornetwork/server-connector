<?php

namespace TaylorNetwork\Console\ServerConnector\Tunnel;

use TaylorNetwork\Console\ServerConnector\Shell\TerminalCommand;

class Tunnel
{
    /**
     * Connection Credentials.
     *
     * @var array
     */
    public $credentials = [];

    /**
     * Base URL.
     *
     * @var string
     */
    public $url;

    /**
     * Command Action.
     *
     * @var string
     */
    public $action;

    /**
     * Key file.
     *
     * @var string
     */
    public $keyFile = null;

    /**
     * Tunnel constructor.
     *
     * @param string $url
     * @param array  $credentials
     */
    public function __construct($url = null, $credentials = [])
    {
        if ($url !== null) {
            $this->url = $url;
        }

        if (!empty($credentials)) {
            $this->setCredentials($credentials);
        }
    }

    /**
     * Set URL.
     *
     * @param string $url
     *
     * @return $this
     */
    public function setURL($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set Credentials.
     *
     * @param array $credentials
     *
     * @return $this
     */
    public function setCredentials($credentials)
    {
        $this->credentials = $credentials;

        return $this;
    }

    public function setKeyFile($keyFile)
    {
        $this->keyFile = $keyFile;

        return $this;
    }

    /**
     * Build the command.
     *
     * @return string
     */
    public function buildCommand()
    {
        $command = $this->action.' ';

        if ($this->keyFile) {
            $command .= '-i '.$this->keyFile.' ';
        }

        if (isset($this->credentials['username'])) {
            $command .= $this->credentials['username'];
            if (isset($this->credentials['password'])) {
                $command .= ':'.$this->credentials['password'];
            }
            $command .= '@';
        }

        $command .= $this->url;

        return $command;
    }

    /**
     * Connect the Tunnel.
     *
     * @return TerminalCommand
     */
    public function connect()
    {
        return new TerminalCommand($this->buildCommand());
    }
}
