<?php

namespace Tests\feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class AuthFilterTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testUnauthenticatedAccessRedirectsToLogin()
    {
        $result = $this->get('/');
        $result->assertRedirectTo('/login');
    }

    public function testAuthenticatedAccessPasses()
    {
        // Simulate logged in user
        $this->withSession(['logged_in' => true]);
        $result = $this->get('/');
        // Should not redirect to login
        $this->assertNotEquals('/login', $result->getRedirectUrl());
    }
}
