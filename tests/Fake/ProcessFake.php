<?php

namespace Tests\Fake;

use App\Process;
use PHPUnit\Framework\Assert as PHPUnit;

class ProcessFake extends Process
{
    /**
     * @var array
     */
    protected $commands = [];

    public function run($command, $directory = null)
    {
        $this->commands[] = $command;
    }

    public function assertExecuted($command)
    {
        PHPUnit::assertTrue(
            in_array($command, $this->commands),
            "The expected $command was never executed"
        );
    }

}