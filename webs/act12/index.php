<?php
session_start();
include "./crud/connection.php";
include "./crud/products.php";
require_once "components/product_card.php";
require_once "components/cart_item.php";

if (isset($_POST["btn-logout"])) {
  session_destroy();
  header("Location: login.php");
  exit();
}

if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  exit();
}

if (isset($_SESSION["role"])) {
  if ($_SESSION["role"]) {
    header("Location: dashboard.php");
    exit();
  }
}

if (!isset($_SESSION["cistella"])) {
  $_SESSION["cistella"] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_to_cart"])) {
  $id = $_POST["product_id"];
  $_SESSION["cistella"][] = $id;

  header("Location: index.php");
  exit();
}

$products = getAllProducts($connection);

$items_in_cart = $_SESSION["cistella"];
$items_in_cart_count = count($_SESSION["cistella"]);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CURATED — Estudi de Disseny</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Plus+Jakarta+Sans:wght@200;300;400;500&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fafafa; }
        .serif { font-family: 'Bodoni Moda', serif; }
        .masonry { column-count: 4; column-gap: 3rem; }
        @media (max-width: 1280px) { .masonry { column-count: 3; } }
        @media (max-width: 1024px) { .masonry { column-count: 2; } }
        @media (max-width: 640px) { .masonry { column-count: 1; } }
    </style>
</head>
<body class="text-neutral-900 antialiased">

    <nav class="fixed top-0 w-full z-50 mix-blend-difference text-white p-8 flex justify-between items-center">
        <h1 class="serif text-3xl tracking-tighter">CURATED</h1>
        <div class="flex items-center space-x-8">
            <a href="checkout.php" class="relative group cursor-pointer">
                <span class="text-[10px] uppercase tracking-[0.3em]">Cistella (<?= $items_in_cart_count ?>)</span>
                <div class="absolute right-0 mt-2 w-4 bg-white h-[1px] scale-x-0 group-hover:scale-x-100 transition-transform origin-right"></div>
            </a>

            <form action="" method="POST">
                <button
                    type="submit"
                    name="btn-logout"
                    class="text-[10px] uppercase tracking-[0.3em] hover:opacity-50 transition-opacity">
                    Cerrar Sesion
                </button>
            </form>
        </div>
    </nav>

    <!--Seccion de productos-->
    <main class="pt-40 px-8 max-w-7xl mx-auto pb-24">
        <header class="mb-16 flex flex-col md:flex-row md:items-end justify-between gap-8">
            <div class="max-w-xl">
                <h2 class="serif text-6xl md:text-8xl leading-[0.9] mb-6">Objetos con <br><span class="italic">alma propia</span></h2>
                <p class="text-neutral-500 font-light leading-relaxed">Una selección meticulosa de piezas que desafían el paso del tiempo y celebran la imperfección artesanal.</p>
            </div>
            <div class="flex space-x-4 pb-2">
                <span class="text-[10px] uppercase tracking-widest border-b border-black pb-1">
                    Tots els productes
                </span>
            </div>
        </header>

        <div class="masonry pb-20">
            <?php foreach ($products as $product): ?>
                <?php renderProductCard($product); ?>
            <?php endforeach; ?>
        </div>
    </main>



    <!-- Boton Infromativo de Carrito -->
    <?php if ($items_in_cart_count > 0): ?>
    <div class="fixed bottom-8 right-8 animate-bounce">
        <a href="checkout.php">
            <div class="bg-black text-white px-6 py-4 rounded-full text-xs tracking-tighter shadow-2xl">
                Tens <?= $items_in_cart_count ?> productes esperant-te.
            </div>
        </a>
    </div>
    <?php endif; ?>



</body>
</html>
