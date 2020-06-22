<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var User
     */
    private $user;

    protected function actingAsAdmin(): self
    {
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);

        return $this;
    }
}
