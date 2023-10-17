<?php

namespace NormanHuth\ConsoleApp\Console\Commands;

use Composer\Command\PackageDiscoveryTrait;
use Composer\Composer;
use Composer\Console\Application;
use Composer\IO\IOInterface;
use Composer\IO\NullIO;
use Composer\Package\Version\VersionParser;
use Composer\Repository\PlatformRepository;
use Illuminate\Support\Arr;

class UpdateComposerCommand extends Command
{
    use PackageDiscoveryTrait;

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
     * @var IOInterface
     */
    protected IOInterface $io;

    /**
     * @var Composer|null
     */
    protected ?Composer $composer;

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle(): void
    {
        $packages = config('packages.composer');
        $this->io = new NullIO();
        $this->composer = new Composer();

        $repos = new PlatformRepository([], config('packages.composer-requirements'));
        $requirements = $this->determineRequirements(
            $this->input,
            $this->output,
            $packages,
            $repos
        );
        $requirements = $this->parseRequirements($requirements);
        $this->storeVersionData('composer', $requirements);
    }

    /**
     * Parse requirements array to key => value pair.
     *
     * @param array $requirements
     *
     * @return array
     */
    protected function parseRequirements(array $requirements): array
    {
        return Arr::mapWithKeys($requirements, function (string $requirement) {
            list ($key, $value) = explode(' ', $requirement, 2);
            return [$key => $value];
        });
        $data = [];
        foreach ($requirements as $requirement) {
            list ($key, $value) = explode(' ', $requirement, 2);
            $data[$key] = $value;
        }
        return $data;
    }

    /**
     * @param array<string> $requirements
     *
     * @return list<array{name: string, version?: string}>
     */
    protected function normalizeRequirements(array $requirements): array
    {
        $parser = new VersionParser();

        return $parser->parseNameVersionPairs($requirements);
    }

    /**
     * @return \Composer\IO\IOInterface|\Composer\IO\NullIO
     */
    public function getIO(): IOInterface|NullIO
    {
        return $this->io;
    }

    /**
     * Retrieves the default Composer\Composer instance or throws
     * Use this instead of getComposer if you absolutely need an instance
     *
     * @param bool|null $disablePlugins If null, reads --no-plugins as default
     * @param bool|null $disableScripts If null, reads --no-scripts as default
     *
     * @throws \RuntimeException|\Composer\Json\JsonValidationException
     */
    public function requireComposer(?bool $disablePlugins = null, ?bool $disableScripts = null): Composer
    {
        if (null === $this->composer) {
            $application = parent::getApplication();
            if ($application instanceof Application) {
                $this->composer = $application->getComposer(true, $disablePlugins, $disableScripts);
                assert($this->composer instanceof Composer);
            } else {
                throw new \RuntimeException(
                    'Could not create a Composer\Composer instance, you must inject ' .
                    'one if this command is not used with a Composer\Console\Application instance'
                );
            }
        }

        return $this->composer;
    }
}
