<?php

function getAllProducts($connection)
{
  $sql = "SELECT * FROM producte";
  $result = mysqli_query($connection, $sql);
  $productes = [];
  if (!$result) {
    return [];
  }

  while ($row = mysqli_fetch_assoc($result)) {
    $productes[] = $row;
  }

  return $productes;
}

function addNewProduct($connection, $nom, $desc, $preu, $stock, $file_imatge)
{
  $imatge = $file_imatge;
  $imatge_data = file_get_contents($imatge["tmp_name"]);
  $tipus = $imatge["type"];

  $sql = "INSERT INTO producte (nom, descripcio, preu, stock, tipusImatge, dadesImatge) VALUES (?, ?, ?, ?, ?, ?)";

  $stmt = mysqli_prepare($connection, $sql);

  if (!$stmt) {
    return [];
  }

  $null = null;

  mysqli_stmt_bind_param($stmt, "ssissb", $nom, $desc, $preu, $stock, $tipus, $null);

  mysqli_stmt_send_long_data($stmt, 5, $imatge_data);
  $result = mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  return $result;
}

function updateProduct(
  $connection,
  $id,
  $nom,
  $desc,
  $preu,
  $stock,
  $file_imatge,
) {
  if (!empty($file_imatge) && $file_imatge["size"] > 0) {
    $imatge_data = file_get_contents($file_imatge["tmp_name"]);
    $tipus = $file_imatge["type"];

    $sql = "UPDATE producte SET nom = ?, descripcio = ?, preu = ?, stock = ?, tipusImatge = ?, dadesImatge = ? WHERE codiProducte = ?";
    $stmt = mysqli_prepare($connection, $sql);
    if (!$stmt) {
      return false;
    }

    $null = null;
    mysqli_stmt_bind_param($stmt, "ssissbi", $nom, $desc, $preu, $stock, $tipus, $null, $id);
    mysqli_stmt_send_long_data($stmt, 5, $imatge_data);
  } else {
    $sql = "UPDATE producte SET nom = ?, descripcio = ?, preu = ?, stock = ? WHERE codiProducte = ?";
    $stmt = mysqli_prepare($connection, $sql);
    if (!$stmt) {
      return false;
    }
    mysqli_stmt_bind_param($stmt, "ssiii", $nom, $desc, $preu, $stock, $id);
  }

  $success = mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  return $success;
}

function deleteProductById($connection, $id)
{
  $sql = "DELETE FROM producte WHERE codiProducte = ?";
  $stmt = mysqli_prepare($connection, $sql);

  if (!$stmt) {
    return false;
  }

  mysqli_stmt_bind_param($stmt, "i", $id);
  $success = mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  return $success;
}

?>
