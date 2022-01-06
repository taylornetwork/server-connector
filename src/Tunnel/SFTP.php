<?php

namespace TaylorNetwork\Console\ServerConnector\Tunnel;

class SFTP extends Tunnel
{
    /**
     * {@inheritdoc}
     */
    const ARG_PORT = '-P';

    /**
     * {@inheritdoc}
     */
    public $action = 'sftp';
}
