<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
    }
}
