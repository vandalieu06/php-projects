<?php
session_start();
include "./connection.php";

// 1. Redirección si ya está logueado
if (isset($_SESSION["user"]) && isset($_SESSION["role"])) {
  if ($_SESSION["role"] == "admin") {
    header("Location: admin.php");
    exit();
  } else {
    header("Location: client.php");
    exit();
  }
}

$error = "";

if (isset($_POST["btn-login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  if (!empty($username) && !empty($password)) {
    // Preparamos la consulta para buscar al usuario por su nombre (nom)
    $sql = "SELECT nom, hash, tipus FROM usuari WHERE nom = ?";
    $stmt = mysqli_prepare($connection, $sql);

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
      // Verificamos si la contraseña coincide con el hash de Bcrypt
      if (password_verify($password, $user["hash"])) {
        // ¡ÉXITO! Guardamos en la sesión
        $_SESSION["user"] = $user["nom"];
        $_SESSION["role"] = $user["tipus"]; // 'admin' o 'user' según tu DB

        if ($_SESSION["role"] == "admin") {
          header("Location: admin.php");
        } else {
          header("Location: client.php");
        }
        exit();
      } else {
        $error = "Contraseña incorrecta.";
      }
    } else {
      $error = "El usuario no existe.";
    }
    mysqli_stmt_close($stmt);
  } else {
    $error = "Por favor, rellena todos los campos.";
  }
}

// EXAMPLE ADD NEW USER
// $user = "jhonny";
// $pass = "1234"; // La contraseña que quieras
// $role = "user";

// // Generar el hash de Bcrypt
// $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

// $sql = "INSERT INTO usuari (nom, hash, tipus) VALUES (?, ?, ?)";
// $stmt = mysqli_prepare($connection, $sql);
// mysqli_stmt_bind_param($stmt, "sss", $user, $hashed_password, $role);
// mysqli_stmt_execute($stmt);

// echo "Usuario creado con éxito.";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso // Console</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8f8f8] text-[#1a1a1a] h-screen flex items-center justify-center antialiased p-6">

    <div class="w-full max-w-[400px]">
        <div class="flex justify-center mb-8">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-black rounded-xl flex items-center justify-center shadow-lg shadow-black/10">
                    <div class="w-2 h-2 bg-white rounded-full"></div>
                </div>
                <span class="font-bold tracking-tighter text-2xl">NEWS.</span>
            </div>
        </div>

        <div class="bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-sm">
            <header class="mb-10">
                <h1 class="text-xl font-bold tracking-tight">Iniciar sesión</h1>
                <p class="text-gray-400 text-sm mt-1">Introduce tus credenciales para continuar.</p>
            </header>

            <form action="" method="post" class="space-y-5">
                <div class="space-y-2">
                    <label class="text-xs font-semibold text-gray-600 ml-1">Usuario</label>
                    <input
                        type="text"
                        name="username"
                        required
                        class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-black transition-all outline-none"
                        placeholder="nombre_usuario"
                    >
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-semibold text-gray-600 ml-1">Contraseña</label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-black transition-all outline-none"
                        placeholder="••••••••"
                    >
                </div>

                <div class="pt-4">
                    <button
                        type="submit"
                        name="btn-login"
                        class="w-full bg-black text-white py-4 rounded-2xl font-bold text-sm hover:shadow-xl hover:shadow-black/10 active:scale-[0.98] transition-all"
                    >
                        Entrar al sistema
                    </button>
                </div>
            </form>

            <?php if ($error): ?>
                <p class="bg-red-100 text-red-600 p-3 rounded-lg text-xs mb-4 text-center"><?= $error ?></p>
            <?php endif; ?>
        </div>

        <footer class="mt-8 text-center">
            <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-medium">
                Terminal Secure Access &copy; 2026
            </p>
        </footer>
    </div>

</body>
</html>
