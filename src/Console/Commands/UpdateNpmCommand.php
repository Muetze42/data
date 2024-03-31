<?php

namespace NormanHuth\ConsoleApp\Console\Commands;

use GuzzleHttp\Client;

class UpdateNpmCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:npm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the latest versions of configuration NPM packages.';

    /**
     * Execute the console command.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(): void
    {

        $versions = [];
        $packages = config('packages');

        foreach ($packages['npm'] as $package) {
            $contents = json_decode(
                file_get_contents('https://registry.npmjs.org/' . $package . '/latest'),
                true
            );
            if (!$contents['version']) {
                // Todo: Log / Notification etc.
                die('Error');
            }
            $versions[$package] = $contents['version'];
        }

        $client = new Client([
            'base_uri' => 'https://npm.fontawesome.com',
            'auth' => [$_ENV['FONT_AWESOME_NAME'], $_ENV['FONT_AWESOME_TOKEN']]
        ]);

        foreach ($packages['fontawesome'] as $package) {
            $contents = json_decode(
                ($client->get($package . '/latest'))->getBody(),
                true
            );
            if (!$contents['version']) {
                // Todo: Log / Notification etc.
                die('Error');
            }
            $version = str_starts_with($contents['version'], '^') ? $contents['version'] : '^' . $contents['version'];
            $versions[$package] = $version;
        }

        $this->storeVersionData('npm', $versions);
    }
}
