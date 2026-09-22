<?php
session_start();
require_once 'conexion.php';

if (isset($_SESSION['usuario_id'])) { header('Location: index.php'); exit; }

$mensaje = '';
if (($_GET['m'] ?? '') === 'login') {
    $mensaje = 'Debes iniciar sesión para poder publicar tus trabajos.';
}

$error = '';
$correo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if ($correo === '' || $contrasena === '') {
        $error = 'Ingresa tu correo electrónico y tu contraseña.';
    } else {
        $stmt = $conn->prepare('SELECT id, nombre, contrasena FROM usuarios WHERE correo = ?');
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $u = $stmt->get_result()->fetch_assoc();

        if ($u && password_verify($contrasena, $u['contrasena'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = (int) $u['id'];
            $_SESSION['usuario_nombre'] = $u['nombre'];
            header('Location: index.php');
            exit;
        }
        $error = 'Correo o contraseña incorrectos.';
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión - Biblonexa</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<header class="navbar">
    <div class="logo">📚 <h2>Biblonexa</h2></div>
    <nav><a href="index.php">Inicio</a><a href="materiales.php">Recursos</a></nav>
</header>
<main class="container">
    <div class="auth-container">
        <div class="auth-box">
            <h1 class="auth-title">Iniciar sesión</h1>
            <?php if ($mensaje): ?><div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
            <form class="upload-form" method="post" action="login.php">
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($correo) ?>" required autofocus>
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" required>
                <button class="btn-primary" type="submit">Entrar</button>
            </form>
            <p class="auth-links">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </div>
    </div>
</main>
<footer class="footer">© 2026 Biblonexa - Todos los derechos reservados.</footer>
</body>
</html>