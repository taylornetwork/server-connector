<?php

namespace TaylorNetwork\Console\ServerConnector;

use Adbar\Dot;

class Config
{
    const LOCAL_CONFIG_PATH = '{HOME}/ServerConnector/config';

    /**
     * @var Dot
     */
    protected $config;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->config = new Dot(include __DIR__.'/config/config.php');
    }

    /**
     * Get all config
     *
     * @return array
     */
    public function all()
    {
        return $this->config->all();
    }

    /**
     * Get by key using array dot notation
     *
     * This will also search for aliases
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if($value = $this->config->get($key)) {
            return $value;
        }

        // If we can't find the value of the key, double check by recursively searching as an alias
        $explodedKey = explode('.', $key);

        while(!$this->config->get(implode('.', $explodedKey))) {
            unset($explodedKey[count($explodedKey) - 1]);
            if($explodedKey === []) {
                return null;
            }
        }

        $parent = implode('.', $explodedKey);
        $alias = explode('.', str_replace($parent.'.', '', $key))[0];

        if($results = $this->searchByAlias($parent, $alias)) {
            if($parent.'.'.$alias === $key) {
                return $results;
            }
            return (new Dot($results))->get(str_replace($parent.'.'.$alias.'.', '', $key));
        }

        return null;
    }

    /**
     * See if a parent key has an alias key
     *
     * @param string $parent
     * @param string $alias
     * @return mixed
     */
    public function searchByAlias($parent, $alias)
    {
        $parent = $this->config->get($parent);

        if(gettype($parent) === 'array') {
            foreach($parent as $key => $item) {
                if(gettype($item) === 'array' && array_key_exists('aliases', $item) && in_array($alias, $item['aliases'])) {
                    return $item;
                }
            }
        }

        return null;
    }

    /**
     * Return the config Adbar\Dot object
     *
     * @return Dot
     */
    public function config()
    {
        return $this->config;
    }

    public static function publish()
    {
        $destination = self::getLocalConfigPath();

        if(!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        copy(__DIR__.'/config/connections.example.php', $destination.'/connections.php');
        copy(__DIR__.'/config/defaults.example.php', $destination.'/defaults.php');
    }

    public static function getLocalConfigPath()
    {
        return str_replace('{HOME}', getenv('HOME'), self::LOCAL_CONFIG_PATH);
    }
}