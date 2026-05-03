<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ACTIVIDAD 4 - Paso de Variables y Formularios</title>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.fuchsia.min.css">
  <style>
    .grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
  </style>
</head>

<body>
  <main class="container">
    <h1>Actividad 4: Paso de Variables y Formularios</h1>
    <hr>

    <div id="act01" class="act01" style="margin-top: 40px;">
      <h2>Exercici 1 - Paso de Variables por GET</h2>
      <?php
      $nombre_ej1 = "Juan";
      $edad_ej1 = 30;
      ?>
      <p>
        <a href="destino_ej1.php?nombre_usuario=<?php echo $nombre_ej1; ?>&edad=<?php echo $edad_ej1; ?>">
          Ver Variables (GET)
        </a>
      </p>
    </div>
    <hr>

    <div id="act02" class="act02" style="margin-top: 40px;">
      <h2>Exercici 2 - Formulario POST y Autoprocesamiento</h2>
      <?php if (isset($_POST["enviar_ej2"])) {
        $campo1 = isset($_POST["campo1"])
          ? htmlspecialchars($_POST["campo1"])
          : "Valor no enviado";
        $campo2 = isset($_POST["campo2"])
          ? htmlspecialchars($_POST["campo2"])
          : "Valor no enviado";

        echo "<h3>Datos Recibidos:</h3>";
        echo "<ul><li>Campo 1: <b>{$campo1}</b></li><li>Campo 2: <b>{$campo2}</b></li></ul>";
        echo "<p><a href='index.php'>Volver al formulario</a></p>";
      } else {
         ?>
        <form method="POST" action="index.php#act02">
          <label for="campo1">Campo de Texto 1:</label><input type="text" id="campo1" name="campo1">
          <label for="campo2">Campo de Texto 2:</label><input type="text" id="campo2" name="campo2">
          <button type="submit" name="enviar_ej2">Enviar Datos (POST)</button>
        </form>
      <?php
      } ?>
    </div>
    <hr>

    <div id="act03" class="act03" style="margin-top: 40px;">
      <h2>Exercici 3 - Recoger y Mostrar todas las Variables (GET y POST)</h2>
      <?php
      function mostrar_variables_recibidas(array $variables, string $metodo)
      {
        if (count($variables) > 0) {
          echo "<h3>Variables recibidas por {$metodo}:</h3><ul>";
          foreach ($variables as $nombre => $valor) {
            $nombre_limpio = htmlspecialchars($nombre);
            $valor_limpio = htmlspecialchars(print_r($valor, true));
            echo "<li><strong>{$nombre_limpio}</strong>: {$valor_limpio}</li>";
          }
          echo "</ul>";
        } else {
          echo "<p>No se han recibido variables por {$metodo}.</p>";
        }
      }
      mostrar_variables_recibidas($_GET, "GET");
      mostrar_variables_recibidas($_POST, "POST");
      ?>
    </div>
    <hr>

    <div id="act04" class="act04" style="margin-top: 40px;">
      <h2>Exercici 4 - Formularios Encadenados con Campo Hidden</h2>
      <?php
      $color_recibido = isset($_POST["color_preferido"])
        ? $_POST["color_preferido"]
        : "";

      if (!$color_recibido) { ?>
        <h3>Paso 1: Introduce tu Color Preferido</h3>
        <form method="POST" action="index.php#act04">
          <label for="color_preferido">Color Preferido:</label>
          <input type="text" id="color_preferido" name="color_preferido" required placeholder="Ej: azul">
          <button type="submit" name="enviar_color">Siguiente</button>
        </form>
      <?php } else { ?>
        <h3>Paso 2: Introduce tu Nombre</h3>
        <form method="POST" action="destino_ej4.php">
          <input type="hidden" name="color_preferido" value="<?php echo $color_recibido; ?>">

          <label for="nombre_usuario_ej4">Tu Nombre:</label>
          <input type="text" id="nombre_usuario_ej4" name="nombre_usuario_ej4" placeholder="Ej: Juan" required>
          <button type="submit" name="enviar_nombre">Mostrar Frase en página destino</button>
        </form>
      <?php }
      ?>
    </div>
    <hr>

    <div id="act05" class="act05" style="margin-top: 40px;">
      <h2>Exercici 5 - Dos Formularios en una Sola Página</h2>
      <?php if (isset($_POST["boton_f1"])) {
        $dato1 = isset($_POST["dato_f1_1"])
          ? htmlspecialchars($_POST["dato_f1_1"])
          : "N/A";
        $dato2 = isset($_POST["dato_f1_2"])
          ? htmlspecialchars($_POST["dato_f1_2"])
          : "N/A";
        echo "<h3>Datos Recibidos del Formulario 1:</h3><p>Se ha clicado el Botón del Formulario 1.</p><ul><li>Dato 1: <b>{$dato1}</b></li><li>Dato 2: <b>{$dato2}</b></li></ul><p><a href='index.php#act05'>Volver</a></p>";
      } elseif (isset($_POST["boton_f2"])) {
        $dato3 = isset($_POST["dato_f2_1"])
          ? htmlspecialchars($_POST["dato_f2_1"])
          : "N/A";
        echo "<h3>Datos Recibidos del Formulario 2:</h3><p>Se ha clicado el Botón del Formulario 2.</p><ul><li>Dato 3: <b>{$dato3}</b></li></ul><p><a href='index.php#act05'>Volver</a></p>";
      } else {
         ?>
        <div class="grid">
          <div>
            <h4>Formulario 1</h4>
            <form method="POST" action="index.php#act05">
              <label for="dato_f1_1">Dato A:</label><input type="text" id="dato_f1_1" name="dato_f1_1" required>
              <label for="dato_f1_2">Dato B:</label><input type="text" id="dato_f1_2" name="dato_f1_2">
              <button type="submit" name="boton_f1">Enviar Formulario 1</button>
            </form>
          </div>
          <div>
            <h4>Formulario 2</h4>
            <form method="POST" action="index.php#act05">
              <label for="dato_f2_1">Dato C:</label><input type="number" id="dato_f2_1" name="dato_f2_1" required>
              <button type="submit" name="boton_f2">Enviar Formulario 2</button>
            </form>
          </div>
        </div>
      <?php
      } ?>
    </div>
    <hr>

    <div id="act06" class="act06" style="margin-top: 40px;">
      <h2>Exercici 6 - Formulario Completo y Recolección</h2>
      <form method="POST" action="destino_ej6.php">
        <div class="grid">
          <div>
            <label for="texto_ej6">Text (Required, Placeholder):</label><input type="text" id="texto_ej6" name="texto_ej6" required placeholder="Introduce un texto">
            <label for="password_ej6">Password:</label><input type="password" id="password_ej6" name="password_ej6">
            <label for="email_ej6">Email:</label><input type="email" id="email_ej6" name="email_ej6">
            <label for="numero_ej6">Number:</label><input type="number" id="numero_ej6" name="numero_ej6">
            <label for="color_ej6">Color:</label><input type="color" id="color_ej6" name="color_ej6" value="#ff0000">
          </div>
          <div>
            <label for="fecha_ej6">Date:</label><input type="date" id="fecha_ej6" name="fecha_ej6">
            <label for="tel_ej6">Tel:</label><input type="tel" id="tel_ej6" name="tel_ej6">
            <label for="opcion_select">Select - Option:</label>
            <select id="opcion_select" name="opcion_select">
              <option value="opcion1">Opción Uno</option>
              <option value="opcion2" selected>Opción Dos</option>
            </select>
            <label>Radio:</label>
            <fieldset style="border: none; padding: 0;">
              <label><input type="radio" name="opcion_radio" value="radioA" checked> Opción A</label>
              <label><input type="radio" name="opcion_radio" value="radioB"> Opción B</label>
            </fieldset>
            <label>Checkbox:</label>
            <fieldset style="border: none; padding: 0;">
              <label><input type="checkbox" name="opcion_checkbox"> Acepto Términos</label>
            </fieldset>
          </div>
        </div>
        <label for="comentarios_ej6">Textarea:</label><textarea id="comentarios_ej6" name="comentarios_ej6" rows="4"></textarea>
        <button type="submit" name="enviar_ej6">Submit</button>
      </form>
    </div>
    <hr>

  </main>

</body>

</html>
