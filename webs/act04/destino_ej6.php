<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
  <meta charset=" UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Destino Ejercicio 6</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.fuchsia.min.css">
  <style>
    .grid-ex6 {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-top: 20px;
    }

    .grid-ex6>div {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      word-wrap: break-word;
      /* Para comentarios largos */
    }
  </style>
</head>

<body>
  <main class="container">
    <h1>Exercici 6 - Datos Recibidos del Formulario</h1>
    <?php
    echo "<h3>Recolección de todas las variables enviadas:</h3>";
    echo "<div class='grid-ex6'>";

    $texto = isset($_POST['texto_ej6']) ? htmlspecialchars($_POST['texto_ej6']) : 'N/A';
    echo "<div><strong>1. Texto:</strong> {$texto}</div>";

    $opcion_radio = isset($_POST['opcion_radio']) ? htmlspecialchars($_POST['opcion_radio']) : 'No seleccionado';
    echo "<div><strong>2. Radio:</strong> {$opcion_radio}</div>";

    $opcion_checkbox = isset($_POST['opcion_checkbox']) ? 'Sí (Aceptado)' : 'No (No marcado)';
    echo "<div><strong>3. Checkbox:</strong> {$opcion_checkbox}</div>";

    $password = isset($_POST['password_ej6']) && !empty($_POST['password_ej6']) ? '***' . substr(htmlspecialchars($_POST['password_ej6']), -3) : 'No enviado/Vacío';
    echo "<div><strong>4. Password:</strong> {$password}</div>";

    $color = isset($_POST['color_ej6']) ? htmlspecialchars($_POST['color_ej6']) : 'N/A';
    echo "<div><strong>5. Color:</strong> <span style='background-color:{$color}; padding: 3px; border: 1px solid #000;'>&nbsp;&nbsp;&nbsp;</span> ({$color})</div>";

    $email = isset($_POST['email_ej6']) ? htmlspecialchars($_POST['email_ej6']) : 'N/A';
    echo "<div><strong>6. Email:</strong> {$email}</div>";

    $fecha = isset($_POST['fecha_ej6']) ? htmlspecialchars($_POST['fecha_ej6']) : 'N/A';
    echo "<div><strong>7. Fecha:</strong> {$fecha}</div>";

    $telefono = isset($_POST['tel_ej6']) ? htmlspecialchars($_POST['tel_ej6']) : 'N/A';
    echo "<div><strong>8. Teléfono:</strong> {$telefono}</div>";

    $numero = isset($_POST['numero_ej6']) ? htmlspecialchars($_POST['numero_ej6']) : 'N/A';
    echo "<div><strong>9. Número:</strong> {$numero}</div>";

    $comentarios = isset($_POST['comentarios_ej6']) ? nl2br(htmlspecialchars($_POST['comentarios_ej6'])) : 'N/A';
    echo "<div style='grid-column: span 3;'><strong>10. Textarea/Comentarios:</strong> <br>{$comentarios}</div>";

    $seleccion = isset($_POST['opcion_select']) ? htmlspecialchars($_POST['opcion_select']) : 'N/A';
    echo "<div><strong>11. Select:</strong> {$seleccion}</div>";

    echo "</div>";
    ?>
    <p style='margin-top: 20px;'><a href="index.php">Volver al Formulario</a></p>
  </main>
</body>

</html>