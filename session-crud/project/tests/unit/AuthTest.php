<?php

namespace Tests\unit;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class AuthTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testLoginPageGet()
    {
        $result = $this->get('/login');
        $result->assertStatus(200);
        $result->assertSee('Login');
    }

    public function testValidLoginPost()
    {
        $result = $this->post('/login', [
            'username' => 'viladoms',
            'password' => 'JVjv2026'
        ]);
        $result->assertRedirectTo('/');
    }
}
