# 📝 RESUMEN DE LA APLICACION WEB

## 📋 DATOS GENERALES

<ul>
    <li><b>Cliente:</b> ✅ Constructora Erazo Brother's</li>
    <li><b>Estado:</b> 🚧 En desarrollo</li>
    <li><b>Version:</b> 🚀 1.0.0</li>
    <li><b>Nombre:</b> 😎 Constructora Erazo Brother's</li>
</ul>

## 📋 DESCRIPCION

<p>
    Esta es una pagina web para la constructora Erazo Brother's, la cual se encarga de la construccion de casas y edificios en USA.
    <br><br>
    Esta desarrollada bajo las tecnologias web principales: <b>HTML5, CSS3, JS, PHP, MYSQL</b>
    <br><br>
    El lenguaje de programacion principal es <b>PHP</b> y el gestor de base de datos es <b>MYSQL</b>
    <br><br>
</p>

## 📝 LICENCIA

<p>
    Este proyecto es de código abierto, ¡lo que significa que es completamente libre! 🙌 Puedes usarlo, copiarlo, modificarlo y distribuirlo como desees para tus propios proyectos sin ningún tipo de restricciones. 🚀
    <br><br>
    Nos encanta la idea de que más personas puedan utilizar y mejorar nuestra pagina web y esperamos que lo disfrutes. 🤓
    <br><br>
    ¡Gracias por visitarnos y disfruta del código! 😎
    <br><br>
</p>

# 📦 DOCUMENTACION DE INSTALACION

## ⚙️ INSTALACION AUTOMATICA CON .PS1

<!-- Ejecutalo con powershell
<a href="./src/assets/install_win.rar">Descargar archivo 📥</a> -->

## 📄 VARIABLES DE ENTORNO

Crea el archivo <b><i>.env</i></b> en la raiz del proyecto y configuralo

```env
    # PROJECT
    HTTP_DOMAIN = http://localhost/constructora/
    HTML_LANG = 'en'
    APP_NAME = 'erazobrothers'
    APP_STATE = 'development'
    APP_ACCESS_TOKEN = {{CREATE YOUR PERSONAL ACCESS TOKEN}}

    # MYSQLI
    DB_HOST =
    DB_USER =
    DB_PASS =
    DB_NAME =
    DB_PORT =
```

## 🐬 MYSQL

Crea la base de datos

```sql
  CREATE DATABASE {{YOUR_DB_NAME}};
```

-   Asegurate de que el nombre de la base de datos sea el mismo que el que usas en el archivo .env
-   Si estas en CPANEL tendras que crearla con ayuda de la interfaz grafica.

### 🛠 CONFIGURACION

Luego puedes usar el servicio de configuración para crear las tablas y los datos inciales:

```http
  {{YOUR_DOMAIN}}/service/configuration
```

para generar la base de datos y las tablas.
Luego es importante que desabilites el servicio de configuración para que no se sobreescriban los datos.

## 🪶 APACHE

Crea el archivo <b><i>.htaccess</i></b> en la raiz del proyecto y configuralo

```htaccess
  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule . index.php [L]

  # Denegar el acceso a los directorios
  Options -Indexes

  <FilesMatch "\.(php|html?)$">
    Order Deny,Allow
    Deny from all
  </FilesMatch>
  <Files "index.php">
    Order Allow,Deny
    Allow from all
  </Files>
```

#### 🛠 En caso de que tu proyecto ya este funcionando con un dominio y quieras usar _https_, puedes agregar esta configuracion en _htaccess_

```htaccess
  RewriteEngine On
  RewriteCond %{HTTPS} !=on
  RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301,NE]
  Header always set Content-Security-Policy "upgrade-insecure-requests;"
```

## 🚪 LOGIN

Para abrir el login puedes presionar la combinacion de teclas " <b><i>CTRL + .</i></b> " o puedes ir a la siguiente ruta

```http
  {{YOUR_DOMAIN}}/panel/login
```

Para iniciar sesion por primera vez usa los siguientes credenciales

```txt
  - USUARIO: admin
  - CONTRASEÑA: admin
```
