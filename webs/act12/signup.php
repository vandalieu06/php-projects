<?php
session_start();
require_once "./crud/connection.php";
require_once "./crud/auth.php";

if (isset($_SESSION["role"])) {
  redirect_by_role($_SESSION["role"]);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["btn-signup"])) {
  $name = trim($_POST["nom"]);
  $cognoms = trim($_POST["cognoms"]);
  $email = trim($_POST["email"]);
  $password = $_POST["password"];

  [$success, $response] = sign_up_new_account(
    $connection,
    $email,
    $password,
    $name,
    $cognoms,
  );

  if ($success) {
    header("Location: login.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre // CURATED</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Plus+Jakarta+Sans:wght@200;300;400;500&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fafafa; }
        .serif { font-family: 'Bodoni Moda', serif; }
    </style>
</head>
<body class="text-neutral-900 antialiased min-h-screen flex flex-col">

    <nav class="fixed top-0 w-full z-50 mix-blend-difference text-white p-8 flex justify-between items-center">
        <h1 class="serif text-3xl tracking-tighter">CURATED</h1>
        <div class="flex items-center space-x-8">
            <a href="index.php" class="text-[10px] uppercase tracking-[0.3em] hover:opacity-50 transition-opacity">Tornar a la botiga</a>
        </div>
    </nav>

    <main class="flex-1 flex items-center justify-center pt-32 px-8">
        <div class="w-full max-w-md">
            <div class="text-center mb-12">
                <h2 class="serif text-5xl md:text-6xl leading-[0.9] mb-4">Crear Compte</h2>
                <p class="text-neutral-500 font-light">Registra't per accedir</p>
            </div>

            <div class="bg-white p-10 border border-neutral-100">
                <form action="" method="post" class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-[0.3em] text-neutral-500">Nom</label>
                        <input
                            type="text"
                            name="nom"
                            required
                            class="w-full bg-neutral-50 border-none rounded-none p-4 text-sm focus:ring-1 focus:ring-black transition-all outline-none"
                            placeholder="El teu nom"
                        >
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-[0.3em] text-neutral-500">Cognoms</label>
                        <input
                            type="text"
                            name="cognoms"
                            required
                            class="w-full bg-neutral-50 border-none rounded-none p-4 text-sm focus:ring-1 focus:ring-black transition-all outline-none"
                            placeholder="Cognoms"
                        >
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-[0.3em] text-neutral-500">Email</label>
                        <input
                            type="text"
                            name="email"
                            required
                            class="w-full bg-neutral-50 border-none rounded-none p-4 text-sm focus:ring-1 focus:ring-black transition-all outline-none"
                            placeholder="correu@exemple.com"
                        >
                    </div>



                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-[0.3em] text-neutral-500">Contrasenya</label>
                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full bg-neutral-50 border-none rounded-none p-4 text-sm focus:ring-1 focus:ring-black transition-all outline-none"
                            placeholder="••••••••"
                        >
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-[0.3em] text-neutral-500">Confirmar Contrasenya</label>
                        <input
                            type="password"
                            name="confirm_password"
                            required
                            class="w-full bg-neutral-50 border-none rounded-none p-4 text-sm focus:ring-1 focus:ring-black transition-all outline-none"
                            placeholder="••••••••"
                        >
                    </div>

                    <?php if (!empty($error)): ?>
                        <p class="text-red-600 text-xs text-center"><?= htmlspecialchars(
                          $error,
                        ) ?></p>
                    <?php endif; ?>

                    <div class="pt-4">
                        <button
                            type="submit"
                            name="btn-signup"
                            class="w-full bg-black text-white py-4 font-medium text-sm uppercase tracking-widest hover:bg-neutral-800 transition-colors"
                        >
                            Crear compte
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-neutral-400 text-sm">
                        Ja tens compte?
                        <a href="login.php" class="text-black underline underline-offset-4 hover:text-neutral-600 transition-colors">Iniciar sessió</a>
                    </p>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
