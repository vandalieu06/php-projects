<?php
include "./crud.php";

if (isset($_POST["new-notice-submit"])) {
  $titol = $_POST["titulo"];
  $cos = $_POST["cos"];
  $autor = $_POST["autor"];
  $codiSeccio = $_POST["codiSeccio"];
  $data = date("Y/m/d");
  $tipus = $_POST["tipus"];
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

if (isset($_GET["success"])) {
  if ($_GET["success"] === "1") {
    echo "<p class='py-4 font-semibold text-center text-green-600 text-3xl'>Cambios hechos con éxito.</p>";
  } else {
    echo "<p class='py-4 font-semibold text-center text-red-600 text-3xl'>Error al aplicar los cambios.</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Portal de Noticias - ADMIN</title>
	<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<bodym class="max-w-7xl mx-auto grid grid-cols-2">
    <!-- AÑADIR NOTICIA -->
    <section class="w-full py-16">
        <div class="mx-auto">
            <h2 class="text-5xl font-semibold">CREAR NOTICIAS</h2>
            <div class="pt-4">
                <form action="" method="POST" enctype="multipart/form-data" class="w-80 flex flex-col gap-2">
                    <input type="text" name="titulo" placeholder="Titulo" class="px-4 py-1 rounded-sm border border-solid border-s-stone-900">
                    <textarea name="cos" placeholder="Introduce el texto ..." rows="5" max="350" class="px-4 py-1 rounded-sm border border-solid border-s-stone-900"></textarea>
                    <input type="text" name="autor" placeholder="Autor" class="px-4 py-1 rounded-sm border border-solid border-s-stone-900 ">
                    <select name="codiSeccio" class="px-4 py-1 rounded-sm border border-solid border-s-stone-900">
                        <?php
                        $seccions = getAllSeccions();
                        if (empty($seccions)) {
                          echo optionComponent("", "No hay opciones");
                        } else {
                          echo optionComponent("", "-- SELECIONA UN TIPO --");
                        }
                        foreach ($seccions as $sec) {
                          echo optionComponent(
                            $sec["codiSeccio"],
                            $sec["seccio"],
                          );
                        }
                        ?>
                    </select>
                    <!--<input type="date" name="date" placeholder="Codigo Sección" class="px-4 py-1 rounded-sm border border-solid border-s-stone-900 ">-->
                    <input type="text" name="tipus" placeholder="Tipo" class="px-4 py-1 rounded-sm border border-solid border-s-stone-900">
                    <input type="file" name="imatge" class="px-4 py-1 rounded-sm border border-solid border-s-stone-900">
                    <button type="submit" name="new-notice-submit" class="w-max py-3 px-6 bg-black rounded-md text-white font-semibold cursor-pointer">
                        Crear Noticia
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- ELIMINAR NOTICIA -->
    <section class="w-full py-16">
        <div class="mx-auto">
            <h2 class="text-5xl font-semibold">ELIMINAR NOTICIAS</h1>
                <div class="pt-4">
                    <form action="" method="POST" enctype="multipart/form-data" class="w-80 flex flex-col gap-2">
                        <select name="notice_id">
                            <option value="" class='text-md'>-- Escoge una noticia --</option>
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

                        <button type="submit" name="delete-notice-submit" class="w-max py-3 px-6 bg-black rounded-md text-white font-semibold cursor-pointer">
                            Eliminar Noticia
                        </button>
                    </form>

                </div>
        </div>
    </section>

    <!-- MODIFICAR NOTICIA -->
    <section class="w-full py-16">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-semibold">MODIFICAR NOTICIAS</h2>
            <div class="pt-4">
                <div>
                    <h4 class="font-medium text-lg">Selecciona una noticia para modificar</h4>
                    <form action="" class="py-4 flex flex-row items-center gap-3">
                        <select name="notice_id">
                            <option value="" class='text-md'>-- Escoge una noticia --</option>
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
                        <button type="submit" name="select-notice-modify" class="w-max py-3 px-6 bg-black rounded-md text-white font-semibold cursor-pointer">
                            Buscar Noticia
                        </button>
                    </form>
                </div>

                <?php if (
                  isset($_GET["select-notice-modify"]) &&
                  !empty($_GET["notice_id"])
                ):
                  $data = getNoticeByID($_GET["notice_id"]);
                  if ($data): ?>

                <form action="" method="POST" enctype="multipart/form-data" class="w-80 flex flex-col gap-2">
                    <input type="hidden" name="id" value="<?= $data[
                      "codiNoticia"
                    ] ?>">
                    <input
                        type="text"
                        name="titulo"
                        placeholder="Titulo"
                        value="<?= $data["titol"] ?>"
                        class="px-4 py-1 rounded-sm border border-solid border-s-stone-900">
                    <textarea name="cos" placeholder="Introduce el texto ..." rows="5" max="350" class="px-4 py-1 rounded-sm border border-solid border-s-stone-900"><?= $data[
                      "cos"
                    ] ?></textarea>
                    <!--<input type="text" name="autor" placeholder="Autor" class="px-4 py-1 rounded-sm border border-solid border-s-stone-900 ">-->
                    <!--<select name="codiSeccio" class="px-4 py-1 rounded-sm border border-solid border-s-stone-900"></select>-->
                    <!--<input type="date" name="date" placeholder="Codigo Sección" class="px-4 py-1 rounded-sm border border-solid border-s-stone-900 ">-->
                    <!--<input type="text" name="tipus" placeholder="Tipo" class="px-4 py-1 rounded-sm border border-solid border-s-stone-900">-->
                    <input type="file" name="imatge" class="px-4 py-1 rounded-sm border border-solid border-s-stone-900">
                    <button type="submit" name="modify-notice-submit" class="w-max py-3 px-6 bg-black rounded-md text-white font-semibold cursor-pointer">
                        Modificar Noticia
                    </button>
                </form>

                <?php endif;
                endif; ?>
            </div>
        </div>
    </section>


</body>
</html>
