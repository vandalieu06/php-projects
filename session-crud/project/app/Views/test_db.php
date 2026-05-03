<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Test Database</title>
    <style>
        body { font-family: monospace; margin: 20px; background: #1e1e1e; color: #d4d4d4; }
        h1 { color: #4ec9b0; }
        h3 { color: #9cdcfe; margin-top: 20px; }
        a { color: #4fc1ff; margin-right: 15px; }
        pre { background: #2d2d2d; padding: 10px; border-radius: 5px; overflow-x: auto; }
        .ok { color: #6a9955; }
        .error { color: #f14c4c; }
        .missatge { background: #2d2d2d; padding: 15px; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>🧪 Test Database</h1>
    
    <p><strong>Enlaces de prueba:</strong></p>
    <a href="/testdb?test=read">1. TEST READ</a>
    <a href="/testdb?test=insert">2. TEST INSERT</a>
    <a href="/testdb?test=update">3. TEST UPDATE</a>
    <a href="/testdb?test=delete">4. TEST DELETE</a>
    <a href="/testdb?test=all">🧪 TEST COMPLETO</a>
    
    <div class="missatge">
        <?= $missatge ?? '<p>Selecciona un test...</p>' ?>
    </div>
    
    <?php if (!empty($resultats)): ?>
        <h3>Resultats JSON:</h3>
        <pre><?= json_encode($resultats, JSON_PRETTY_PRINT) ?></pre>
    <?php endif; ?>
    
    <p style="margin-top: 30px;">
        <a href="/">← Tornar a l'inici</a>
    </p>
</body>
</html>