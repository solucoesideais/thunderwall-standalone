<?php

namespace App\Http\Controllers;

use App\Support\GitHub;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class VersionController extends Controller
{
    public function index(GitHub $gitHub)
    {
        $release = $gitHub->latestRelease();

        return view('app.version.index', compact('release'));
    }

    public function update()
    {
        Cache::forget('updateAvailable');

        $output = $this->runEnvoy();

        return redirect('/version')->with('output', $output);
    }

    protected function runEnvoy()
    {
        $version = (new GitHub())->latestVersion();

        $command = base_path('/vendor/bin/envoy') . sprintf(' run deploy --tag=%s', $version);
        $directory = base_path();

        $process = new Process($command);
        $process->setTimeout(30);
        $process->setIdleTimeout(30);
        $process->setWorkingDirectory($directory);

        try {
            $process->mustRun();

            return $process->getOutput();
        } catch (ProcessFailedException $e) {
            return $e->getMessage();
        }
    }
}
