<?php

function attempt_login($connection, $username, $password)
{
  if (empty($username) || empty($password)) {
    return [false, "Por favor, rellena todos los campos."];
  }

  $sql = "SELECT codiUsuari, email, password, admin FROM usuari WHERE email = ?";
  $stmt = mysqli_prepare($connection, $sql);

  if (!$stmt) {
    return [false, "Error en la base de datos."];
  }

  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($user = mysqli_fetch_assoc($result)) {
    if (password_verify($password, $user["password"])) {
      return [true, $user]; // Éxito
    }
    return [false, "Contraseña incorrecta."];
  }

  mysqli_stmt_close($stmt);
  return [false, "El usuario no existe."];
}

function sign_up_new_account($connection, $user, $pass, $name, $lastname)
{
  $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
  $role = $user == "admin" ? true : false;

  $sql = "
    INSERT INTO usuari (email, password, nom, cognoms, admin)
    VALUES (?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($connection, $sql);
  mysqli_stmt_bind_param(
    $stmt,
    "ssssi",
    $user,
    $hashed_password,
    $name,
    $lastname,
    $role,
  );
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  return [true, "Usuario creado con éxito."];
}

function redirect_by_role($role)
{
  $path = $role ? "dashboard.php" : "index.php";
  header("Location: $path");
  exit();
}
