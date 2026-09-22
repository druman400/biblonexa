# 📚 Biblonexa

Plataforma web de intercambio de material académico para estudiantes. Permite **registrarse, iniciar sesión, publicar, buscar y descargar** recursos educativos (PDF, Word, PowerPoint, Excel, texto) organizados por categorías.

## ✨ Funcionalidades

- 👤 Registro e inicio de sesión de usuarios (correo + contraseña, contraseñas cifradas con `password_hash`)
- 🚀 Solo los usuarios registrados pueden subir materiales (con validación de tipo y tamaño, máx. 10 MB)
- 🔍 Búsqueda por título y filtro por categoría
- ⬇️ Descarga de archivos desde la base de datos
- 🌙 Modo claro / oscuro
- 📱 Diseño responsivo

## 👥 Cuentas de usuario

| Archivo               | Función                                        |
|-----------------------|------------------------------------------------|
| `registro.php`        | Crear cuenta (nombre, correo, contraseña)      |
| `login.php`           | Iniciar sesión con correo y contraseña         |
| `cerrar_sesion.php`   | Cerrar sesión                                  |
| `subir_material.php`  | Solo accesible con sesión iniciada             |

Cada material publicado queda vinculado al usuario en la tabla `materiales.usuario_id`, y su nombre se muestra en la lista de recursos.

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
│   └── estilo.css          # Estilos del sitio (incluye login/registro)
├── uploads/                # Archivos subidos por los usuarios
├── cerrar_sesion.php       # Cierra la sesión del usuario
├── conexion.example.php    # Plantilla de conexión a MySQL
├── database.sql            # Esquema de la base de datos
├── descargar.php           # Descarga segura de archivos
├── index.php               # Página principal
├── index.html              # Prototipo estático (versión anterior)
├── login.php               # Inicio de sesión de usuarios
├── materiales.php          # Lista, búsqueda y filtrado de materiales
├── registro.php            # Registro de nuevos usuarios
└── subir_material.php      # Subida de materiales (requiere sesión)
```

## 🔐 Notas de seguridad

- `conexion.php` (con tus credenciales reales) **no se sube a GitHub**; usa `conexion.example.php` como plantilla.
- Las contraseñas se guardan cifradas con `password_hash()` / `password_verify()`.
- Los archivos subidos se guardan en `uploads/` con nombres aleatorios y se ignoran en Git.

## 📄 Licencia

Proyecto educativo de uso libre.