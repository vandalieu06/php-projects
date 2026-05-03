<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Llistat de Jugadors</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        h1 { color: #333; }
        table { border-collapse: collapse; background: white; width: 100%; max-width: 800px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #007bff; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        a { display: inline-block; margin-top: 15px; color: #007bff; }
    </style>
</head>
<body>
    <h1>Llistat de Jugadors</h1>
    <?php if (empty($jugadors)): ?>
        <p>No hi ha jugadors a la base de dades.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Codi</th>
                <th>Nom</th>
                <th>Cognoms</th>
                <th>Demarcació</th>
                <th>Equip</th>
                <th>Foto</th>
            </tr>
            <?php foreach ($jugadors as $jugador): ?>
            <tr>
                <td><?= $jugador['codiJ'] ?></td>
                <td><?= esc($jugador['nom']) ?></td>
                <td><?= esc($jugador['cognoms']) ?></td>
                <td><?= esc($jugador['demarcacio']) ?></td>
                <td><?= esc($jugador['nom_equip']) ?></td>
                <td>
                    <?php if (!empty($jugador['foto'])): ?>
                        <img src="/mostrarFoto/<?= $jugador['foto'] ?>" width="100" alt="Foto de <?= esc($jugador['nom']) ?>">
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <a href="/">Tornar al Menú</a>
</body>
</html>