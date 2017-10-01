<?php

namespace Tests;

use App\Models\User;
use Facades\App\Process;
use Facades\App\Disk;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Tests\Fake\DiskFake;
use Tests\Fake\ProcessFake;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();

        TestResponse::macro('assertFound', function () {
            $this->assertStatus(Response::HTTP_FOUND);

            return $this;
        });

        TestResponse::macro('assertSeeInput', function ($field) {
            $this->assertSee(sprintf('name="%s"', $field));

            return $this;
        });

        TestResponse::macro('assertSeeLink', function ($url) {
            $this->assertSee(sprintf('href="%s"', $url));

            return $this;
        });

        Disk::swap(new DiskFake);

        Process::swap(new ProcessFake);

        Queue::fake();

        // Avoid GitHub API by Default
        Cache::put('updateAvailable', false, 1);
    }

    public function signIn(User $user = null)
    {
        $user = $user ?: create(User::class);

        return $this->actingAs($user);
    }
}
