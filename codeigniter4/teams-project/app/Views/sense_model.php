<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Consulta sense Model (Raw Query)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        h1 { color: #333; }
        .info { color: #666; padding: 10px; background: #e7f3ff; border-radius: 5px; margin-bottom: 15px; }
        table { border-collapse: collapse; background: white; width: 100%; max-width: 800px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #6c757d; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        a { display: inline-block; margin-top: 15px; color: #007bff; }
    </style>
</head>
<body>
    <h1>Consulta sense Model (Raw Query)</h1>
    <div class="info">
        Consulta realitzada directament amb query() - Sense utilitzar Model.
        <br>Llista tots els jugadors amb el nom de llur equip i població.
    </div>
    
    <?php if (empty($resultats)): ?>
        <p>No hi ha jugadors a la base de dades.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Nom</th>
                <th>Cognoms</th>
                <th>Demarcació</th>
                <th>Equip</th>
                <th>Població</th>
            </tr>
            <?php foreach ($resultats as $resultat): ?>
            <tr>
                <td><?= esc($resultat['nom']) ?></td>
                <td><?= esc($resultat['cognoms']) ?></td>
                <td><?= esc($resultat['demarcacio']) ?></td>
                <td><?= esc($resultat['nom_equip']) ?></td>
                <td><?= esc($resultat['poblacio']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <a href="/">Tornar al Menú</a>
</body>
</html>