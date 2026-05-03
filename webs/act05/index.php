<?php
function checkDNI(string $dni)
{
  $lletres_dni = "TRWAGMYFPDXBNJZSQVHLCKE";

  if (!preg_match('/^(\d{8})([A-Za-z])$/', $dni, $matches)) {
    return false;
  }

  $numero = (int) $matches[1];
  $lletra_introduida = strtoupper($matches[2]);
  $residu = $numero % 23;
  $lletra_correcta = $lletres_dni[$residu];

  return $lletra_introduida === $lletra_correcta;
}

if (isset($_POST["submit"])) {
  $campos = [
    "name",
    "lastname",
    "dni",
    "email",
    "password",
    "password-repeat",
    "select",
    "tel",
    "comment",
    "submit",
  ];
  $errores = [];
  $mostrar_missatge_correcte = false;

  foreach ($campos as $campo) {
    if (empty($_POST[$campo])) {
      $errores[] = "El campo de $campo no puede estar vacío.";
    }
  }

  if (!isset($_POST["checkbox"])) {
    $errores[] = "Debes aceptar los términos y condiciones (checkbox).";
  }

  if (empty($errores)) {
    $dni = $_POST["dni"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_repeat = $_POST["password-repeat"];

    if (!checkDNI($dni)) {
      $errores[] = "El format o la lletra del DNI no és correcte.";
    }

    if ($password !== $password_repeat) {
      $errores[] = "Les dues contrasenyes introduïdes no coincideixen.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errores[] = "L'adreça de correu electrònic no és vàlida.";
    }
  }

  if (empty($errores)) {
    $mostrar_missatge_correcte = true;
  }
}
?>

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

    <?php if ($mostrar_missatge_correcte) {
      echo "<ul>";
      echo "<h1>DADES INTRODUIDES CORRECTAMENT</h1>";

      foreach ($_POST as $clau => $valor) {
        if (!in_array($clau, ["password", "password-repeat", "submit"])) {
          echo "<li>" .
            htmlspecialchars($clau) .
            ": " .
            htmlspecialchars($valor) .
            "</li>";
        }
      }
      echo "</ul>";
    } else {
      if (!empty($errores)) {
        echo "<h2>DADES INCORRECTES</h2>";
        echo "<ul>";

        foreach ($errores as $error) {
          echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
      }
    } ?>


    <h1>Formulario</h1>
    <form method="POST" action="">
      <input type="text" name="name" value="<?= $_POST["name"] ?? "" ?>">
      <input type="text" name="lastname" value="<?= $_POST["lastname"] ?? "" ?>"
      <input type="text" name="dni" value="<?= $_POST["dni"] ?? "" ?>">
      <input type="email" name="email" value="<?= $_POST["email"] ?? "" ?>">

      <br><hr><br>

      <label for="password">Contrasenya:</label>
      <input type="password" name="password" id="password" value=""><br><br>
      <label for="password-repeat">Repetir Contrasenya:</label>
      <input type="password" name="password-repeat" id="password-repeat" value=""><br><br>

      <label for="tel">Telèfon:</label>
      <input type="tel" name="tel" value="<?= $_POST["tel"] ?? "" ?>">

      <br><hr><br>

      <label for="select">Opció:</label>
      <select name="select" id="select">
          <option value="op1" <?= isset($_POST["select"]) &&
          $_POST["select"] === "op1"
            ? "selected"
            : "" ?> >Opció 1</option>

          <option value="op2" <?php if (
            isset($_POST["select"]) &&
            $_POST["select"] === "op2"
          ) {
            echo "selected";
          } ?>>Opció 2</option>
      </select><br><br>

      <label for="comment">Comentari:</label>
      <textarea name="comment" id="comment"><?php echo htmlspecialchars(
        $_POST["comment"] ?? "",
      ); ?></textarea>

      <input type="checkbox" name="checkbox" id="checkbox" <?php if (
        isset($_POST["checkbox"])
      ) {
        echo "checked";
      } ?>>
      <label for="checkbox">Accepto les condicions legals</label><br><br>

      <input type="submit" name="submit" value="Enviar Dades">
    </form>

  </main>

</body>
</html>
