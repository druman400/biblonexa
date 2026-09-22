<?php
session_start();
require_once 'conexion.php';

if (isset($_SESSION['usuario_id'])) { header('Location: index.php'); exit; }

$error = '';
$nombre = '';
$correo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if ($nombre === '' || $correo === '' || $contrasena === '' || $confirmar === '') {
        $error = 'Todos los campos son obligatorios.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo electrónico no es válido.';
    } elseif (strlen($contrasena) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres.';
    } elseif ($contrasena !== $confirmar) {
        $error = 'Las contraseñas no coinciden.';
    } elseif (strlen($nombre) > 100) {
        $error = 'El nombre es demasiado largo.';
    } else {
        $stmt = $conn->prepare('SELECT id FROM usuarios WHERE correo = ?');
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = 'Ya existe una cuenta con ese correo. Prueba a iniciar sesión.';
        } else {
            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)');
            $stmt->bind_param('sss', $nombre, $correo, $hash);
            if ($stmt->execute()) {
                session_regenerate_id(true);
                $_SESSION['usuario_id'] = (int) $conn->insert_id;
                $_SESSION['usuario_nombre'] = $nombre;
                header('Location: index.php');
                exit;
            }
            $error = 'Ocurrió un error al registrarte. Inténtalo de nuevo.';
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrarse - Biblonexa</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<header class="navbar">
    <div class="logo">📚 <h2>Biblonexa</h2></div>
    <nav><a href="index.php">Inicio</a><a href="materiales.php">Recursos</a><a href="login.php">Iniciar sesión</a></nav>
</header>
<main class="container">
    <div class="auth-container">
        <div class="auth-box">
            <h1 class="auth-title">Crear cuenta</h1>
            <p class="card-author">Regístrate para poder publicar y compartir tus trabajos.</p>
            <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
            <form class="upload-form" method="post" action="registro.php">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" maxlength="100" required autofocus>
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($correo) ?>" required>
                <label for="contrasena">Contraseña (mínimo 6 caracteres)</label>
                <input type="password" id="contrasena" name="contrasena" minlength="6" required>
                <label for="confirmar">Confirmar contraseña</label>
                <input type="password" id="confirmar" name="confirmar" minlength="6" required>
                <button class="btn-primary" type="submit">Crear cuenta</button>
            </form>
            <p class="auth-links">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
    </div>
</main>
<footer class="footer">© 2026 Biblonexa - Todos los derechos reservados.</footer>
</body>
</html>