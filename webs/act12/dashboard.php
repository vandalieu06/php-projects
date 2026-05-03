<?php
session_start();
include "./crud/connection.php";
include "./crud/products.php";
include "./crud/sales.php";

if (isset($_POST["btn-logout"])) {
  session_destroy();
  header("Location: login.php");
  exit();
}

if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  exit();
}

// AÑADIR isADmin
if (isset($_SESSION["user"]) && $_SESSION["role"] != 1) {
  header("Location: index.php");
  exit();
}

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["btn-add"])) {
    $nom = $_POST["nom"];
    $desc = $_POST["desc"];
    $preu = floatval($_POST["preu"]);
    $stock = intval($_POST["stock"]);
    $file = $_FILES["imatge"];

    if ($file["error"] === UPLOAD_ERR_OK && $file["size"] > 0) {
      if (addNewProduct($connection, $nom, $desc, $preu, $stock, $file)) {
        $message = "Producto añadido correctamente";
        $messageType = "success";
      } else {
        $message = "Error al añadir el producto";
        $messageType = "error";
      }
    } else {
      $message = "Selecciona una imagen";
      $messageType = "error";
    }
  }

  if (isset($_POST["btn-update"])) {
    $id = intval($_POST["id"]);
    $nom = $_POST["nom"];
    $desc = $_POST["desc"];
    $preu = floatval($_POST["preu"]);
    $stock = intval($_POST["stock"]);
    $file = $_FILES["imatge"];

    if (updateProduct($connection, $id, $nom, $desc, $preu, $stock, $file)) {
      $message = "Producto actualizado correctamente";
      $messageType = "success";
    } else {
      $message = "Error al actualizar el producto";
      $messageType = "error";
    }
  }

  if (isset($_POST["btn-delete"])) {
    $id = intval($_POST["id"]);
    if (deleteProductById($connection, $id)) {
      $message = "Producto eliminado correctamente";
      $messageType = "success";
    } else {
      $message = "Error al eliminar el producto";
      $messageType = "error";
    }
  }
}

$products = getAllProducts($connection);
$sales = getAllSales($connection);
$salesStats = getTotalSales($connection);
$editProduct = null;

