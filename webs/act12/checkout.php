<?php
session_start();
include "components/cart_item.php";
include "crud/connection.php";
include "crud/products.php";
include "crud/sales.php";

if (isset($_POST["btn-logout"])) {
  session_destroy();
  header("Location: login.php");
  exit();
}

if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  exit();
}

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["btn-checkout"])) {
  $cart = $_SESSION["cistella"];

  if (!empty($cart)) {
    $userId = $_SESSION["user"]["codiUsuari"];
    $result = createSale($connection, $userId, $cart);

    if ($result[0]) {
      $_SESSION["cistella"] = [];
      $message = "Compra realitzada correctament! Comanda #" . $result[1];
      $messageType = "success";
    } else {
      $message = "Error en processar la compra: " . $result[1];
      $messageType = "error";
    }
  }
}

$products = getAllProducts($connection);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout — CURATED</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Plus+Jakarta+Sans:wght@200;300;400;500&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fafafa; }
    .serif { font-family: 'Bodoni Moda', serif; }
    .fade-in { animation: fadeIn 0.5s ease-out forwards; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="text-neutral-900 antialiased">

  <nav class="fixed top-0 w-full z-50 mix-blend-difference text-white p-8 flex justify-between items-center">
    <h1 class="serif text-3xl tracking-tighter">CURATED</h1>
    <div class="flex items-center space-x-8">
      <a href="index.php" class="text-[10px] uppercase tracking-[0.3em] hover:opacity-50 transition-opacity">Tornar a la botiga</a>
      <form action="" method="POST">
        <button type="submit" name="btn-logout" class="text-[10px] uppercase tracking-[0.3em] hover:opacity-50 transition-opacity">
          Tancar sessió
        </button>
      </form>
    </div>
  </nav>

  <section class="max-w-7xl px-8 mx-auto mt-32 mb-40">
    <?php if ($message): ?>
      <div class="fade-in mb-8 p-6 rounded-lg <?= $messageType === "success"
        ? "bg-green-50 text-green-800 border border-green-200"
        : "bg-red-50 text-red-800 border border-red-200" ?>">
        <p class="serif text-xl"><?= $message ?></p>
        <?php if ($messageType === "success"): ?>
          <a href="index.php" class="inline-block mt-4 text-xs uppercase tracking-wider underline">Tornar a la botiga</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="flex flex-col md:flex-row gap-20">
      <div class="md:w-1/4">
        <h2 class="serif text-5xl font-light tracking-tighter sticky top-32">
          Tu Selección <br>
          <span class="italic text-neutral-400 text-3xl">Carrito</span>
        </h2>
        <p class="text-[10px] uppercase tracking-[0.3em] text-neutral-400 mt-8">
          <?= count($_SESSION["cistella"]) ?> Articles totals
        </p>
      </div>

      <div class="md:w-3/4 border-t border-black">
        <div class="cart-products">
          <?php if (empty($_SESSION["cistella"])): ?>
            <p class='py-12 text-neutral-400 italic serif text-2xl'>La cistella està buida.</p>
          <?php else:
            $counts = array_count_values($_SESSION["cistella"]);
            foreach ($counts as $id => $quantity) {
              $product_data = null;
              foreach ($products as $p) {
                if ($p["codiProducte"] == $id) {
                  $product_data = $p;
                  break;
                }
              }
              if ($product_data) {
                renderCartItem($product_data, $quantity);
              }
            }
            ?>
            <?php endif; ?>
        </div>

        <?php if (!empty($_SESSION["cistella"])): ?>
          <?php
          $total = 0;
          foreach ($_SESSION["cistella"] as $id) {
            foreach ($products as $p) {
              if ($p["codiProducte"] == $id) {
                $total += $p["preu"];
              }
            }
          }
          ?>

          <div class="mt-12 border-t border-neutral-200 pt-8">
            <div class="flex justify-end items-baseline gap-6 mb-8">
                <span class="text-[10px] uppercase tracking-[0.3em] text-neutral-400">Total Estimat</span>
                <span class="serif text-4xl italic">
                    <?= number_format($total, 2, ",", ".") ?>€
                </span>
            </div>

            <form method="POST" class="flex justify-end">
              <button type="submit" name="btn-checkout"
                class="bg-black text-white px-12 py-5 text-xs tracking-[0.2em] uppercase font-medium hover:bg-neutral-800 transition-colors duration-300 shadow-xl">
                Finalitzar Compra
              </button>
            </form>

            <p class="text-[10px] text-neutral-400 mt-4 text-right">
              Al fer click, es processarà el pagament i s'actualitzarà l'stock
            </p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

</body>
</html>
