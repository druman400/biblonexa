# 📚 Biblonexa

Plataforma web de intercambio de material académico para estudiantes. Permite **publicar, buscar y descargar** recursos educativos (PDF, Word, PowerPoint, Excel, texto) organizados por categorías.

## ✨ Funcionalidades

- 🚀 Subir materiales con validación de tipo de archivo y tamaño (máx. 10 MB)
- 🔍 Búsqueda por título y filtro por categoría
- ⬇️ Descarga de archivos desde la base de datos
- 🌙 Modo claro / oscuro
- 📱 Diseño responsivo

## 🛠️ Requisitos

- [XAMPP](https://www.apachefriends.org/) (Apache + PHP 7.4+ + MySQL)
- Navegador web moderno

## 🚀 Instalación

1. Clona o descarga el proyecto en `htdocs/biblonexa/` dentro de tu XAMPP:

   ```bash
   git clone https://github.com/druman400/biblonexa.git
   ```

2. Copia el archivo de conexión de ejemplo y ajusta tus credenciales si es necesario:

   ```bash
   cp conexion.example.php conexion.php
   ```

   > Por defecto usa `localhost`, usuario `root`, sin contraseña, y base de datos `biblonexa` (configuración estándar de XAMPP).

3. Importa la base de datos:

   - Abre [phpMyAdmin](http://localhost/phpmyadmin)
   - Importa el archivo `database.sql` (crea la base `biblonexa` y las tablas `usuarios` y `materiales`)

4. Inicia Apache y MySQL en el panel de XAMPP y visita:

   ```
   http://localhost/biblonexa/
   ```

## 📁 Estructura del proyecto

```
biblonexa/
├── css/
│   └── estilo.css          # Estilos del sitio
├── uploads/                # Archivos subidos por los usuarios
├── conexion.example.php    # Plantilla de conexión a MySQL
├── database.sql            # Esquema de la base de datos
├── descargar.php           # Descarga segura de archivos
├── index.php               # Página principal
├── index.html              # Prototipo estático (versión anterior)
├── materiales.php          # Lista y búsqueda de materiales
└── subir_material.php      # Procesa la subida de archivos
```

## 🔐 Notas de seguridad

- `conexion.php` (con tus credenciales reales) **no se sube a GitHub**; usa `conexion.example.php` como plantilla.
- Los materiales subidos por usuarios se guardan en `uploads/` y se ignoran en Git.

## 📄 Licencia

Proyecto educativo de uso libre.