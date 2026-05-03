<?php
//** FRONTENTD **//

// VIEW COMPONENTS (ADMIN + CLIENT)
function optionComponent($value, $text)
{
  $safeValue = htmlspecialchars($value);
  $safeText = htmlspecialchars($text);
  return "<option value='$safeValue' class='text-md'>$safeText</option>";
}

// VIEW COMPONENTS (CLIENT)
function articleComponent($imatge, $titol, $seccio, $autor, $data, $cos, $tipus)
{
  $lines = explode(PHP_EOL, $cos);
  $lines = array_filter($lines, "trim");

  $encode_imatge = base64_encode($imatge);

  echo "<div class='noticia flex flex-col gap-2'>";
  echo "<img src='data:$tipus;base64,$encode_imatge' class='w-52 rounded-md object-cover aspect-square'/>";
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
