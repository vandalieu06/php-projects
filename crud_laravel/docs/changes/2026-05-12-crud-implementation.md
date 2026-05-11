# CRUD Laravel — Implementació amb estil Ollama

## Resum

Implementació completa d'un CRUD en Laravel per a la gestió de cotxes (taula `cotxes`), amb el disseny basat en el sistema de tokens d'Ollama (DESIGN.md).

## Fitxers modificats/creats

### Raíz del proyecto (`AppCotxes/`)

| Fitxer | Canvi |
|--------|-------|
| `vite.config.js` | Canviada font de `Instrument Sans` a `Nunito` |
| `resources/css/app.css` | Afegits tokens de disseny Ollama + classes component |
| `resources/views/layouts/app.blade.php` | **Creat** — layout base amb nav i footer |
| `resources/views/cotxes/index.blade.php` | **Creat** — llista de cotxes |
| `resources/views/cotxes/create.blade.php` | **Creat** — formulari de creació |
| `app/Http/Controllers/CotxeController.php` | Implementats mètodes `index()`, `create()`, `store()`, `destroy()` |

## Detall per fase

### Fase 1 — CSS global (`resources/css/app.css`)

Sistema de tokens Tailwind v4 amb la paleta Ollama:

- **Colors**: `primary` (#000), `ink` (#000), `body` (#737373), `mute` (#a3a3a3), `canvas` (#fff), `surface-soft` (#fafafa), `hairline` (#e5e5e5), `destructive` (#dc2626), etc.
- **Fonts**: `font-display` (Nunito / SF Pro Rounded), `font-sans` (ui-sans-serif), `font-mono` (ui-monospace)
- **Tipografia**: `display-xl` (36px), `display-lg` (30px), `body-md` (16px), `button-md` (14px), etc.
- **Components CSS**:
  - `.btn-primary` — pill negre (#000) amb text blanc
  - `.btn-secondary` — pill blanc amb border `hairline-strong`
  - `.btn-danger` — pill vermell per a eliminar
  - `.input-pill` — input pill shape (40px, border `hairline`)
  - `.card` — container amb border `hairline` i `rounded-lg`
  - `.content-column` — columna centrada de 720px max-width
  - `.flash-message` — missatges flash estil Ollama

### Fase 2 — Layout base (`resources/views/layouts/app.blade.php`)

- Nav minimalista: 56px, fons blanc, border inferior `hairline`
- Main amb `content-column` (720px) i espaiat vertical `pt-8 pb-12`
- Footer: border `hairline` superior, text `caption-sm`, centrat
- Head amb `@fonts` (Nunito via Bunny CDN) i `@vite` per CSS/JS

### Fase 3 — Llista de cotxes (`resources/views/cotxes/index.blade.php`)

- Títol `display-lg` + botó "Nou cotxe" (`btn-primary`)
- Taula dins de `.card` amb border `hairline`
- Columnes: ID, Marca, Model, Cilindrada, Potència, Accions
- Botó "Eliminar" (`btn-danger`) amb confirmació JS
- Estat buit: text itàlica "No hi ha cotxes registrats."

### Fase 4 — Formulari de creació (`resources/views/cotxes/create.blade.php`)

- Títol `display-lg` "Nou Cotxe"
- 4 camps `input-pill` amb labels `body-sm-strong`
- Errors de validació en `text-destructive` (sense caixes)
- Botons "Guardar" (`btn-primary`) + "Cancel·lar" (`btn-secondary`)

### Fase 5 — Controller (`app/Http/Controllers/CotxeController.php`)

| Mètode | Descripció |
|--------|------------|
| `index()` | `Cotxe::all()` → vista `cotxes.index` |
| `create()` | Vista `cotxes.create` |
| `store(Request)` | Valida (required, string, integer), `Cotxe::create()`, redirect amb flash |
| `destroy($id)` | `Cotxe::findOrFail($id)->delete()`, redirect amb flash |

## Rutes definides (`routes/web.php`)

| Mètode | URI | Acció | Nom |
|--------|-----|-------|-----|
| GET | `/cotxes` | `index` | `cotxes.index` |
| GET | `/cotxes/create` | `create` | `cotxes.create` |
| POST | `/cotxes` | `store` | `cotxes.store` |
| DELETE | `/cotxes/{cotxe}` | `destroy` | `cotxes.destroy` |

## Per executar

```bash
# Instal·lar dependències npm (si no s'ha fet)
npm install

# Compilar assets
npm run build

# Servir l'aplicació (via Podman)
podman run --rm -it -v "$(pwd)/AppCotxes:/app" -w /app php:8.4-cli php artisan serve --host=0.0.0.0
```

Obrir `http://localhost:8000/cotxes`.
