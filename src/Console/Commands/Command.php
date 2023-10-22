<?php

namespace NormanHuth\ConsoleApp\Console\Commands;

use Illuminate\Console\Command as ConsoleCommand;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ExpectedValues;

class Command extends ConsoleCommand
{
    public function __construct()
    {
        set_time_limit(0);
        parent::__construct();
    }

    /**
     * Store versions data.
     *
     * @param string       $key
     * @param array|string $data
     * @param bool         $merge
     *
     * @return void
     */
    protected function storeVersionData(
        #[ExpectedValues(values: ['composer', 'npm', 'php'])]
        string $key,
        array|string $data,
        bool $merge = false
    ): void {
        $file = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'versions.json';

        $allData = [];
        if (file_exists($file)) {
            $contents = file_get_contents($file);
            if (Str::isJson($contents)) {
                $allData = json_decode($contents, true);
            }
        }

        if ($merge) {
            $data = array_merge(
                data_get($allData, $key, []),
                $data
            );
        }

        if (is_array($data)) {
            ksort($data);
        }
        data_set($allData, $key, $data);

        file_put_contents(
            $file,
            json_encode($allData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );
    }
}
