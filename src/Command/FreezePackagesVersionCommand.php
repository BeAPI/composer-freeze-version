<?php

namespace BEA\Composer\FreezePackagesVersionPlugin\Command;

use Composer\Command\BaseCommand;
use Composer\Json\JsonFile;
use JsonSchema\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FreezePackagesVersionCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('freeze-version');
        $this->setDescription(
            'Freeze all the package\'s versions in your composer.json with the ones from the lock file.'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = $this->getIO();
        $composer = $this->getComposer();

        // what is the command's purpose
        $output->writeln(
            "<info>Hello, this command allows you to freeze all plugins versions according to your composer.lock file.</info>"
        );
        if (false === $io->askConfirmation(
                "Do you really want to freeze all requirement versions now (y/n) ? ",
                true
            )) {
            exit;
        }

        $composerPath = $composer->getConfig()->getConfigSource()->getName();
        $lockPath = str_replace('.json', '.lock', $composerPath);

        $composerFile = new JsonFile($composerPath);
        if (!$composerFile->exists()) {
            $output->writeln("<error>Composer file not found.</error>");
            exit;
        }

        // if we cannot write then bail
        if (!is_writeable($composerPath)) {
            $output->writeln("<error>The composer.json file cannot be rewritten !</error>");
            $output->writeln("<error>Please check your file permissions.</error>");
            exit;
        }

        $lockFile = new JsonFile($lockPath);
        if (!$lockFile->exists()) {
            $output->writeln("<warning>No composer lock file found.</warning>");
            $output->writeln("You need to run a composer update once before using this command.");
            exit;
        }

        try {
            $composerJson = $composerFile->read();
            $lockJson = $lockFile->read();
            if (!isset($lockJson['packages']) || !isset($lockJson['packages-dev'])) {
                $output->writeln("<warning>Your lock file does not contain any packages.<warning>");
                exit;
            }

            if (isset($composerJson['require'])) {
                $lockVersions = array_column($lockJson['packages'], 'version', 'name');
                foreach ($composerJson['require'] as $package => $version) {
                    if (!isset($lockVersions[$package])) {
                        continue;
                    }
                    $composerJson['require'][$package] = (string) $lockVersions[$package];
                }
            }

            if (isset($composerJson['require-dev'])) {
                $lockVersions = array_column($lockJson['packages-dev'], 'version', 'name');
                foreach ($composerJson['require-dev'] as $package => $version) {
                    if (!isset($lockVersions[$package])) {
                        continue;
                    }
                    $composerJson['require-dev'][$package] = (string) $lockVersions[$package];
                }
            }

            $composerFile->write($composerJson);
            $output->writeln("All required versions have been freezed \o/");
        } catch (RuntimeException $e) {
            $output->writeln("<error>An error occurred</error>");
            $output->writeln(sprintf("<error>%s</error>", $e->getMessage()));
            exit;
        }
    }
}