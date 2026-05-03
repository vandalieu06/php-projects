<?php
include "./crud.php";
include "./views.php";

session_start();

if (isset($_SESSION["user"]) && isset($_SESSION["role"])) {
  if ($_SESSION["role"] == "user") {
    header("Location: client.php");
    exit();
  }
} else {
  header("Location: login.php");
  exit();
}

if (isset($_POST["btn-logout"])) {
  session_destroy();
  header("Location: login.php");
  exit();
}

if (isset($_POST["new-notice-submit"])) {
  $titol = $_POST["titulo"];
  $cos = $_POST["cos"];
  $autor = $_POST["autor"];
  $codiSeccio = $_POST["codiSeccio"];
  $data = date("Y/m/d");

  $tipus = $_FILES["imatge"]["type"];
  $imatge = file_get_contents($_FILES["imatge"]["tmp_name"]);

  $success = addNewNotice(
    $titol,
    $cos,
    $autor,
    $codiSeccio,
    $data,
    $imatge,
    $tipus,
  );
  header("location:admin.php?success=1");
}

if (isset($_POST["delete-notice-submit"])) {
  $res = deleteNoticeById($_POST["notice_id"]);
  if ($res) {
    header("location:admin.php?success=1");
  } else {
    echo "No se pudo eliminar la noticia.";
  }
}

