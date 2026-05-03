<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Inserir Jugador</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        h1 { color: #333; }
        .form-container { background: white; padding: 20px; border-radius: 5px; max-width: 500px; }
        label { display: block; margin: 10px 0 5px; font-weight: bold; }
        input[type="text"], select { width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #218838; }
        .error { color: red; font-size: 14px; }
        a { display: inline-block; margin-top: 15px; color: #007bff; }
    </style>
</head>
<body>
    <h1>Inserir Jugador</h1>
    <div class="form-container">
        <?php if (isset($validation)): ?>
            <div class="error"><?= $validation->listErrors() ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if (empty($equips)): ?>
            <p>No hi ha equips disponibles. Has d'inserir un equip primer.</p>
        <?php else: ?>
            <form method="post" action="/insertarJugador">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                <label for="nom">Nom:</label>
                <input type="text" name="nom" id="nom" value="<?= old('nom') ?>" required>
                
                <label for="cognoms">Cognoms:</label>
                <input type="text" name="cognoms" id="cognoms" value="<?= old('cognoms') ?>" required>
                
                <label for="demarcacio">Demarcació:</label>
                <input type="text" name="demarcacio" id="demarcacio" value="<?= old('demarcacio') ?>" placeholder="Ex: Porter, Defense, Davanter..." required>
                
                <label for="codiE">Equip:</label>
                <select name="codiE" id="codiE" required>
                    <option value="">-- Selecciona un Equip --</option>
                    <?php foreach ($equips as $equip): ?>
                        <option value="<?= $equip['codiE'] ?>" <?= old('codiE') == $equip['codiE'] ? 'selected' : '' ?>>
                            <?= esc($equip['nom']) ?> (<?= esc($equip['poblacio']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit">Inserir Jugador</button>
            </form>
        <?php endif; ?>
        
        <a href="/">Tornar al Menú</a>
    </div>
</body>
</html>