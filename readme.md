# ServerConnector

Do you need to ssh/sftp into servers and get tired of always typing `ssh user@some-connection.org`? Or worse having to type an IP address?

This console application will allow you to define connections you make frequently to connect as easy as `connect e`

## Install

Using Composer

```bash
$ composer global require taylornetwork/server-connector
```

## Config

Config files will be published to `~/ServerConnector/config/`

Note: if config files are not automatically published run the `config:publish` command.

```bash
$ server-connector config:publish
```

#### defaults.php

Defines the default connection type if omitted.

```php
// defaults.php

return [
	'type' => 'ssh',
];
```

#### connections.php

This is where you define all your server connections.

By default:

```php
// connections.php

return [

	// Name of the connection as the key
	'example' => [
	
		// Add any short aliases to access this as
       'aliases' => [ 'ex', 'e' ],
       
       // Add credentials here, or an empty array
       'credentials' => [
            'username' => 'user1',
            
            // Password is not recommended, ideally omit this and use ssh keys
            'password' => 'password1',
        ],
        
        // URL or IP address to connect to
        'url' => 'connect.example.com',
    ],
];
```

Add your connections in the array that will be returned.

## Usage

Once you have defined some connections you can run 

```bash
$ server-connector connect ConnectionNameOrAlias
```

Which will connect to the connection with the default connection type

Alternatively 

```bash
$ server-connector connect sftp ConnectionNameOrAlias
```

To connect via SFTP if it isn't the default.

### Register BASH Function

To add a function to your `~/.profile` to call `server-connector` you can use 

```bash
$ server-connector register
```

By default it will register a function `connect()` in your `~/.profile` you can specify the function name by

```bash
$ server-connector register FunctionName
```

After running this command you will need to source your `~/.profile` or restart your terminal application.

---

With the BASH function you can call this application by

```bash
connect ConnectionNameOrAlias
```
