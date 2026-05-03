<?php

$db = "./sample.db";
$dsn = "sqlite:$db";

try {
  $connection = new \PDO($dsn);
  $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT id, name, cognoms, email, telefon FROM persona ";
  $stmt = $connection->prepare($sql);
  $stmt->execute();
  $usuarios = $stmt->fetchAll(\PDO::FETCH_ASSOC);

  echo "<h2>Listado de Usuarios de Prueba</h2>";
  echo "<table border='1' cellpadding='10' cellspacing='0'>";
  echo "<thead><tr><th>ID</th><th>Nombre</th><th>Apellidos</th><th>Email</th><th>Teléfono</th></tr></thead>";
  echo "<tbody>";

  if (count($usuarios) > 0) {
    foreach ($usuarios as $usuario) {
      echo "<tr>";
      echo "<td>" . htmlspecialchars($usuario["id"]) . "</td>";
      echo "<td>" . htmlspecialchars($usuario["name"]) . "</td>";
      echo "<td>" . htmlspecialchars($usuario["cognoms"]) . "</td>";
      echo "<td>" . htmlspecialchars($usuario["email"]) . "</td>";
      echo "<td>" . htmlspecialchars($usuario["telefon"]) . "</td>";
      echo "</tr>";
    }
  } else {
    echo "<tr><td colspan='5'>No se encontraron usuarios en la tabla.</td></tr>";
  }

  echo "</tbody>";
  echo "</table>";
} catch (\PDOException $e) {
  echo "❌ Error de conexión o consulta: " . $e->getMessage();
}

?>
