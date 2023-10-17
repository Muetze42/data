<?php

use NormanHuth\ConsoleApp\Config;

if (!function_exists('config')) {
    /**
     * Get the specified configuration value.
     *
     * @param array|string $key
     * @param mixed|null   $default
     *
     * @return mixed
     */
    function config(array|string $key, mixed $default = null): mixed
    {
        return (new Config())->get($key, $default);
    }
}
