<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ACTIVIDAD 4 - Paso de Variables y Formularios</title>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.fuchsia.min.css">
</head>
<body>
  <main class="container">
    <h1>Actividad 5</h1>
    <?php
    $num1 = 1;
    $num2 = "1";
    $text1 = "Jhonny Vicmar Claure Vedia";
    $email = "claurejhony188@gmail.com";
    echo is_integer($num2) ? "Es un numero" : "no es un numero";
    echo "<br>";
    echo strlen($text1) < 20
      ? "El largo es correcto"
      : "El largo es incorrecto";
    echo "<br>";
    echo filter_var($email, FILTER_VALIDATE_EMAIL)
      ? "El email es correcto"
      : "El email es incorrecto";
    ?>

    <form method="POST" style="width: 400px;">
      <input type="text" name="data">
      <input type="submit" name="btn" value="Enviar datos">
    </form>

    <?php if (isset($_POST["btn"])) {
      $clear_data = strip_tags($_POST["data"]);
      echo "Texto filtrado: {$clear_data}";
      echo "<br>";
      echo htmlspecialchars($_POST["data"]);
    } ?>
  </main>

</body>
</html>
