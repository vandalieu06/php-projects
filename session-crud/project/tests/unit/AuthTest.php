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

    public function testInvalidLoginPost()
    {
        $result = $this->post('/login', [
            'username' => 'viladoms',
            'password' => 'wrongpassword'
        ]);
        $result->assertNotRedirectTo('/');
        $this->assertNotNull(session()->get('error'));
    }

    public function testLoginSetsSession()
    {
        $this->post('/login', [
            'username' => 'viladoms',
            'password' => 'JVjv2026'
        ]);
        $this->assertTrue(session()->get('logged_in') === true);
    }

    public function testLogout()
    {
        $this->post('/login', [
            'username' => 'viladoms',
            'password' => 'JVjv2026'
        ]);
        $result = $this->get('/logout');
        $result->assertRedirectTo('/login');
        $this->assertNull(session()->get('logged_in'));
    }
}
