<?php
session_start();
require_once 'conexion.php';

$buscar = trim($_GET['buscar'] ?? '');
$categoria = trim($_GET['categoria'] ?? '');

$sql = 'SELECT m.id, m.titulo, m.categoria, m.nombre_original, m.fecha_subida, u.nombre AS autor
        FROM materiales m
        LEFT JOIN usuarios u ON m.usuario_id = u.id
        WHERE 1=1';
$tipos = '';
$params = [];

if ($buscar !== '') {
    $sql .= ' AND m.titulo LIKE ?';
    $tipos .= 's';
    $params[] = '%' . $buscar . '%';
}
if ($categoria !== '') {
    $sql .= ' AND m.categoria LIKE ?';
    $tipos .= 's';
    $params[] = '%' . $categoria . '%';
}

$sql .= ' ORDER BY m.fecha_subida DESC';

$stmt = $conn->prepare($sql);
if ($tipos) { $stmt->bind_param($tipos, ...$params); }
$stmt->execute();
$resultado = $stmt->get_result();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Materiales - Biblonexa</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<header class="navbar">
    <div class="logo">📚 <h2>Biblonexa</h2></div>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="materiales.php">Recursos</a>
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <span class="user-name">👤 <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? '') ?></span>
            <a href="cerrar_sesion.php">Cerrar sesión</a>
        <?php else: ?>
            <a href="login.php">Iniciar sesión</a>
            <a href="registro.php" class="btn-nav">Registrarse</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
    <section class="hero-section">
        <h1>Materiales publicados</h1>
        <p>Recursos guardados en MySQL.</p>
    </section>

    <?php if (isset($_GET['mensaje'])): ?>
        <div class="alert alert-info"><?= htmlspecialchars($_GET['mensaje']) ?></div>
    <?php endif; ?>

    <div class="cards-grid">
        <?php while ($m = $resultado->fetch_assoc()): ?>
            <article class="card">
                <div class="card-header">
                    <span class="badge"><?= htmlspecialchars(strtoupper(pathinfo($m['nombre_original'], PATHINFO_EXTENSION))) ?></span>
                    <h4><?= htmlspecialchars($m['titulo']) ?></h4>
                </div>
                <p class="card-author"><?= htmlspecialchars($m['nombre_original']) ?></p>
                <p class="card-category"><?= htmlspecialchars($m['categoria']) ?></p>
                <p class="card-author"><?= $m['autor'] ? 'Subido por: ' . htmlspecialchars($m['autor']) : 'Subido por: Usuario' ?></p>
                <a class="btn-card" href="descargar.php?id=<?= (int) $m['id'] ?>">Descargar</a>
            </article>
        <?php endwhile; ?>
        <?php if ($resultado->num_rows === 0): ?>
            <p>No hay materiales.</p>
        <?php endif; ?>
    </div>
</main>
<footer class="footer">© 2026 Biblonexa - Todos los derechos reservados.</footer>
</body>
</html>
<?php $stmt->close(); $conn->close(); ?>