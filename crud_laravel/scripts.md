# Comandos

```bash
podman pull composer
podman  run --rm -it -v "$(pwd):/app" composer create-project laravel/laravel AppCotxes
podman run --rm -it -v "$(pwd)/AppCotxes:/app" -w /app php:8.4-cli php artisan make:model Cotxe
podman run --rm -it -v "$(pwd)/AppCotxes:/app" -w /app php:8.4-cli php artisan make:migration create_cotxes_table
podman run --rm -it -v "$(pwd)/AppCotxes:/app" -w /app php:8.4-cli php artisan migrate
podman run --rm -it -v "$(pwd)/AppCotxes:/app" -w /app php:8.4-cli php artisan make:controller CotxeController
podman run --rm -it -v "$(pwd)/AppCotxes:/app" -w /app php:8.4-cli php artisan make:controller CotxeController --resource

```
