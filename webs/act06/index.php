<?php
function getPostValue($key)
{
  return htmlspecialchars($_POST[$key] ?? "");
} ?>

<form method="POST" enctype="multipart/form-data">
  <h2>Formulario de Registro y Subida de Imagen</h2>
  <div>
    <label for="name">Nombre</label>
    <input type="text" name="name" value="<?= getPostValue("name") ?>">
  </div>
  <div>
    <label for="lastname">Apellido</label>
    <input type="text" name="lastname" value="<?= getPostValue("lastname") ?>">
  </div>
  <div>
    <label for="dni">DNI</label>
    <input type="text" name="dni" value="<?= getPostValue("dni") ?>">
  </div>
  <div>
    <label for="email">Correo electrónico</label>
    <input type="email" name="email"  value="<?= getPostValue("email") ?>">
  </div>
  <div>
    <label for="fitxer">Imagen (JPG, GIF, PNG)</label>
        <input type="file" name="fitxer" id="fitxer" accept=".jpg, .jpeg, .png, .gif" required>
  </div>
  <input type="submit" value="Enviar y Subir Imagen">
</form>

<?php
$upload_dir = __DIR__ . "/img/";
$max_size = 2 * 1024 * 1024;

$validator =
  isset($_FILES["fitxer"]) && is_uploaded_file($_FILES["fitxer"]["tmp_name"]);

if ($validator) {
  $file = $_FILES["fitxer"];
  $dni = $_POST["dni"] ?? "NODNI";

  echo "<h3>Resultado de la Subida:</h3>";

  if ($file["size"] > $max_size) {
    echo "<p style='color: red;'>Error: El archivo es demasiado grande. El tamaño máximo permitido es 2MB.</p>";
    return;
  }

  $allowed_types = ["image/jpeg", "image/png", "image/gif"];
  $file_type = $file["type"];

  if (!in_array($file_type, $allowed_types)) {
    echo "<p style='color: red;'>Error: Solo se permiten archivos de imagen (JPG, PNG, GIF). El tipo subido es: {$file_type}</p>";
    return;
  }

  $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
  $new_filename = "{$dni}.{$extension}";
  $destination = "{$upload_dir}.{$new_filename}";

  if (move_uploaded_file($file["tmp_name"], $destination)) {
    echo "<p style='color: green;'>¡Éxito! La imagen se ha subido correctamente.</p>";
    echo "<p>Nombre del archivo en el servidor: {$new_filename}</p>";
    echo "<p>Ruta completa: `{$destination}`</p>";

    $relative_path = "./img/{$new_filename}";
    echo "<img src='{$relative_path}' style='max-width: 400px; height: auto; border: 1px solid #ccc;' alt='Imagen subida'>";
  } else {
    echo "<p style='color: red;'>Error: Se ha producido un error al intentar mover el archivo.</p>";
  }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
  echo "<h3>Resultado de la Subida:</h3>";
  echo "<p>No se ha recibido ningún archivo o la subida ha fallado.</p>";
}


?>
