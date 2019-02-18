<?php

return [

    'defaults' => file_exists($file = getenv('HOME').'/ServerConnector/config/defaults.php')
                    ? include $file
                    : ['type' => 'ssh'],

    'connections' => file_exists($file = getenv('HOME').'/ServerConnector/config/connections.php')
                    ? include $file
                    : [],

];
