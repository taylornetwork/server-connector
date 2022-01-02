<?php

return [

    // Name of the connection as the key
    'example' => [

        // Add any short aliases to access this as
        'aliases' => ['ex', 'e'],

        // Add credentials here, or an empty array
        'credentials' => [
            'username' => 'user1',

            // Password is not recommended, ideally omit this and use ssh keys
            'password' => 'password1',
        ],

        // Omit to use default or you can set the path to a private key
        'keyFile' => '~/.ssh/id_rsa',

        // Omit to use 22 by default or can set here
        'port' => 22,

        // URL or IP address to connect to
        'url' => 'connect.example.com',
    ],
];
