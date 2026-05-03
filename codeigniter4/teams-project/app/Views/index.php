<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>EsportDaw - Menú Principal</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        h1 { color: #333; }
        .menu { list-style: none; padding: 0; max-width: 600px; }
        .menu li { margin: 10px 0; }
        .menu a { display: block; padding: 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .menu a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>Gestió d'Equips i Jugadors</h1>
    <ul class="menu">
        <li><a href="/insertarEquip">1. Inserir Equip</a></li>
        <li><a href="/mostrarEquips">2. Mostrar Equips</a></li>
        <li><a href="/eliminarEquip">3. Eliminar Equip</a></li>
        <li><a href="/insertarJugador">4. Inserir Jugador</a></li>
        <li><a href="/mostrarJugadors">5. Mostrar Jugadors</a></li>
        <li><a href="/eliminarJugador">6. Eliminar Jugador</a></li>
        <li><a href="/senseModel">7. Sense Model (Raw Query)</a></li>
    </ul>
</body>
</html>