<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * @test
     */
    public function cannot_access_admin_panel_unless_authenticated()
    {
        $this->get('/admin')->assertRedirect(route('login'));
    }
}