if (isset($_GET["edit"])) {
  $editId = intval($_GET["edit"]);
  foreach ($products as $p) {
    if ($p["codiProducte"] == $editId) {
      $editProduct = $p;
      break;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — CURATED</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Plus+Jakarta+Sans:wght@200;300;400;500;600&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f5f5f5; }
    .serif { font-family: 'Bodoni Moda', serif; }

    .glass {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
    }

    .card-hover {
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover:hover {
      transform: translateY(-4px);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .fade-in {
      animation: fadeIn 0.5s ease-out forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
    .stagger-4 { animation-delay: 0.4s; }

    input:focus, select:focus, textarea:focus {
      outline: none;
      border-color: #1a1a1a;
    }

    .btn-primary {
      background: #1a1a1a;
      color: white;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background: #333;
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-danger {
      background: #dc2626;
      color: white;
      transition: all 0.3s ease;
    }

    .btn-danger:hover {
      background: #b91c1c;
    }
  </style>
</head>
<body class="text-neutral-900 antialiased min-h-screen">

  <!-- Header -->
  <header class="glass fixed top-0 left-0 right-0 z-50 border-b border-neutral-200/50">
    <div class="max-w-7xl mx-auto px-8 py-5 flex justify-between items-center">
      <div class="flex items-center gap-6">
        <h1 class="serif text-2xl tracking-tight">CURATED</h1>
        <span class="text-xs uppercase tracking-[0.2em] text-neutral-500">Dashboard</span>
      </div>
      <div class="flex items-center gap-6">
        <a href="index.php" class="text-xs uppercase tracking-[0.2em] hover:text-neutral-600 transition-colors">Tornar a la botiga</a>
        <form action="" method="POST">
          <button type="submit" name="btn-logout" class="text-xs uppercase tracking-[0.2em] hover:text-neutral-600 transition-colors">
            Tancar sessió
          </button>
        </form>
      </div>
    </div>
  </header>

  <main class="pt-32 pb-20 px-8 max-w-7xl mx-auto">

    <!-- Messages -->
    <?php if (!empty($message)): ?>
      <div class="fade-in mb-8 p-4 rounded-lg <?= $messageType === "success"
        ? "bg-green-50 text-green-800 border border-green-200"
        : "bg-red-50 text-red-800 border border-red-200" ?>">
        <?= $message ?>
      </div>
    <?php endif; ?>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-6 mb-12">
      <div class="glass rounded-2xl p-6 card-hover">
        <p class="text-xs uppercase tracking-widest text-neutral-500 mb-2">
            Total Productes
        </p>
        <p class="serif text-4xl">
          <?= count($products) ?>
        </p>
      </div>
      <div class="glass rounded-2xl p-6 card-hover">
        <p class="text-xs uppercase tracking-widest text-neutral-500 mb-2">
            En Stock
        </p>
        <p class="serif text-4xl">
          <?= array_sum(array_column($products, "stock")) ?>
        </p>
      </div>
      <div class="glass rounded-2xl p-6 card-hover">
        <p class="text-xs uppercase tracking-widest text-neutral-500 mb-2">
            Valor Total
        </p>
        <p class="serif text-4xl">
          <!--https://reintech.io/blog/mastering-php-array-map-function-array-processing--->
          <?= number_format(
            array_sum(array_map(fn($p) => $p["preu"] * $p["stock"], $products)),
            0,
            ",",
            ".",
          ) ?>€
        </p>
      </div>
      <div class="glass rounded-2xl p-6 card-hover">
        <p class="text-xs uppercase tracking-widest text-neutral-500 mb-2">
            Productes Sense Stock
        </p>
        <p class="serif text-4xl"><?= count(
          array_filter($products, fn($p) => $p["stock"] == 0),
        ) ?></p>
      </div>
      <div class="glass rounded-2xl p-6 card-hover">
        <p class="text-xs uppercase tracking-widest text-neutral-500 mb-2">
            Total Comandes
        </p>
        <p class="serif text-4xl"><?= $salesStats["total"] ?? 0 ?></p>
      </div>
      <div class="glass rounded-2xl p-6 card-hover">
        <p class="text-xs uppercase tracking-widest text-neutral-500 mb-2">
            Vent Totals
        </p>
        <p class="serif text-4xl"><?= number_format(
          $salesStats["amount"] ?? 0,
          0,
          ",",
          ".",
        ) ?>€</p>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">

      <!-- Form Añadir Productos -->
      <div class="glass rounded-2xl p-8 card-hover lg:col-span-1">
        <h2 class="serif text-2xl mb-6"><?= $editProduct
          ? "Editar Producte"
          : "Afegir Producte" ?></h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">
          <?php if ($editProduct): ?>
            <input type="hidden" name="id" value="<?= $editProduct[
              "codiProducte"
            ] ?>">
          <?php endif; ?>

          <div>
            <label class="block text-xs uppercase tracking-wider text-neutral-600 mb-2">Nom del producte</label>
            <input type="text" name="nom" required value="<?= $editProduct[
              "nom"
            ] ?? "" ?>"
              class="w-full px-4 py-3 rounded-lg border border-neutral-300 bg-white/50 focus:bg-white transition-all">
          </div>

          <div>
            <label class="block text-xs uppercase tracking-wider text-neutral-600 mb-2">Descripció</label>
            <textarea name="desc" rows="3" required
              class="w-full px-4 py-3 rounded-lg border border-neutral-300 bg-white/50 focus:bg-white transition-all"><?= $editProduct[
                "descripcio"
              ] ?? "" ?></textarea>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs uppercase tracking-wider text-neutral-600 mb-2">Preu (€)</label>
              <input type="number" name="preu" step="0.01" required value="<?= $editProduct[
                "preu"
              ] ?? "" ?>"
                class="w-full px-4 py-3 rounded-lg border border-neutral-300 bg-white/50 focus:bg-white transition-all">
            </div>
            <div>
              <label class="block text-xs uppercase tracking-wider text-neutral-600 mb-2">Stock</label>
              <input type="number" name="stock" required value="<?= $editProduct[
                "stock"
              ] ?? "" ?>"
                class="w-full px-4 py-3 rounded-lg border border-neutral-300 bg-white/50 focus:bg-white transition-all">
            </div>
          </div>

          <div>
            <label class="block text-xs uppercase tracking-wider text-neutral-600 mb-2">Imatge <?= $editProduct
              ? "(opcional)"
              : "" ?></label>
            <input type="file" name="imatge" <?= $editProduct
              ? ""
              : "required" ?> accept="image/*"
              class="w-full px-4 py-3 rounded-lg border border-neutral-300 bg-white/50 focus:bg-white transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-neutral-900 file:text-white file:text-xs file:uppercase file:tracking-wider">
          </div>

          <button type="submit" name="<?= $editProduct
            ? "btn-update"
            : "btn-add" ?>"
            class="w-full btn-primary py-4 rounded-lg text-xs uppercase tracking-[0.2em]">
            <?= $editProduct ? "Actualitzar Producte" : "Afegir Producte" ?>
          </button>

          <?php if ($editProduct): ?>
            <a href="dashboard.php" class="block text-center text-xs uppercase tracking-wider text-neutral-500 hover:text-neutral-800 py-2">
              Cancel·lar
            </a>
          <?php endif; ?>
        </form>
      </div>

      <!-- Productos Grid -->
      <div class="lg:col-span-2">
        <div class="flex justify-between items-center mb-6">
          <h2 class="serif text-2xl">Productes</h2>
          <span class="text-xs uppercase tracking-wider text-neutral-500">
            <?= count($products) ?> productes
          </span>
        </div>

        <?php if (empty($products)): ?>
          <div class="glass rounded-2xl p-12 text-center">
            <p class="text-neutral-500">No hi ha productes encara.</p>
          </div>
        <?php else: ?>
          <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            <?php foreach ($products as $index => $product):

              $stockClass =
                $product["stock"] == 0
                  ? "bg-red-100 text-red-700"
                  : ($product["stock"] < 5
                    ? "bg-amber-100 text-amber-700"
                    : "bg-green-100 text-green-700");
              $stockLabel =
                $product["stock"] == 0
                  ? "Sense stock"
                  : ($product["stock"] < 5
                    ? "Stock baix"
                    : "En stock");
              ?>
              <div class="glass rounded-xl p-4 card-hover fade-in">
                <div class="relative">
                  <div class="w-full aspect-square rounded-lg overflow-hidden bg-neutral-100 mb-3">
                    <?php if ($product["dadesImatge"]): ?>
                      <img src="data:<?= $product[
                        "tipusImatge"
                      ] ?>;base64,<?= base64_encode($product["dadesImatge"]) ?>"
                           alt="<?= htmlspecialchars($product["nom"]) ?>"
                           class="w-full h-full object-cover">
                    <?php else: ?>
                      <div class="w-full h-full flex items-center justify-center text-neutral-400 text-xs">Sense imatge</div>
                    <?php endif; ?>
                  </div>
                  <span class="absolute top-2 right-2 px-2 py-1 rounded-full text-[10px] uppercase tracking-wider <?= $stockClass ?>">
                    <?= $stockLabel ?>
                  </span>
                </div>

                <div class="space-y-2">
                  <div class="flex justify-between items-start">
                    <h3 class="font-medium truncate pr-2">
                      <?= htmlspecialchars($product["nom"]) ?>
                    </h3>
                    <span class="serif text-lg whitespace-nowrap">
                      <?= number_format($product["preu"], 2, ",", ".") ?>€
                    </span>
                  </div>

                  <p class="text-xs text-neutral-500 line-clamp-2">
                    <?= htmlspecialchars($product["descripcio"]) ?>
                  </p>

                  <div class="flex items-center justify-between pt-2 border-t border-neutral-100">
                    <span class="text-xs text-neutral-400">
                        Stock: <?= $product["stock"] ?>
                    </span>

                    <div class="flex gap-1.5">
                      <a href="dashboard.php?edit=<?= $product[
                        "codiProducte"
                      ] ?>"
                        class="px-2.5 py-1.5 text-[10px] uppercase tracking-wider bg-neutral-200 hover:bg-neutral-300 rounded-lg transition-colors">
                        Edit
                      </a>
                      <form action="" method="POST" onsubmit="return confirm('Segur que vols eliminar aquest producte?');">
                        <input type="hidden" name="id" value="<?= $product[
                          "codiProducte"
                        ] ?>">
                        <button type="submit" name="btn-delete"
                          class="px-2.5 py-1.5 text-[10px] uppercase tracking-wider btn-danger rounded-lg">
                          Del
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Ventas -->
    <div class="glass rounded-2xl p-8">
      <div class="flex justify-between items-center mb-6">
        <h2 class="serif text-2xl">Comandes / Vendes</h2>
        <span class="text-xs uppercase tracking-wider text-neutral-500">
          <?= count($sales) ?>comandes
        </span>
      </div>

      <?php if (empty($sales)): ?>
        <div class="p-12 text-center">
          <p class="text-neutral-500">No hi ha comandes encara.</p>
        </div>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-neutral-200">
                <th class="text-left text-xs uppercase tracking-wider text-neutral-500 py-3 pr-4">Comanda</th>
                <th class="text-left text-xs uppercase tracking-wider text-neutral-500 py-3 pr-4">Data</th>
                <th class="text-left text-xs uppercase tracking-wider text-neutral-500 py-3 pr-4">Client</th>
                <th class="text-left text-xs uppercase tracking-wider text-neutral-500 py-3 pr-4">Total</th>
                <th class="text-right text-xs uppercase tracking-wider text-neutral-500 py-3">Acció</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($sales as $sale): ?>
                <tr class="border-b border-neutral-100 hover:bg-neutral-50 transition-colors">
                  <td class="py-4 pr-4">
                    <span class="font-medium">#<?= $sale["codiCompra"] ?></span>
                  </td>
                  <td class="py-4 pr-4">
                    <span class="text-sm text-neutral-600">
                      <?= date("d/m/Y H:i", strtotime($sale["data"])) ?>
                    </span>
                  </td>
                  <td class="py-4 pr-4">
                    <div>
                      <span class="text-sm">
                        <?= htmlspecialchars(
                          $sale["nom"] . " " . $sale["cognoms"],
                        ) ?>
                      </span>
                      <span class="text-xs text-neutral-400 block">
                        <?= htmlspecialchars($sale["email"]) ?>
                      </span>
                    </div>
                  </td>
                  <td class="py-4 pr-4">
                    <span class="serif text-lg">
                      <?= number_format($sale["total"], 2, ",", ".") ?>€
                    </span>
                  </td>
                  <td class="py-4 text-right">
                    <button onclick="toggleSaleDetails(<?= $sale[
                      "codiCompra"
                    ] ?>)"
                      class="px-3 py-1.5 text-xs uppercase tracking-wider bg-neutral-200 hover:bg-neutral-300 rounded-lg transition-colors">
                      Veure
                    </button>
                  </td>
                </tr>
                <tr id="sale-details-<?= $sale["codiCompra"] ?>" class="hidden">
                  <td colspan="5" class="py-4 bg-neutral-50">
                    <?php
                    $details = getSaleDetails($connection, $sale["codiCompra"]);
                    if ($details && !empty($details["items"])): ?>
                      <div class="px-4">
                        <p class="text-xs uppercase tracking-wider text-neutral-500 mb-3">Productes:</p>
                        <div class="space-y-2">
                          <?php foreach ($details["items"] as $item): ?>
                            <div class="flex justify-between text-sm">
                              <span>
                                <?= htmlspecialchars(
                                  $item["nom"],
                                ) ?> x <?= $item["quantitat"] ?>
                              </span>
                              <span class="text-neutral-500">
                                <?= number_format(
                                  $item["preu"] * $item["quantitat"],
                                  2,
                                  ",",
                                  ".",
                                ) ?>€
                              </span>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      </div>
                    <?php endif;
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

  </main>

  <script>
    function toggleSaleDetails(id) {
      const row = document.getElementById('sale-details-' + id);
      row.classList.toggle('hidden');
    }
  </script>

</body>
</html>
