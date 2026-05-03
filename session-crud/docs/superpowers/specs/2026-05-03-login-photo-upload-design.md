# Login and Photo Upload Design

## Context

CodeIgniter 4 project with CRUD operations for teams (`Equip`) and players (`Jugador`). Previous task completed all basic CRUD with form validation, models, and raw queries. The `Jugador` table already has a `foto` varchar(50) column defined in `init.sql`.

## Objectives

1. **Login System**: User validation with `viladoms` / `JVjv2026`, using `password_hash()` and `password_verify()`, session creation, and logout functionality.
2. **Photo Upload**: Add file upload to player form, save with random name preserving extension to `writable/uploads/`, and display photos in player list.

## Design Section 1: Login System

### Auth Controller
New `Auth.php` controller (`app/Controllers/Auth.php`):
- `login()` method: GET shows login form, POST validates credentials
- Password handling: compute `$hashCalculat = password_hash("JVjv2026", PASSWORD_DEFAULT)`, verify with `password_verify($passIntroduit, $hashCalculat)`
- Success: set `session()->set('logged_in', true)`, redirect to `/`
- Failure: redirect to login with error message
- `logout()`: `session()->destroy()`, redirect to login

### Routes
Add to `app/Config/Routes.php`:
- `$routes->get('/login', 'Auth::login')`
- `$routes->post('/login', 'Auth::login')`
- `$routes->get('/logout', 'Auth::logout')`

### Auth Filter
Create `app/Filters/AuthFilter.php`:
- Checks if `session('logged_in')` is set
- If not authenticated, redirects to `/login`
- Applied to all routes except `/login` and `/logout`

Register in `app/Config/Filters.php` and apply via `$routes->filter('auth')` on all routes.

### Login View
Create `app/Views/auth/login.php` with username/password form.

## Design Section 2: Photo Upload

### Database
`foto` column already exists in `Jugador` table (varchar 50) per `init.sql`.

### JugadorModel
Add `"foto"` to `$allowedFields` array in `app/Models/JugadorModel.php`.

### Player Form
Update `app/Views/form_jugador.php`:
- Add `enctype="multipart/form-data"` to form
- Add `<input type="file" name="foto">` field

### Validation
Add to rules in `Main::insertarJugador()`:
```
"foto" => "uploaded[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]|max_size[foto,2048]"
```

### Controller Upload Handling
In `Main::insertarJugador()`:
- Get file: `$foto = $this->request->getFile('foto')`
- Generate random name: `$nomFoto = uniqid() . '.' . $foto->getExtension()`
- Move file: `$foto->move(WRITEPATH . 'uploads', $nomFoto)`
- Save `$nomFoto` to `foto` field in database insert array

### Uploads Directory
Use existing `writable/uploads/` directory (already exists with index.html).

## Design Section 3: Photo Display

### Controller Method
Add `mostrarFoto($nomFixer)` to `Main.php`:
```php
return $this->response->download(WRITEPATH . 'uploads/' . $nomFixer, null)->inline();
```

### Player List View
Update `app/Views/llistat_jugadors.php`:
- For each player, if `foto` field is not empty, display:
  `<img src="/mostrarFoto/<?= $jugador['foto'] ?>" width="100">`

### Route
Add to `app/Config/Routes.php`:
- `$routes->get('/mostrarFoto/(:any)', 'Main::mostrarFoto/$1')`
