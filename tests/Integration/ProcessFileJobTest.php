<?php

namespace Tests\Integration;


use App\Jobs\ProcessFile;
use App\Models\File;
use Facades\App\Process;
use Illuminate\Support\Facades\Queue;
use Tests\DatabaseTestCase;

class ProcessFileJobTest extends DatabaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        Queue::swap($this->app->make('queue'));
    }

    /**
     * @test
     */
    public function dispatching_file_job_will_run_its_process()
    {
        $file = create(File::class, ['process' => 'service httpd restart']);

        dispatch_now(new ProcessFile($file));

        Process::assertExecuted('service httpd restart');
    }
}