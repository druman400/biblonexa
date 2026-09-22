<?php
session_start();
$logueado = isset($_SESSION['usuario_id']);
$nombre = $_SESSION['usuario_nombre'] ?? '';
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblonexa</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<header class="navbar">
    <button id="themeToggle" type="button">🌙 Modo oscuro</button>
    <div class="logo">📚 <h2>Biblonexa</h2></div>
    <nav>
        <a href="#buscar">Buscar</a>
        <a href="materiales.php">Recursos</a>
        <?php if ($logueado): ?>
            <span class="user-name">👤 <?= htmlspecialchars($nombre) ?></span>
            <a href="cerrar_sesion.php">Cerrar sesión</a>
        <?php else: ?>
            <a href="login.php">Iniciar sesión</a>
            <a href="registro.php" class="btn-nav">Registrarse</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
    <section class="hero-section" id="buscar">
        <h1>Encuentra y comparte conocimiento</h1>
        <p>La red de intercambio de material académico para estudiantes.</p>
        <form class="search-box" action="materiales.php" method="get">
            <input name="buscar" placeholder="Buscar guías, libros, talleres...">
            <select name="categoria">
                <option value="">Todas las áreas</option>
                <option>Desarrollo de Software</option>
                <option>Matemáticas</option>
                <option>Sistemas</option>
                <option>Ciencias</option>
            </select>
            <button>Buscar</button>
        </form>
    </section>
    <div class="main-content">
        <section>
            <h3>Materiales Recientes</h3>
            <p>Consulta los materiales guardados en la base de datos.</p>
            <br>
            <a class="btn-primary" href="materiales.php">Ver materiales</a>
        </section>
        <aside class="upload-sidebar" id="subir">
            <h3>Publicar Recurso</h3>
            <?php if ($logueado): ?>
                <form class="upload-form" action="subir_material.php" method="post" enctype="multipart/form-data">
                    <label>Título</label>
                    <input name="titulo" maxlength="150" placeholder="Ej. Taller resuelto C++" required>
                    <label>Categoría</label>
                    <select name="categoria" required>
                        <option>Desarrollo de Software</option>
                        <option>Matemáticas</option>
                        <option>Sistemas</option>
                        <option>Ciencias</option>
                        <option>Otra área</option>
                    </select>
                    <label>Archivo</label>
                    <div class="file-dropzone">
                        <span>📄 Selecciona un archivo</span>
                        <input type="file" name="archivo" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt" required>
                    </div>
                    <button class="btn-primary" type="submit">Publicar Material</button>
                </form>
            <?php else: ?>
                <p class="card-author">Crea una cuenta o inicia sesión para subir tus trabajos.</p>
                <br>
                <a class="btn-primary" href="login.php">Iniciar sesión</a>
                <a class="btn-card" href="registro.php">Crear cuenta</a>
            <?php endif; ?>
        </aside>
    </div>
</main>
<footer class="footer">© 2026 Biblonexa - Todos los derechos reservados.</footer>
<script>
    const b = document.getElementById('themeToggle');
    b.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        b.textContent = document.body.classList.contains('dark-mode') ? '☀️ Modo claro' : '🌙 Modo oscuro';
    });
</script>
</body>
</html>