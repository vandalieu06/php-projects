<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
  <meta charset=" UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Destino Ejercicio 4</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.fuchsia.min.css">
</head>

<body>
  <main class="container">
    <h1>Exercici 4 - Resultado Final</h1>
    <?php
    $color_recibido = isset($_POST['color_preferido']) ? $_POST['color_preferido'] : null;
    $nombre_recibido = isset($_POST['nombre_usuario_ej4']) ? $_POST['nombre_usuario_ej4'] : null;

    if ($color_recibido && $nombre_recibido) {
      $color_limpio = htmlspecialchars($color_recibido);
      $nombre_limpio = htmlspecialchars($nombre_recibido);

      echo "<h3>¡Datos Recibidos y Combinados!</h3>";
      echo "<p style='font-size: 1.2em;'>El color preferido de <b>{$nombre_limpio}</b> es el <b>{$color_limpio}</b>.</p>";
    } else {
      echo "<p style='color: red;'>Error: Faltan datos (color o nombre) para mostrar la frase.</p>";
    }
    ?>
    <p><a href="index.php">Volver al Ejercicio 4</a></p>
  </main>
</body>

</html>