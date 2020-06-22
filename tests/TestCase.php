<?php

namespace Tests;

use App\User;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $baseUrl = 'http://crm.app';

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
