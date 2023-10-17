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

        $commands = [
            'commit -a -m "automatic update"',
            'push'
        ];

        $commands = array_map(function ($command) use ($gitCommitPrefix) {
            return $gitCommitPrefix . ' ' . $command;
        }, $commands);

        $commands = array_merge(
            ['cd ' . dirname(__DIR__, 3)],
            $commands
        );

        $command = implode(' && ', $commands);

        $this->line($command);

        exec($command, $output, $resultCode);

        echo implode("\n", $output);
    }
}
