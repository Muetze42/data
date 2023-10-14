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

if (!function_exists('getStorageData')) {
    /**
     * Get the specific storage data.
     *
     * @param string $file
     *
     * @return array
     */
    function getStorageData(string $file = 'versions'): array
    {
        $file = storageFilePath($file);

        return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    }
}


if (!function_exists('setStorageData')) {
    function setStorageData(array $data, $file = 'versions'): void
    {
        file_put_contents(
            storageFilePath($file),
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );
    }
}

if (!function_exists('storageFilePath')) {
    /**
     * Get storage file path.
     *
     * @param string $file
     *
     * @return string
     */
    function storageFilePath(string $file): string
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $file . '.json';
    }
}
