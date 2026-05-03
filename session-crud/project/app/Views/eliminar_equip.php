<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Equip</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        h1 { color: #333; }
        .success { color: green; padding: 10px; background: #d4edda; border-radius: 5px; margin-bottom: 15px; }
        .form-container { background: white; padding: 20px; border-radius: 5px; max-width: 600px; }
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
    <h1>Eliminar Equip</h1>
    <?php if (session()->get('missatge')): ?>
        <div class="success"><?= session()->get('missatge') ?></div>
    <?php endif; ?>
    
    <div class="form-container">
        <?php if (empty($equips)): ?>
            <p>No hi ha equips a la base de dades.</p>
        <?php else: ?>
            <form method="post" action="/eliminarEquip">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                <table>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Codi</th>
                        <th>Nom</th>
                        <th>Població</th>
                        <th>Socis</th>
                    </tr>
                    <?php foreach ($equips as $equip): ?>
                    <tr>
                        <td><input type="radio" name="codiE" value="<?= $equip['codiE'] ?>" required></td>
                        <td><?= $equip['codiE'] ?></td>
                        <td><?= esc($equip['nom']) ?></td>
                        <td><?= esc($equip['poblacio']) ?></td>
                        <td><?= $equip['numSocis'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <button type="submit" onclick="return confirm('Segur que vols eliminar aquest equip i tots els seus jugadors?');">Eliminar Equip</button>
            </form>
        <?php endif; ?>
        <a href="/">Tornar al Menú</a>
    </div>
</body>
</html>