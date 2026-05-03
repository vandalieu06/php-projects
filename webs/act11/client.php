<?php
include "./crud.php";
include "./views.php";

session_start();

// LOGOUT
if (isset($_POST["btn-logout"])) {
  session_destroy();
  header("Location: login.php");
  exit();
}

// SEGURIDAD
if (isset($_SESSION["user"]) && isset($_SESSION["role"])) {
  if ($_SESSION["role"] == "admin") {
    header("Location: admin.php");
    exit();
  }
} else {
  header("Location: login.php");
  exit();
}

// VARIABLES INICIALES
$limit = 4;
$page = isset($_GET["page"]) ? (int) $_GET["page"] : 0;
$offset = $page * $limit;
$prev = $page - 1;
$next = $page + 1;

$queryParams = "";
if (isset($_GET["submit_search"])) {
  $queryParams .= "&submit_search=&title=" . urlencode($_GET["title"]);
}
if (isset($_GET["submit_category"])) {
  $queryParams .= "&submit_category=&category=" . urlencode($_GET["category"]);
}

// LÓGICA DE CARGA
$notices = [];

if (isset($_GET["submit_search"]) && !empty($_GET["title"])) {
  $notices = getAllNoticesByName($_GET["title"], $limit, $offset);
} elseif (isset($_GET["submit_category"]) && !empty($_GET["category"])) {
  $notices = getAllNoticesByType(
    strtolower($_GET["category"]),
    $limit,
    $offset,
  );
} elseif (isset($_GET["page"])) {
  $notices = getNoticesByQuerys($limit, $offset);
} else {
  $notices = getNoticesByQuerys($limit, 0);
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Noticias</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .categoria {
            color: black;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            background: #f3f4f6;
            padding: 2px 8px;
            border-radius: 6px;
        }
    </style>
</head>
<body class="bg-[#f8f8f8] text-[#1a1a1a] antialiased">
    <!-- HEADER -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-black rounded-lg flex items-center justify-center">
                    <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                </div>
                <span class="font-bold tracking-tighter text-xl italic">NEWS.</span>
            </div>
            <div class="flex items-center gap-6">
                <p class="text-[11px] uppercase tracking-widest text-gray-400 font-medium">
                    <span class="text-black font-bold">Hoy:</span> <?= date(
                      "d.m.Y",
                    ) ?>
                </p>
                <form action="" method="post">
                    <button type="submit" name="btn-logout" class="bg-gray-100 px-4 py-2 rounded-xl text-xs font-bold hover:bg-black hover:text-white transition-all">
                        Salir
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- NOTICIAS -->
    <main class="max-w-7xl mx-auto px-6 py-12">
        <!-- BUSCADORES PORT TITULO Y TIPO-->
        <header class="mb-12">
            <h1 class="text-5xl font-extrabold tracking-tighter mb-8">Explorar Noticias</h1>

            <div class="flex flex-col md:flex-row gap-4 bg-white p-4 rounded-3xl border border-gray-100 shadow-sm">
                <form action="" method="GET" class="flex-1 flex gap-2">
                    <input
                        type="text"
                        name="title"
                        placeholder="Buscar por título..."
                        class="flex-1 bg-gray-50 border-none rounded-2xl px-6 py-3 text-sm focus:ring-2 focus:ring-black outline-none transition-all"
                    >
                    <button type="submit" name="submit_search" class="bg-black text-white px-6 rounded-2xl text-xs font-bold uppercase tracking-widest hover:shadow-lg hover:shadow-black/10 transition-all">
                        Buscar
                    </button>
                </form>

                <div class="hidden md:block w-px h-10 bg-gray-100 self-center"></div>

                <form action="" method="GET" class="flex-1 flex gap-2">
                    <select name="category" class="flex-1 bg-gray-50 border-none rounded-2xl px-6 py-3 text-sm focus:ring-2 focus:ring-black outline-none appearance-none cursor-pointer text-gray-500">
                        <?php
                        $seccions = getAllSeccions();
                        if (empty($seccions)) {
                          echo optionComponent("", "No hay categorías");
                        } else {
                          echo optionComponent("", "Filtrar por categoría");
                        }
                        foreach ($seccions as $sec) {
                          echo optionComponent(
                            $sec["codiSeccio"],
                            $sec["seccio"],
                          );
                        }
                        ?>
                    </select>
                    <button type="submit" name="submit_category" class="bg-gray-100 text-black px-6 rounded-2xl text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all">
                        Filtrar
                    </button>
                </form>
            </div>
        </header>

        <!--CUERPO DE LAS NOTICIAS-->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php
            global $notices;

            if (count($notices) == 0) {
              echo '
              <div class="col-span-full py-36 text-center bg-white rounded-[3rem] border border-dashed border-gray-200">
                <p class="text-gray-400 font-medium italic">No se encontraron noticias en esta sección.</p>
              </div>';
            } else {
              foreach ($notices as $n) {
                articleComponent(
                  $n["imatge"],
                  $n["titol"],
                  $n["seccio"],
                  $n["autor"],
                  $n["data"],
                  $n["cos"],
                  $n["tipus"],
                );
              }
            }
            ?>
        </div>

        <!-- BOTONES DE PAGINADO -->
        <div class="flex justify-center gap-2">
            <div class="flex justify-center gap-4 mt-8">
                <?php if ($page > 0): ?>
                    <a href="client.php?page=<?= $prev . $queryParams ?>"
                        class="bg-black text-white px-6 py-2 rounded-2xl text-xs font-bold uppercase tracking-widest hover:shadow-lg transition-all">
                        Atras
                    </a>
                <?php endif; ?>

                <?php if (count($notices) == $limit): ?>
                    <a href="client.php?page=<?= $next . $queryParams ?>"
                        class="bg-black text-white px-6 py-2 rounded-2xl text-xs font-bold uppercase tracking-widest hover:shadow-lg transition-all">
                        Siguiente
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- LITTLE FOOTER -->
    <footer class="max-w-7xl mx-auto px-6 py-12 border-t border-gray-200 mt-12">
        <p class="text-[10px] text-gray-400 uppercase tracking-[0.3em] text-center font-bold">
            Portal Informativo — Powered by News Console 2026
        </p>
    </footer>
</body>
</html>
