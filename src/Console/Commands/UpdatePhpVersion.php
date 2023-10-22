<?php

namespace NormanHuth\ConsoleApp\Console\Commands;

use Illuminate\Support\Str;

class UpdatePhpVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:php';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the latest PHP version.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $contents = file_get_contents('https://php.watch/api/v1/versions/latest');
        if (!Str::isJson($contents)) {
            return;
        }
        $data = json_decode($contents, true)['data'];
        $latest = $data[array_key_first($data)];

        $this->storeVersionData('php', $latest['name']);
    }
}
