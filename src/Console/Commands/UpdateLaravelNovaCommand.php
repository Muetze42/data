<?php

namespace NormanHuth\ConsoleApp\Console\Commands;

class UpdateLaravelNovaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:nova';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the latest versions of Laravel Nova.';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle(): void
    {
        $contents = file_get_contents('https://nova.laravel.com/releases');
        if (!$contents) {
            return;
        }
        $contents = explode('data-page="', $contents)[1];
        $contents = explode('"', $contents)[0];
        $contents = htmlspecialchars_decode($contents, ENT_QUOTES | ENT_SUBSTITUTE);
        $data = json_decode($contents, true);
        $releases = data_get($data, 'props.releases');
        if (!$releases || empty($releases[0]) || empty($releases[0]['version'])) {
            return;
        }

        $latest = $releases[0]['version'];
        if (!str_starts_with('^', $latest)) {
            $latest = '^' . $latest;
        }

        $this->storeVersionData('composer', ['laravel/nova' => $latest], true);
    }
}
