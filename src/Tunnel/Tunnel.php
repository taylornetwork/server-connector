<?php

namespace TaylorNetwork\Console\ServerConnector\Tunnel;

use TaylorNetwork\Console\ServerConnector\Shell\TerminalCommand;

class Tunnel
{
    /**
     * Use a specific port argument.
     */
    const ARG_PORT = '-p';

    /**
     * Use a specific key file argument.
     */
    const ARG_KEY_FILE = '-i';

    /**
     * Connection Credentials.
     *
     * @var array
     */
    public array $credentials = [];

    /**
     * Base URL.
     *
     * @var string
     */
    public string $url;

    /**
     * Command Action.
     *
     * @var string
     */
    public string $action;

    /**
     * Key file.
     *
     * @var string|null
     */
    public ?string $keyFile = null;

    /**
     * Port.
     *
     * @var int
     */
    public int $port = 22;

    /**
     * Tunnel constructor.
     *
     * @param string|null $url
     * @param array  $credentials
     */
    public function __construct(?string $url = null, array $credentials = [])
    {
        if ($url !== null) {
            $this->url = $url;
        }

        if (!empty($credentials)) {
            $this->setCredentials($credentials);
        }
    }

    /**
     * New instance from config item.
     *
     * @param array $config
     *
     * @return static
     */
    public static function newFromConfig(array $config): Tunnel
    {
        $tunnel = new static($config['url'], $config['credentials']);

        if (isset($config['port'])) {
            $tunnel->setPort($config['port']);
        }

        if (isset($config['keyFile'])) {
            $tunnel->setKeyFile($config['keyFile']);
        }

        return $tunnel;
    }

    /**
     * Set URL.
     *
     * @param string $url
     *
     * @return $this
     */
    public function setURL(string $url): Tunnel
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set the port.
     *
     * @param int $port
     *
     * @return $this
     */
    public function setPort(int $port): Tunnel
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get the port.
     *
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * Set Credentials.
     *
     * @param array $credentials
     *
     * @return $this
     */
    public function setCredentials(array $credentials): Tunnel
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * Set the key file.
     *
     * @param string $keyFile
     * @return $this
     */
    public function setKeyFile(string $keyFile): Tunnel
    {
        $this->keyFile = $keyFile;

        return $this;
    }

    /**
     * Build the command.
     *
     * @return string
     */
    public function buildCommand(): string
    {
        $command = $this->action.' '.static::ARG_PORT.' '.$this->port.' ';

        if ($this->keyFile) {
            $command .= static::ARG_KEY_FILE.' '.$this->keyFile.' ';
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
    public function connect(): TerminalCommand
    {
        return new TerminalCommand($this->buildCommand());
    }
}