if (isset($_POST["modify-notice-submit"])) {
  $id = $_POST["id"];
  $titol = $_POST["titulo"];
  $cos = $_POST["cos"];

  $imatge = null;
  if (isset($_FILES["imatge"]) && $_FILES["imatge"]["error"] == UPLOAD_ERR_OK) {
    $imatge = file_get_contents($_FILES["imatge"]["tmp_name"]);
  }

  $res = updateNewNotice($id, $titol, $cos, $imatge);
  header("location:admin.php?success=" . ($res ? "1" : "0"));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Console // Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8f8f8] text-[#1a1a1a] min-h-screen flex">

    <aside class="w-64 bg-white border-r border-gray-200 hidden lg:flex flex-col sticky top-0 h-screen">
        <div class="p-8">
            <div class="flex items-center gap-2 mb-10">
                <div class="w-6 h-6 bg-black rounded-lg"></div>
                <span class="font-bold tracking-tighter text-xl">NEWS.</span>
            </div>

            <nav class="space-y-1">
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-black text-white rounded-xl text-sm font-medium transition-all">
                    Dashboard
                </a>
                <form action="" method="post">
                    <button type="submit" name="btn-logout" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-100 rounded-xl text-sm font-medium transition-all">
                        Cerrar Sesión
                    </button>
                </form>
            </nav>
        </div>
        <div class="mt-auto p-8 text-[10px] text-gray-400 uppercase tracking-widest">
            v2.0.26 — Admin
        </div>
    </aside>

    <main class="flex-1 p-4 md:p-10">
        <?php if (isset($_GET["success"])): ?>
            <div class="mb-8 p-4 bg-white border border-gray-200 rounded-2xl flex items-center justify-between shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
                <span class="text-sm font-medium flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full <?= $_GET["success"] ===
                    "1"
                      ? "bg-green-500"
                      : "bg-red-500" ?>"></span>
                    <?= $_GET["success"] === "1"
                      ? "Operación completada con éxito."
                      : "Hubo un error al procesar la solicitud." ?>
                </span>
                <a href="admin.php" class="text-xs text-gray-400 hover:text-black">Cerrar</a>
            </div>
        <?php endif; ?>

        <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Panel de Gestión</h2>
                <p class="text-gray-500 text-sm">Crea, edita o elimina noticias del portal.</p>
            </div>
        </header>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

            <section class="xl:col-span-2 bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3 mb-8">
                    <span class="p-2 bg-gray-50 rounded-lg text-xs font-bold">01</span>
                    <h3 class="font-semibold">Redactar Nueva Noticia</h3>
                </div>

                <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-gray-600 ml-1">Título</label>
                        <input type="text" name="titulo" placeholder="Ej: Nueva tendencia en..." class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-black transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-gray-600 ml-1">Autor</label>
                        <input type="text" name="autor" placeholder="Nombre del redactor" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-black transition-all">
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-xs font-semibold text-gray-600 ml-1">Contenido</label>
                        <textarea name="cos" rows="5" placeholder="Escribe aquí el cuerpo de la noticia..." class="w-full bg-gray-50 border-none rounded-3xl p-4 text-sm focus:ring-2 focus:ring-black transition-all resize-none"></textarea>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-gray-600 ml-1">Categoría</label>
                        <select name="codiSeccio" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-black appearance-none cursor-pointer">
                            <?php
                            $seccions = getAllSeccions();
                            echo empty($seccions)
                              ? optionComponent("", "No hay opciones")
                              : optionComponent("", "Selecciona categoría");
                            foreach ($seccions as $sec) {
                              echo optionComponent(
                                $sec["codiSeccio"],
                                $sec["seccio"],
                              );
                            }
                            ?>
                        </select>
                    </div>

                    <!--<div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-gray-600 ml-1">Tipo de Noticia</label>
                        <input type="text" name="tipus" placeholder="Ej: Urgente" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-black transition-all">
                    </div>-->

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-xs font-semibold text-gray-600 ml-1">Imagen de Portada</label>
                        <div class="relative group">
                            <input type="file" name="imatge" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="w-full bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-8 text-center group-hover:bg-gray-100 transition-all">
                                <span class="text-xs text-gray-500">Haz click para subir o arrastra un archivo</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="new-notice-submit" class="md:col-span-2 bg-black text-white font-bold py-4 rounded-2xl hover:shadow-lg hover:shadow-black/10 active:scale-[0.98] transition-all">
                        Crear Noticia
                    </button>
                </form>
            </section>

            <div class="space-y-8">

                <section class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                    <h3 class="font-semibold mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        Eliminar
                    </h3>
                    <form action="" method="POST" class="space-y-4">
                        <select name="notice_id" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-red-500 appearance-none cursor-pointer">
                            <option value="">Elegir noticia...</option>
                            <?php
                            $notices = getAllNotices();
                            foreach ($notices as $n) {
                              echo optionComponent(
                                $n["codiNoticia"],
                                $n["titol"],
                              );
                            }
                            ?>
                        </select>
                        <button type="submit" name="delete-notice-submit" class="w-full bg-red-50 text-red-600 font-bold py-4 rounded-2xl hover:bg-red-100 transition-all text-xs uppercase tracking-widest">
                            Eliminar Registro
                        </button>
                    </form>
                </section>

                <section class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                    <h3 class="font-semibold mb-6">Editar Existente</h3>
                    <form action="" method="GET" class="space-y-4">
                        <select name="notice_id" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-black appearance-none cursor-pointer">
                            <option value="">Elegir noticia...</option>
                            <?php foreach ($notices as $n) {
                              echo optionComponent(
                                $n["codiNoticia"],
                                $n["titol"],
                              );
                            } ?>
                        </select>
                        <button type="submit" name="select-notice-modify" class="w-full border border-gray-200 text-black font-bold py-4 rounded-2xl hover:bg-gray-50 transition-all text-xs uppercase tracking-widest">
                            Cargar Editor
                        </button>
                    </form>

                    <?php if (
                      isset($_GET["select-notice-modify"]) &&
                      !empty($_GET["notice_id"])
                    ):
                      $data = getNoticeByID($_GET["notice_id"]);
                      if ($data): ?>
                        <div class="mt-8 pt-8 border-t border-gray-100 animate-in fade-in duration-500">
                            <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= $data["codiNoticia"] ?>">
                                <input
                                    type="text"
                                    name="titulo"
                                    value="<?= $data["titol"] ?>"
                                    class="w-full bg-gray-50 border-none rounded-xl p-3 text-sm">
                                <textarea
                                    name="cos"
                                    rows="3"
                                    class="w-full bg-gray-50 border-none rounded-xl p-3 text-sm">
                                      <?= $data["cos"] ?>
                                </textarea>
                                <input type="file" name="imatge" class="text-[10px] text-gray-400">
                                <button
                                    type="submit"
                                    name="modify-notice-submit"
                                    class="w-full bg-black text-white font-bold py-3 rounded-xl text-xs uppercase tracking-widest">
                                    Guardar
                                </button>
                            </form>
                        </div>
                    <?php endif;
                    endif; ?>
                </section>
            </div>
        </div>
    </main>
</body>
</html>
