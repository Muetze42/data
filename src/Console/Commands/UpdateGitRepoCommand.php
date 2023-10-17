<?php

namespace NormanHuth\ConsoleApp\Console\Commands;

class UpdateGitRepoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:git';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the GIT repository on GitHub.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $gitCommitPrefix = 'git -c user.name="' . $_ENV['GIT_COMMIT_USER_NAME'] .
            '" -c user.email="' . $_ENV['GIT_COMMIT_USER_EMAIL'] . '"';

        $gitCommands = [
            'commit -m "automatic update"',
//            'push'
        ];

        $gitCommands = array_map(function ($command) use ($gitCommitPrefix) {
            return $gitCommitPrefix . ' ' . $command;
        }, $gitCommands);

        $command = implode(' && ', $gitCommands);

        exec($command, $output, $resultCode);

        echo implode("\n", $output);
    }
}
