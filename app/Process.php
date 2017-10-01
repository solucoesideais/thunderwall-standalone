<?php

namespace App;

use App\Exceptions\ProcessFailedException;
use App\Models\File;
use Symfony\Component\Process\Exception\ProcessFailedException as SymfonyProcessFailedException;
use Symfony\Component\Process\Process as SymfonyProcess;

class Process
{
    public function deploy()
    {
        // @TODO: test if I can just use ./vendor/bin/envoy
        $command = base_path('/vendor/bin/envoy') . ' run deploy';

        return $this->run($command);
    }

    /**
     * Run the file post-script process.
     *
     * @param File $file
     * @return string
     */
    public function file(File $file) {
        return $this->run($file->process);
    }

    /**
     * Run the given command.
     *
     * @param $command
     * @param null $directory
     * @return string
     */
    public function run($command, $directory = null)
    {
        $directory = $directory ?: base_path();

        $process = new SymfonyProcess($command);
        $process->setTimeout(30);
        $process->setIdleTimeout(30);
        $process->setWorkingDirectory($directory);

        try {
            $process->mustRun();

            return $process->getOutput();
        } catch (SymfonyProcessFailedException $e) {
            throw new ProcessFailedException($e->getProcess());
        }
    }
}