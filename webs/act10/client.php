<?php
include "./crud.php";

$notices = [];

if (!isset($_GET["submit_search"]) || !isset($_GET["submit_category"])) {
  $notices = getAllNotices();
}

if (isset($_GET["submit_search"])) {
  if (isset($_GET["title"]) && !empty($_GET["title"])) {
    $notices = getAllNoticesByName($_GET["title"]);
  }
}

if (isset($_GET["submit_category"])) {
  if (isset($_GET["category"]) && !empty($_GET["category"])) {
    $notices = getAllNoticesByType(strtolower($_GET["category"]));
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portal de Noticias</title>
    <style>
        .categoria { color: blue; font-weight: bold; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <!-- VISTAS NOTICIS-->
    <main class="w-full py-16">
        <div class="max-w-7xl mx-auto">
            <p class="text-3xl font-medium text-end">
                <span class="font-semibold">Hoy es:</span>
                <?= date("d/m/Y") ?>
            </p>
            <h1 class="text-6xl font-semibold">NOTICIAS</h1>
            <div class="search-notices py-4 flex flex-row items-center gap-5 ">
                <form action="" method="GET" class="flex flex-row gap-3">
                    <input type="text" name="title" placeholder="Buscar..." class="px-4 py-1 rounded-sm border border-solid border-s-stone-900 ">
                    <button type="submit" name="submit_search" class="w-max py-3 px-6 font-semibold bg-black rounded-md text-white cursor-pointer">Buscar</button>
                </form>
                <form action="" method="GET" class="flex flex-row gap-3">
                    <select name="category" id="">
                        <?php
                        $seccions = getAllSeccions();
                        if (empty($seccions)) {
                          echo optionComponent("", "-- No hay opciones --");
                        } else {
                          echo optionComponent(
                            "",
                            "-- Seleciona una Categoria --",
                          );
                        }
                        foreach ($seccions as $sec) {
                          echo optionComponent(
                            $sec["codiSeccio"],
                            $sec["seccio"],
                          );
                        }
                        ?>
                    </select>
                    <button type="submit" name="submit_category" class="w-max py-3 px-6 font-semibold bg-black rounded-md text-white cursor-pointer">Buscar</button>
                </form>
            </div>
            <div class="noticias py-5 grid grid-cols-5 gap-2">
                <?php
                global $notices;

                if (count($notices) == 0) {
                  echo '<p class="text-lg">No hay noticias</p>';
                } else {
                  foreach ($notices as $n) {
                    articleComponent(
                      $n["imatge"],
                      $n["titol"],
                      $n["seccio"],
                      $n["autor"],
                      $n["data"],
                      $n["cos"],
                    );
                  }
                }
                ?>
            </div>
        </div>
    </main>


</body>
</html>
