# Login and Photo Upload Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Implement login system with session management and photo upload functionality for players in the CodeIgniter 4 project.

**Architecture:** Use CodeIgniter 4's built-in session handling, filters for route protection, and file upload methods. Create a new Auth controller for login/logout, an Auth filter to protect routes, update JugadorModel and player form for photo upload, and add a method to display photos.

**Tech Stack:** CodeIgniter 4, PHP, MySQL, Session handling, File upload

---

## File Structure Mapping

### Files to Create:
- `project/app/Controllers/Auth.php` - Auth controller with login/logout methods
- `project/app/Filters/AuthFilter.php` - Filter to check authentication for protected routes
- `project/app/Views/auth/login.php` - Login form view
- `project/tests/unit/AuthTest.php` - Tests for Auth controller
- `project/tests/unit/AuthFilterTest.php` - Tests for Auth filter

### Files to Modify:
- `project/app/Config/Routes.php` - Add login, logout, photo display routes
- `project/app/Config/Filters.php` - Register AuthFilter
- `project/app/Models/JugadorModel.php` - Add `foto` to `$allowedFields`
- `project/app/Controllers/Main.php` - Add `mostrarFoto()` method, update `insertarJugador()` for photo upload
- `project/app/Views/form_jugador.php` - Add file input, set `enctype`
- `project/app/Views/llistat_jugadors.php` - Display player photos

---

### Task 1: Create Auth Controller with Login/Logout

**Files:**
- Create: `project/app/Controllers/Auth.php`
- Create: `project/app/Views/auth/login.php`
- Test: `project/tests/unit/AuthTest.php`

- [ ] **Step 1: Write failing test for login page GET**

```php
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
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `cd project && php vendor/bin/phpunit tests/unit/AuthTest.php --filter testLoginPageGet`
Expected: FAIL (Auth controller not found)

- [ ] **Step 3: Create minimal Auth controller and login view**

`project/app/Controllers/Auth.php`:
```php
<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }
}
```

`project/app/Views/auth/login.php`:
```html
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
</body>
</html>
```

- [ ] **Step 4: Run test to verify it passes**

Run: `cd project && php vendor/bin/phpunit tests/unit/AuthTest.php --filter testLoginPageGet`
Expected: PASS

- [ ] **Step 5: Commit**

```bash
git add project/app/Controllers/Auth.php project/app/Views/auth/login.php project/tests/unit/AuthTest.php
git commit -m "feat: add Auth controller with login GET method and basic view"
```

- [ ] **Step 6: Write failing test for valid login POST**

Add to `AuthTest.php`:
```php
public function testValidLoginPost()
{
    $result = $this->post('/login', [
        'username' => 'viladoms',
        'password' => 'JVjv2026'
    ]);
    $result->assertRedirectTo('/');
}
```

- [ ] **Step 7: Run test to verify it fails**

Run: `cd project && php vendor/bin/phpunit tests/unit/AuthTest.php --filter testValidLoginPost`
Expected: FAIL (no redirect)

- [ ] **Step 8: Implement login POST with password verification**

Update `project/app/Controllers/Auth.php`:
```php
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
```

Update `project/app/Views/auth/login.php` to add form:
```html
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (session()->get('error')): ?>
        <div style="color: red"><?= session()->get('error') ?></div>
    <?php endif; ?>
    <form method="POST" action="/login">
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
```

- [ ] **Step 9: Run test to verify it passes**

Run: `cd project && php vendor/bin/phpunit tests/unit/AuthTest.php --filter testValidLoginPost`
Expected: PASS

- [ ] **Step 10: Commit**

```bash
git add project/app/Controllers/Auth.php project/app/Views/auth/login.php
git commit -m "feat: implement login POST with password verification and logout"
```

---

### Task 2: Create Auth Filter for Route Protection

**Files:**
- Create: `project/app/Filters/AuthFilter.php`
- Test: `project/tests/unit/AuthFilterTest.php`

- [ ] **Step 1: Write failing test for unauthenticated access**

`project/tests/unit/AuthFilterTest.php`:
```php
<?php

