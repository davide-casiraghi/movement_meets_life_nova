<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create user and authenticate
     */
    public function authenticateAsUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }
}
