# DAW2 - Desenvolupament web en entorn servidor

## Activitat 3.4. CRUD en Laravel

Fes una aplicació CRUD en Laravel que permeti treballar amb una base de dades anomenada BBDDLaravel, que contingui la taula cotxes(id, marca, model, cilindrada, potencia).

* **id**: clau primària i autonumèric
* **marca**: tipus varchar 100
* **model**: tipus varchar 100
* **cilindrada**: tipus numèric
* **potencia**: tipus numèric

Cal utilitzar la eina composer per a crear el projecte.
Cal utilitzar la eina php artisan per a crear el model i el controlador.

Les funcions mínimes què ha de tenir l'aplicació, són:
* Mostrar Cotxes
* Inserir Cotxes
* Eliminar Cotxes

**Observacions:**
* Es recomana utilitzar Migrations
* Es recomana fer les rutes a ma (i no utiitzar el Resource)
* No cal implementar la modificació (update) dels cotxes
* Pots mirar el següent vídeo on es veu un exemple equivalent: https://drive.google.com/file/d/1fr0xB9q69OiGnelXzi7SIEKUEP2YjOK/view?usp=sharing

---

### Manual ajuda:

#### 1. Per a crear el projecte Laravel
```bash
composer create-project laravel/laravel AppCotxes

```

composer és una eina que permet gestionar les dependències de PHP. Si no la tens instal·lada te la pots descarregar:

* Per a Windows: https://getcomposer.org/download/
* Per a Linux: `sudo apt install composer`

#### 2. Editar el fitxer .env per a configurar les variables d'entorn

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=BBDDLaravel
DB_USERNAME=root
DB_PASSWORD=root

```

Posa bé les teves dades d'usuari i password, aquestes només estan a mode d'exemple.

#### 3. Per a crear el model podem executar

```bash
php artisan make:model Cotxe

```

#### 4. Per a crear la migració

```bash
php artisan make:migration create_cotxes_table

```

#### 5. Edita el fitxer de la migració `database/migrations/xxxx_create_cotxes_table.php`

```php
Schema::create('cotxes', function (Blueprint $table) {
    $table->id();
    $table->string('marca', 100);
    $table->string('model', 100);
    $table->integer('cilindrada');
    $table->integer('potencia');
    $table->timestamps();
});

```

#### 6. Per a executar la migració (automàticament crea la taula a la base de dades)

```bash
php artisan migrate

```

#### 7. Edita el model i afegir la línia

```php
protected $fillable = ['marca', 'model', 'cilindrada', 'potencia'];

```

#### 8. Crea el controlador, ho pots fer de 2 maneres:

* **Crear el controlador bàsic**
```bash
php artisan make:controller CotxeController

```


Has d'afegir a ma cada ruta (així tindràs més control).
* **Crear el controlador amb els mètodes habituals d'un CRUD**
```bash
php artisan make:controller CotxeController --resource

```


Incorpora els mètodes: index, create, store, show, edit, update, destroy. Pots esborrar els mètodes que no vulguis implementar.

#### 9. Definir les rutes -> editar el fitxer `routes/web.php`

```php
use App\Http\Controllers\CotxeController;

Route::get('/cotxes', [CotxeController::class, 'index'])->name('cotxes.index');
Route::get('/cotxes/create', [CotxeController::class, 'create'])->name('cotxes.create');
Route::post('/cotxes', [CotxeController::class, 'store'])->name('cotxes.store');
Route::get('/cotxes/{cotxe}', [CotxeController::class, 'show'])->name('cotxes.show');
Route::get('/cotxes/{cotxe}/edit', [CotxeController::class, 'edit'])->name('cotxes.edit');
Route::put('/cotxes/{cotxe}', [CotxeController::class, 'update'])->name('cotxes.update');
Route::delete('/cotxes/{cotxe}', [CotxeController::class, 'destroy'])->name('cotxes.destroy');

```

* Només cal que posis les rutes que t'interessin.
* Per a cada ruta, també hem definit un nom.

#### 10. Crear les vistes

* Dins de la carpeta `resources/views`, crea la carpeta `cotxes`.
* Dins de la carpeta `resources/views/cotxes` crea els fitxers de les vistes:
* `index.blade.php`
* `create.blade.php`


* En Laravel totes les vistes s'han d'anomenar `xxxxx.blade.php`.
* Per a cridar les vistes només caldrà posar el seu nom `xxxxx` (sense blade.php).

#### 11. Per a validar els formularis, pots fer:

```php
$request->validate([
    'marca' => 'required',
    'model' => 'required',
    'cilindrada' => 'required|integer',
    'potencia' => 'required|integer',
]);

```