namespace Tests\unit;

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
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `cd project && php vendor/bin/phpunit tests/unit/AuthFilterTest.php --filter testUnauthenticatedAccessRedirectsToLogin`
Expected: FAIL (no redirect)

- [ ] **Step 3: Implement AuthFilter**

`project/app/Filters/AuthFilter.php`:
```php
<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
```

- [ ] **Step 4: Register filter in Filters.php**

Modify `project/app/Config/Filters.php`:
Add to `$aliases` array:
```php
'auth' => \App\Filters\AuthFilter::class,
```

- [ ] **Step 5: Apply filter to routes in Routes.php**

Modify `project/app/Config/Routes.php`:
Replace existing route definitions with:
```php
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Main::index');
    $routes->get('/insertarEquip', 'Main::insertarEquip');
    $routes->post('/insertarEquip', 'Main::insertarEquip');
    $routes->get('/mostrarEquips', 'Main::mostrarEquips');
    $routes->get('/eliminarEquip', 'Main::eliminarEquip');
    $routes->post('/eliminarEquip', 'Main::eliminarEquip');
    $routes->get('/insertarJugador', 'Main::insertarJugador');
    $routes->post('/insertarJugador', 'Main::insertarJugador');
    $routes->get('/mostrarJugadors', 'Main::mostrarJugadors');
    $routes->get('/eliminarJugador', 'Main::eliminarJugador');
    $routes->post('/eliminarJugador', 'Main::eliminarJugador');
    $routes->get('/senseModel', 'Main::senseModel');
    $routes->get('/mostrarFoto/(:any)', 'Main::mostrarFoto/$1');
});
// Public routes
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
```

- [ ] **Step 6: Run test to verify it passes**

Run: `cd project && php vendor/bin/phpunit tests/unit/AuthFilterTest.php --filter testUnauthenticatedAccessRedirectsToLogin`
Expected: PASS

- [ ] **Step 7: Commit**

```bash
git add project/app/Filters/AuthFilter.php project/app/Config/Filters.php project/app/Config/Routes.php project/tests/unit/AuthFilterTest.php
git commit -m "feat: add AuthFilter for route protection and update routes"
```

---

### Task 3: Update JugadorModel for Photo Field

**Files:**
- Modify: `project/app/Models/JugadorModel.php`

- [ ] **Step 1: Write failing test for foto field insertion**

Create `project/tests/unit/JugadorModelTest.php`:
```php
<?php

namespace Tests\unit;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class JugadorModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = false;

    public function testJugadorModelAllowsFotoField()
    {
        $model = new \App\Models\JugadorModel();
        $data = [
            'nom' => 'Test',
            'cognoms' => 'User',
            'demarcacio' => 'Forward',
            'codiE' => 1,
            'foto' => 'test.jpg'
        ];
        $result = $model->insert($data);
        $this->assertNotNull($result);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `cd project && php vendor/bin/phpunit tests/unit/JugadorModelTest.php --filter testJugadorModelAllowsFotoField`
Expected: FAIL (foto not in allowedFields)

- [ ] **Step 3: Add foto to allowedFields**

Modify `project/app/Models/JugadorModel.php`:
Update `$allowedFields`:
```php
protected $allowedFields = ["nom", "cognoms", "demarcacio", "codiE", "foto"];
```

- [ ] **Step 4: Run test to verify it passes**

Run: `cd project && php vendor/bin/phpunit tests/unit/JugadorModelTest.php --filter testJugadorModelAllowsFotoField`
Expected: PASS (Note: Requires test database configuration)

- [ ] **Step 5: Commit**

```bash
git add project/app/Models/JugadorModel.php project/tests/unit/JugadorModelTest.php
git commit -m "feat: add foto to JugadorModel allowedFields"
```

---

### Task 4: Update Player Form for Photo Upload

**Files:**
- Modify: `project/app/Views/form_jugador.php`

- [ ] **Step 1: Write failing test for file input presence**

Add to `project/tests/unit/MainTest.php`:
```php
<?php

