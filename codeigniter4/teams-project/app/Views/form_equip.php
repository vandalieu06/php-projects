<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Inserir Equip</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        h1 { color: #333; }
        .form-container { background: white; padding: 20px; border-radius: 5px; max-width: 500px; }
        label { display: block; margin: 10px 0 5px; font-weight: bold; }
        input[type="text"], input[type="number"] { width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #218838; }
        .error { color: red; font-size: 14px; }
        a { display: inline-block; margin-top: 15px; color: #007bff; }
    </style>
</head>
<body>
    <h1>Inserir Equip</h1>
    <div class="form-container">
        <?php if (isset($validation)): ?>
            <div class="error"><?= $validation->listErrors() ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="post" action="/insertarEquip">
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
            <label for="nom">Nom de l'Equip:</label>
            <input type="text" name="nom" id="nom" value="<?= old(
              "nom",
            ) ?>" required>

            <label for="poblacio">Població:</label>
            <input type="text" name="poblacio" id="poblacio" value="<?= old(
              "poblacio",
            ) ?>" required>

            <label for="numSocis">Nombre de Socis:</label>
            <input type="number" name="numSocis" id="numSocis" value="<?= old(
              "numSocis",
            ) ?>" required>

            <button type="submit">Inserir Equip</button>
        </form>

        <a href="/">Tornar al Menú</a>
    </div>
</body>
</html>
