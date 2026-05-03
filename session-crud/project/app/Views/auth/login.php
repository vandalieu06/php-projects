<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (session()->get('error')): ?>
        <div style="color: red"><?= esc(session()->get('error')) ?></div>
    <?php endif; ?>
        <form method="POST" action="/login">
            <?= csrf_field() ?>
            <label>Username: <input type="text" name="username" required></label><br>
            <label>Password: <input type="password" name="password" required></label><br>
            <button type="submit">Login</button>
        </form>
</body>
</html>
