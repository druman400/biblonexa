<?php
require_once 'conexion.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
$titulo=trim($_POST['titulo']??''); $categoria=trim($_POST['categoria']??'');
if (!$titulo || !$categoria || !isset($_FILES['archivo'])) die('Faltan datos.');
$f=$_FILES['archivo']; if ($f['error']!==UPLOAD_ERR_OK) die('Error al subir archivo.');
if ($f['size']>10*1024*1024) die('Máximo 10 MB.');
$permitidos=['pdf'=>'application/pdf','doc'=>'application/msword','docx'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document','ppt'=>'application/vnd.ms-powerpoint','pptx'=>'application/vnd.openxmlformats-officedocument.presentationml.presentation','xls'=>'application/vnd.ms-excel','xlsx'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','txt'=>'text/plain'];
$original=basename($f['name']); $ext=strtolower(pathinfo($original,PATHINFO_EXTENSION));
if (!isset($permitidos[$ext])) die('Tipo de archivo no permitido.');
$mime=(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']); if ($mime!==$permitidos[$ext]) die('Tipo de archivo inválido.');
$nombre=bin2hex(random_bytes(16)).'.'.$ext; $ruta='uploads/'.$nombre; $fisica=__DIR__.'/uploads/'.$nombre;
if (!move_uploaded_file($f['tmp_name'],$fisica)) die('No se pudo guardar el archivo.');
$stmt=$conn->prepare('INSERT INTO materiales (titulo,categoria,nombre_original,nombre_archivo,ruta_archivo) VALUES (?,?,?,?,?)');
$stmt->bind_param('sssss',$titulo,$categoria,$original,$nombre,$ruta);
if(!$stmt->execute()){unlink($fisica);die('Error MySQL: '.$stmt->error);}
header('Location: materiales.php?mensaje=Material+publicado+correctamente'); exit;
?>
