<?php

namespace Tests\Integration;

use Facades\App\Process;
use Tests\TestCase;

class ProcessTest extends TestCase
{
    /**
     * @test
     */
    public function test_process()
    {
        Process::swap(new \App\Process());

        $output = Process::run(base_path('/tests/Integration/stub/process.sh'));

        $this->assertContains('process output', $output);
    }
}
