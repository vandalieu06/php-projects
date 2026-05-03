<?php

namespace App\Controllers;

class Auth extends BaseController
{
    protected $hashCalculat;

    public function __construct()
    {
        $this->hashCalculat = password_hash('JVjv2026', PASSWORD_DEFAULT);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            if ($username === 'viladoms' && password_verify($password, $this->hashCalculat)) {
                session()->set('logged_in', true);
                return redirect()->to('/');
            } else {
                return redirect()->to('/login')->with('error', 'Invalid credentials');
            }
        }
        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
