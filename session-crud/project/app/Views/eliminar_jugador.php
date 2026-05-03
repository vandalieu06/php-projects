<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Jugador</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        h1 { color: #333; }
        .success { color: green; padding: 10px; background: #d4edda; border-radius: 5px; margin-bottom: 15px; }
        .form-container { background: white; padding: 20px; border-radius: 5px; max-width: 800px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #007bff; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        button { padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 15px; }
        button:hover { background: #c82333; }
        a { display: inline-block; margin-top: 15px; color: #007bff; }
    </style>
</head>
<body>
    <h1>Eliminar Jugador</h1>
    <?php if (session()->get('missatge')): ?>
        <div class="success"><?= session()->get('missatge') ?></div>
    <?php endif; ?>
    
    <div class="form-container">
        <?php if (empty($jugadors)): ?>
            <p>No hi ha jugadors a la base de dades.</p>
        <?php else: ?>
            <form method="post" action="/eliminarJugador">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                <table>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Codi</th>
                        <th>Nom</th>
                        <th>Cognoms</th>
                        <th>Demarcació</th>
                        <th>Equip</th>
                    </tr>
                    <?php foreach ($jugadors as $jugador): ?>
                    <tr>
                        <td><input type="radio" name="codiJ" value="<?= $jugador['codiJ'] ?>" required></td>
                        <td><?= $jugador['codiJ'] ?></td>
                        <td><?= esc($jugador['nom']) ?></td>
                        <td><?= esc($jugador['cognoms']) ?></td>
                        <td><?= esc($jugador['demarcacio']) ?></td>
                        <td><?= esc($jugador['nom_equip']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <button type="submit" onclick="return confirm('Segur que vols eliminar aquest jugador?');">Eliminar Jugador</button>
            </form>
        <?php endif; ?>
        <a href="/">Tornar al Menú</a>
    </div>
</body>
</html>