<?php

namespace TaylorNetwork\Console\ServerConnector;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Config
{
    const LOCAL_CONFIG_PATH = '{HOME}/ServerConnector/config';

    /**
     * @var Collection
     */
    protected Collection $config;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->config = collect(include __DIR__.'/config/config.php');
    }

    /**
     * Get all config.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->config->all();
    }

    /**
     * Get by key using array dot notation.
     *
     * This will also search for aliases
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        if ($value = Arr::get($this->config, $key)) {
            return $value;
        }

        // If we can't find the value of the key, double check by recursively searching as an alias
        $explodedKey = explode('.', $key);

        while (!Arr::get($this->config, implode('.', $explodedKey))) {
            unset($explodedKey[count($explodedKey) - 1]);
            if ($explodedKey === []) {
                return null;
            }
        }

        $parent = implode('.', $explodedKey);
        $alias = explode('.', str_replace($parent.'.', '', $key))[0];

        if ($results = $this->searchByAlias($parent, $alias)) {
            if ($parent.'.'.$alias === $key) {
                return $results;
            }

            return Arr::get($results, str_replace($parent.'.'.$alias.'.', '', $key));
        }

        return null;
    }

    /**
     * See if a parent key has an alias key.
     *
     * @param string $parent
     * @param string $alias
     *
     * @return mixed
     */
    public function searchByAlias(string $parent, string $alias)
    {
        $parent = Arr::get($this->config, $parent);

        if (gettype($parent) === 'array') {
            foreach ($parent as $key => $item) {
                if (gettype($item) === 'array' && array_key_exists('aliases', $item) && in_array($alias, $item['aliases'])) {
                    return $item;
                }
            }
        }

        return null;
    }

    /**
     * Return the config Collection object.
     *
     * @return Collection
     */
    public function config(): Collection
    {
        return $this->config;
    }

    /**
     * Publish the config to local path.
     *
     * @return void
     */
    public static function publish(): void
    {
        $destination = self::getLocalConfigPath();

        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        copy(__DIR__.'/config/connections.example.php', $destination.'/connections.php');
        copy(__DIR__.'/config/defaults.example.php', $destination.'/defaults.php');
    }

    /**
     * Get local config path.
     *
     * @return string
     */
    public static function getLocalConfigPath(): string
    {
        return str_replace('{HOME}', getenv('HOME'), self::LOCAL_CONFIG_PATH);
    }
}