namespace Tests\unit;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class MainTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testPlayerFormHasFileInput()
    {
        $this->withSession(['logged_in' => true]);
        $result = $this->get('/insertarJugador');
        $result->assertSee('type="file"', 'foto');
        $result->assertSee('enctype="multipart/form-data"');
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `cd project && php vendor/bin/phpunit tests/unit/MainTest.php --filter testPlayerFormHasFileInput`
Expected: FAIL (no file input)

- [ ] **Step 3: Update form_jugador.php**

Modify `project/app/Views/form_jugador.php`:
Add `enctype` to form tag:
```html
<form method="POST" action="/insertarJugador" enctype="multipart/form-data">
```
Add file input before submit button:
```html
<label>Foto: <input type="file" name="foto"></label><br>
```

- [ ] **Step 4: Run test to verify it passes**

Run: `cd project && php vendor/bin/phpunit tests/unit/MainTest.php --filter testPlayerFormHasFileInput`
Expected: PASS

- [ ] **Step 5: Commit**

```bash
git add project/app/Views/form_jugador.php
git commit -m "feat: add file input and enctype to player form for photo upload"
```

---

### Task 5: Handle Photo Upload in Main::insertarJugador

**Files:**
- Modify: `project/app/Controllers/Main.php`

- [ ] **Step 1: Write failing test for photo upload**

Add to `project/tests/unit/MainTest.php`:
```php
public function testPhotoUploadSavesRandomName()
{
    $this->withSession(['logged_in' => true]);
    // Create test file
    $testFilePath = WRITEPATH . 'test_upload.jpg';
    file_put_contents($testFilePath, 'test image content');
    
    $result = $this->post('/insertarJugador', [
        'nom' => 'Test',
        'cognoms' => 'User',
        'demarcacio' => 'Forward',
        'codiE' => 1,
        'foto' => new \CodeIgniter\HTTP\Files\UploadedFile(
            $testFilePath,
            'test.jpg',
            'image/jpeg',
            filesize($testFilePath),
            0,
            true
        )
    ]);
    
    // Check file exists in writable/uploads
    $files = glob(WRITEPATH . 'uploads/*.jpg');
    $this->assertNotEmpty($files);
    
    // Cleanup
    unlink($testFilePath);
    foreach ($files as $file) unlink($file);
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `cd project && php vendor/bin/phpunit tests/unit/MainTest.php --filter testPhotoUploadSavesRandomName`
Expected: FAIL (no upload handling)

- [ ] **Step 3: Update insertarJugador method**

Modify `project/app/Controllers/Main.php`:
Update validation rules to add foto:
```php
$rules = [
    "nom" => "required|min_length[1]|max_length[20]",
    "cognoms" => "required|min_length[1]|max_length[30]",
    "demarcacio" => "required|min_length[1]|max_length[20]",
    "codiE" => "required|integer",
    "foto" => "uploaded[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]|max_size[foto,2048]"
];
```

Update POST handling to process upload:
```php
if ($this->request->is("post")) {
    $rules = [
        "nom" => "required|min_length[1]|max_length[20]",
        "cognoms" => "required|min_length[1]|max_length[30]",
        "demarcacio" => "required|min_length[1]|max_length[20]",
        "codiE" => "required|integer",
        "foto" => "uploaded[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]|max_size[foto,2048]"
    ];

    if (!$this->validate($rules)) {
        $equips = $this->equipModel->obtenirTotsElsEquips();
        return view("form_jugador", [
            "validation" => $this->validator,
            "equips" => $equips,
        ]);
    }

    $dades = [
        "nom" => $this->request->getPost("nom"),
        "cognoms" => $this->request->getPost("cognoms"),
        "demarcacio" => $this->request->getPost("demarcacio"),
        "codiE" => $this->request->getPost("codiE"),
    ];

    // Handle photo upload
    $foto = $this->request->getFile('foto');
    if ($foto->isValid() && !$foto->hasMoved()) {
        $nomFoto = uniqid() . '.' . $foto->getExtension();
        $foto->move(WRITEPATH . 'uploads', $nomFoto);
        $dades['foto'] = $nomFoto;
    }

    try {
        $this->jugadorModel->inserirJugador($dades);
        return redirect()
            ->to("/mostrarJugadors")
            ->with("missatge", "Jugador inserit correctament");
    } catch (\Exception $e) {
        $equips = $this->equipModel->obtenirTotsElsEquips();
        return view("form_jugador", [
            "error" => $e->getMessage(),
            "equips" => $equips,
        ]);
    }
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `cd project && php vendor/bin/phpunit tests/unit/MainTest.php --filter testPhotoUploadSavesRandomName`
Expected: PASS

- [ ] **Step 5: Commit**

```bash
git add project/app/Controllers/Main.php
git commit -m "feat: handle photo upload in insertarJugador with validation and random name"
```

---

### Task 6: Add Photo Display Method to Main Controller

**Files:**
- Modify: `project/app/Controllers/Main.php`

- [ ] **Step 1: Write failing test for mostrarFoto method**

Add to `project/tests/unit/MainTest.php`:
```php
public function testMostrarFotoReturnsFile()
{
    $this->withSession(['logged_in' => true]);
    // Create test file
    $testFile = WRITEPATH . 'uploads/test.jpg';
    file_put_contents($testFile, 'test image content');
    
    $result = $this->get('/mostrarFoto/test.jpg');
    $result->assertStatus(200);
    $result->assertHeader('Content-Type', 'image/jpeg');
    
    unlink($testFile);
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `cd project && php vendor/bin/phpunit tests/unit/MainTest.php --filter testMostrarFotoReturnsFile`
Expected: FAIL (method not found)

- [ ] **Step 3: Add mostrarFoto method to Main.php**

Add to `project/app/Controllers/Main.php`:
```php
public function mostrarFoto($nomFixer)
{
    $path = WRITEPATH . 'uploads/' . $nomFixer;
    if (!file_exists($path)) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
    return $this->response->download($path, null)->inline();
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `cd project && php vendor/bin/phpunit tests/unit/MainTest.php --filter testMostrarFotoReturnsFile`
Expected: PASS

- [ ] **Step 5: Commit**

```bash
git add project/app/Controllers/Main.php
git commit -m "feat: add mostrarFoto method to display uploaded photos"
```

---

### Task 7: Display Photos in Player List

**Files:**
- Modify: `project/app/Views/llistat_jugadors.php`

- [ ] **Step 1: Write failing test for photo display**

Add to `project/tests/unit/MainTest.php`:
```php
public function testPlayerListShowsPhotos()
{
    $this->withSession(['logged_in' => true]);
    $result = $this->get('/mostrarJugadors');
    $result->assertSee('/mostrarFoto/');
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `cd project && php vendor/bin/phpunit tests/unit/MainTest.php --filter testPlayerListShowsPhotos`
Expected: FAIL (no img tag)

- [ ] **Step 3: Update llistat_jugadors.php**

Modify `project/app/Views/llistat_jugadors.php`:
Add inside player loop after other player details:
```php
<?php if (!empty($jugador['foto'])): ?>
    <img src="/mostrarFoto/<?= $jugador['foto'] ?>" width="100" alt="Foto de <?= $jugador['nom'] ?>">
<?php endif; ?>
```

- [ ] **Step 4: Run test to verify it passes**

Run: `cd project && php vendor/bin/phpunit tests/unit/MainTest.php --filter testPlayerListShowsPhotos`
Expected: PASS

- [ ] **Step 5: Commit**

```bash
git add project/app/Views/llistat_jugadors.php
git commit -m "feat: display player photos in jugadors list"
```

---

## Self-Review

1. **Spec Coverage:**
   - Login d'usuari: Covered in Task 1 (Auth controller), Task 2 (Auth filter)
   - Upload foto: Covered in Task 3 (Model), Task 4 (Form), Task 5 (Upload handling), Task 6 (Display method), Task 7 (List display)
   - All TASK.md requirements are addressed.

2. **Placeholder Scan:**
   - No TBD/TODO placeholders found
   - All steps include actual code, commands, expected output
   - No vague steps like "add appropriate error handling"

3. **Type Consistency:**
   - All method names match between tasks (e.g., `mostrarFoto` in Task 6 and Task 7)
   - File paths consistent across tasks
   - Form field names (`foto`) consistent between form, controller, model
