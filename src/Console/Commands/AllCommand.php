<?php

namespace NormanHuth\ConsoleApp\Console\Commands;

class AllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all commands.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call('update:npm');
        $this->call('update:composer');
        $this->call('update:nova');
        $this->call('update:git');
    }
}
