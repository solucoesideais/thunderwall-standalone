<?php

namespace Tests;

use App\Models\User;
use Facades\App\Disk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\Fake\FakeDisk;

abstract class AuthenticatedTestCase extends DatabaseTestCase
{
    use CreatesApplication;

    /**
     * @var User
     */
    protected $user;

    protected function setUp()
    {
        parent::setUp();

        $this->actingAs($this->user = create(User::class));

        // Redirect any file creation to /storage/tests
        Disk::swap(new FakeDisk);

        // Avoid GitHub API by Default
        Cache::put('updateAvailable', false, 1);
    }
}
