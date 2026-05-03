<?php
include "./connection.php";

function getAllNotices()
{
  global $connection;
  $sql =
    "SELECT n.*, s.seccio FROM noticia n JOIN seccio s ON n.codiSeccio = s.codiSeccio ORDER BY n.codiNoticia";
  $result = mysqli_query($connection, $sql);

  $noticias = [];

  if (!$result) {
    echo "Error: " . mysqli_error($connection);
    return $noticias;
  }

  while ($row = mysqli_fetch_assoc($result)) {
    $noticias[] = $row;
  }

  return $noticias;
}

function getAllNoticesByType($seccio)
{
  global $connection;
  $sql =
    "SELECT n.*, s.seccio FROM noticia n JOIN seccio s ON n.codiSeccio = s.codiSeccio WHERE n.codiSeccio = ? ORDER BY n.codiNoticia";
  $stmt = mysqli_prepare($connection, $sql);
  if (!$stmt) {
    return [];
  }
  mysqli_stmt_bind_param($stmt, "s", $seccio);
  mysqli_stmt_execute($stmt);

  $res = mysqli_stmt_get_result($stmt);
  $noticias = [];
  while ($row = mysqli_fetch_assoc($res)) {
    $noticias[] = $row;
  }

  mysqli_stmt_close($stmt);
  return $noticias;
}

function getAllNoticesByName($title)
{
  global $connection;
  $sql = "
    SELECT n.*, s.seccio
    FROM noticia n
    JOIN seccio s ON n.codiSeccio = s.codiSeccio
    WHERE LOWER(n.titol) LIKE ?
    ORDER BY n.codiNoticia";
  $stmt = mysqli_prepare($connection, $sql);
  if (!$stmt) {
    return [];
  }
  $newTitle = "%" . $title . "%";
  mysqli_stmt_bind_param($stmt, "s", $newTitle);
  mysqli_stmt_execute($stmt);

  $res = mysqli_stmt_get_result($stmt);
  $noticias = [];
  while ($row = mysqli_fetch_assoc($res)) {
    $noticias[] = $row;
  }

  mysqli_stmt_close($stmt);
  return $noticias;
}

function getNoticeByID($id)
{
  global $connection;
  $sql =
    "SELECT n.*, s.seccio FROM noticia n JOIN seccio s ON n.codiSeccio = s.codiSeccio WHERE n.codiNoticia = ? ORDER BY n.codiNoticia";
  $stmt = mysqli_prepare($connection, $sql);
  if (!$stmt) {
    return [];
  }
  mysqli_stmt_bind_param($stmt, "s", $id);
  mysqli_stmt_execute($stmt);

  $res = mysqli_stmt_get_result($stmt);
  $noticias = [];
  while ($row = mysqli_fetch_assoc($res)) {
    $noticias[] = $row;
  }

  mysqli_stmt_close($stmt);
  return $noticias[0];
}

function getAllSeccions()
{
  global $connection;
  $sql = "SELECT * FROM seccio";
  $result = mysqli_query($connection, $sql);
  $seccions = [];
  if (!$result) {
    echo "Error: " . mysqli_error($connection);
    return [];
  }
  while ($row = mysqli_fetch_assoc($result)) {
    $seccions[] = $row;
  }
  return $seccions;
}

function addNewNotice($titol, $cos, $autor, $codiSeccio, $data, $imatge, $tipus)
{
  global $connection;
  $sql =
    "INSERT INTO noticia (titol, cos, autor, codiSeccio, data, imatge, tipus) VALUES (?, ?, ?, ?, ?, ?, ?)";

  $stmt = mysqli_prepare($connection, $sql);
  if (!$stmt) {
    return [];
  }
  $null = null;
  // Vinculamos (asegúrate que el orden coincida con los '?' de arriba)
  mysqli_stmt_bind_param(
    $stmt,
    "sssisbs",
    $titol,
    $cos,
    $autor,
    $codiSeccio,
    $data,
    $null,
    $tipus,
  );

  mysqli_stmt_send_long_data($stmt, 5, $imatge);
  $result = mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  return $result;
}
function updateNewNotice($id, $titol, $cos, $imatge)
{
  global $connection;

  if ($imatge !== null && $imatge !== "") {
    $sql =
      "UPDATE noticia SET titol = ?, cos = ?, imatge = ? WHERE codiNoticia = ?";
    $stmt = mysqli_prepare($connection, $sql);
    if (!$stmt) {
      return false;
    }

    $null = null;
    mysqli_stmt_bind_param($stmt, "ssbi", $titol, $cos, $null, $id);
    mysqli_stmt_send_long_data($stmt, 2, $imatge); // Índice 2 es el tercer '?'
  } else {
    $sql = "UPDATE noticia SET titol = ?, cos = ? WHERE codiNoticia = ?";
    $stmt = mysqli_prepare($connection, $sql);
    if (!$stmt) {
      return false;
    }

    mysqli_stmt_bind_param($stmt, "ssi", $titol, $cos, $id);
  }

  $success = mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  return $success;
}

function deleteNoticeById($id)
{
  global $connection;

  $sql = "DELETE FROM noticia WHERE codiNoticia = ?";
  $stmt = mysqli_prepare($connection, $sql);

  if (!$stmt) {
    return false;
  }

  mysqli_stmt_bind_param($stmt, "i", $id);
  $success = mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  return $success;
}

// VIEW COMPONENTS
function optionComponent($value, $text)
{
  $safeValue = htmlspecialchars($value);
  $safeText = htmlspecialchars($text);
  return "<option value='$safeValue' class='text-md'>$safeText</option>";
}

function articleComponent($imatge, $titol, $seccio, $autor, $data, $cos)
{
  $lines = explode(PHP_EOL, $cos);
  $lines = array_filter($lines, "trim");

  $encode_imatge = base64_encode($imatge);
  echo "<div class='noticia flex flex-col gap-2'>";
  echo "<img src='data:image/jpeg;base64,$encode_imatge' class='w-52 rounded-md object-cover aspect-square'/>";
  echo "<div class='flex flex-col gap-1'>";
  echo "<h2 class='text-xl font-medium'>$titol</h2>";
  echo "<p><small>Sección: $seccio</small></p>";
  echo "<p><small>Autor: $autor</small></p>";
  echo "<h2>$data</h2>";
  echo "<div class='noticia-cos'>";
  foreach ($lines as $line) {
    echo "<p>$line</p>";
  }
  echo "</div>";
  echo "</div>";
  echo "</div>";
}
?>
