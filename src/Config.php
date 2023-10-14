<?php

namespace NormanHuth\ConsoleApp;

use Illuminate\Config\Repository;

class Config extends Repository
{
    protected static Config $instance;

    protected string $configPath;

    public function __construct(array $items = [])
    {
        parent::__construct($items);

        $this->configPath = __DIR__ . '/../config';
        $this->loadConfigFiles();
    }

    /**
     * Load all config files.
     *
     * @return void
     */
    protected function loadConfigFiles(): void
    {
        $files = glob($this->configPath . '/*.php');
        $files = array_map('realpath', $files);

        foreach ($files as $file) {
            $this->set(basename($file, '.php'), require $file);
        }
    }
}
