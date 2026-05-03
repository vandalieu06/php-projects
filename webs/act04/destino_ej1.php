<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Destino Ejercicio 1</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.fuchsia.min.css">
</head>

<body>
  <main class="container">
    <h1>Exercici 1 - Variables Recibidas por GET</h1>
    <?php

    if (isset($_GET['nombre_usuario']) && isset($_GET['edad'])) {
      $nombre_recibido = htmlspecialchars($_GET['nombre_usuario']);
      $edad_recibida = htmlspecialchars($_GET['edad']);

      echo "<p><strong>¡Variables recibidas con éxito!</strong></p>";
      echo "<ul>";
      echo "<li>Nombre de Usuario: <b>{$nombre_recibido}</b></li>";
      echo "<li>Edad: <b>{$edad_recibida}</b></li>";
      echo "</ul>";
    } else {
      echo "<p style='color: red;'>Error: No se han recibido las variables 'nombre_usuario' y 'edad'.</p>";
    }
    ?>
    <p><a href="index.php">Volver al Ejercicio 1</a></p>
  </main>
</body>

</html>