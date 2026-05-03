<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Llistat d'Equips</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        h1 { color: #333; }
        table { border-collapse: collapse; background: white; width: 100%; max-width: 600px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #007bff; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        a { display: inline-block; margin-top: 15px; color: #007bff; }
    </style>
</head>
<body>
    <h1>Llistat d'Equips</h1>
    <?php if (empty($equips)): ?>
        <p>No hi ha equips a la base de dades.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Codi</th>
                <th>Nom</th>
                <th>Població</th>
                <th>Nombre de Socis</th>
            </tr>
            <?php foreach ($equips as $equip): ?>
            <tr>
                <td><?= $equip['codiE'] ?></td>
                <td><?= esc($equip['nom']) ?></td>
                <td><?= esc($equip['poblacio']) ?></td>
                <td><?= $equip['numSocis'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <a href="/">Tornar al Menú</a>
</body>
</html>