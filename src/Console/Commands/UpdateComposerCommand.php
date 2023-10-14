<?php

namespace NormanHuth\ConsoleApp\Console\Commands;

class UpdateComposerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:composer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the latest versions of configuration Composer packages.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->line((string) time());
    }
}
