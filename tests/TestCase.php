<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;

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
    }
}
