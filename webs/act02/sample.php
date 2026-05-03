<?php
function comprova_email3(string $email): bool
{
  $email_corregido = strtolower($email);
  //\s+ escoge todos los espacio en blanco
  $email_corregido = preg_replace('/\s+/', '', $email_corregido);
  $tiene_arroba = str_contains($email_corregido, '@');
  $mida = strlen($email_corregido);
  // Obtenemos el dominio, example@exemple.com. Cogemos la posicion despues del 
  $dominio = substr($email_corregido, strpos($email_corregido, '@') + 1);

  return $mida < 75 && $tiene_arroba && checkdnsrr($dominio, "A") ? TRUE : FALSE;
}

$email1 = "CORREU.de.Prova@exeasple.cat ";
$email2 = "claurejhonny188@gmail.com";

$correcto = "<span style='color: green;'>VALIDO</span>";
$invalido = "<span style='color: red;'>INVALIDO</span>";

echo "<p>Email 1 ('$email1'): " . (comprova_email3($email1) ? $correcto : $invalido) . "</p>";
echo "<p>Email 2 ('$email2'): " . (comprova_email3($email2) ? $correcto : $invalido) . "</p>";
?>
