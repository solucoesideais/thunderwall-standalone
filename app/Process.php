<?php

namespace App;

use App\Exceptions\ProcessFailedException;
use Symfony\Component\Process\Exception\ProcessFailedException as SymfonyProcessFailedException;
use Symfony\Component\Process\Process as SymfonyProcess;

class Process
{
    public static function deploy()
    {
        // @TODO: test if I can just use ./vendor/bin/envoy
        $command = base_path('/vendor/bin/envoy') . ' run deploy';

        return (new Process)->run($command);
    }

    public static function firewall()
    {
        return (new Process)->run('/etc/rc.d/rc.firewall', '/');
    }

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