<?php
function counterVisitsSimple()
{
  $filename = "comptador.txt";
  $current_count = (int) file_get_contents($filename);
  $new_count = $current_count + 1;
  file_put_contents($filename, $new_count);
  return $new_count;
}

function addComment()
{
  $name = $_POST["name"] ?? "";
  $lastname = $_POST["lastname"] ?? "";
  $email = $_POST["email"] ?? "";
  $comment = $_POST["comment"] ?? "";
  // Convertimos los saltos de linea de ["\n", "\r"] en strings para conservar los
  // saltos de lina en los comentarios
  $clear_comment = str_replace(["\n", "\r"], ["\\n", "\\r"], $comment);

  if (!isset($_FILES["image"])) {
    return;
  }

  $upload_dir = "images";
  $uploaded_file = "";
  $file_tmp_path = $_FILES["image"]["tmp_name"];
  $file_name = $_FILES["image"]["name"];
  $extension = pathinfo($file_name, PATHINFO_EXTENSION);
  $dest_path = "{$upload_dir}/{$email}.{$extension}";

  if (move_uploaded_file($file_tmp_path, $dest_path)) {
    $uploaded_file = $dest_path;
  }

  // PHP_EOL es una variable para añadir "\n" al final de las lineas
  $new_line =
    "{$name},{$lastname},{$email},{$uploaded_file},{$clear_comment}" . PHP_EOL;

  $filename = "dades.txt";
  $open_file = fopen($filename, "a");
  fwrite($open_file, $new_line);
  fclose($open_file);

  // Esta única línea reemplaza a tu bloque de fopen/fwrite/fclose
  // file_put_contents($filename, $new_line, FILE_APPEND);
}

function displayComments()
{
  $filename = "dades.txt";

  // Las variables que se pasan como segundo parametro al metodo file()
  // sirven para ignorar las lineas vacias y los "/n" al final de cada linea
  $comments_array = file(
    $filename,
    FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES,
  );

  foreach ($comments_array as $line) {
    // Se extrae el cotenido de cada linea a partir de las coma
    [$name, $lastname, $email, $image, $comment] = explode(",", $line, 5);

    // Transformamos los elementos ["\\r", "\\n"] en su forma normal con
    // los saltos de linea del usuario
    $clear_comment = str_replace(["\\n", "\\r"], ["\n", "\r"], trim($comment));
    echo "<article style='border: 1px solid #ccc; padding: 15px; margin-bottom: 10px;'>";

    $user = htmlspecialchars(trim($name) . " " . trim($lastname));
    echo "<h4>Comentario de: {$user} </h4>";

    if (!empty($image) && file_exists(trim($image))) {
      $image_url = htmlspecialchars(trim($image));
      echo "<p><img src='{$image_url}' alt='Imagen del comentario' style='max-width: 100px;'></p>";
    }
    $clear_email = htmlspecialchars(trim($email));
    echo "<p><strong>Email:</strong>{$clear_email}</p>";

    // nl2br sirve para convertir los saltos de linea en etiquetas <br>
    echo "<p>" . nl2br($clear_comment) . "</p>";
    echo "</article>";
  }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  addComment();
}
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Actividad 7 by Jhonny Claure</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
</head>
<body>
  <h1>ACTIVIDAD 7</h1>
  <p>Contador de Visitas: <span class="count"> <?= counterVisitsSimple() ?> </span> </p>
  <h2>Formulario - Añadir Comentario</h2>
  <form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Nombre" >
    <input type="text" name="lastname" placeholder="Apellidos" >
    <input type="email" name="email" placeholder="Email" >
    <input type="file" name="image">
    <textarea name="comment" placeholder="Comentario..." rows="5"></textarea>
    <button type="submit">Añadir</button>
  </form>
  <section>
    <h3>Comentarios</h3>
    <div class="comments">
      <?php displayComments(); ?>
    </div>
  </section>
</body>
</html>
