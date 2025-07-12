# ESCALIF
Un proyecto universitario que crei para simular una plataforma de gestión académica. Básicamente, te permite administrar estudiantes y profesores, ayudando a los maestros a asignar calificaciones de forma sencilla y a los alumnos a consultar sus resultados en un mismo lugar.

Sitio Web: https://escalif.rf.gd/
Si te envia a otra pagina, nada mas reinicia la pagina otra vez (es un hosting gratis :D)

## Requisitos Previos
Antes de comenzar, asegúrate de tener instalado lo siguiente en tu sistema:

- PHP: Versión 8.1 o superior (verifica con php -v)
- Composer: Gestor de paquetes de PHP (verifica con composer -v)
- Node.js: Para dependencias de frontend (verifica con node -v)
- Git: Sistema de control de versiones (verifica con git --version)
- Servidor de Base de Datos: MySQL (recomendado), PostgreSQL, SQLite, etc. (asegúrate de que esté en ejecución)

## Clonar el Repositorio
Abre tu terminal o línea de comandos y ejecuta el siguiente comando para clonar el repositorio:
```
git clone https://github.com/Chukroid/escalif.git
```

Navega al directorio del proyecto:
```
cd escalif
```

## Configuración del Proyecto
Instalar Dependencias de PHP
Instala todas las dependencias de PHP requeridas por Laravel usando Composer:
```
composer install
```

Configurar el Archivo .env
Laravel utiliza un archivo .env para la configuración del entorno. Crea una copia del archivo de ejemplo:
```
cp .env.example .env
```

Ahora, abre el archivo .env recién creado en tu editor de texto y actualiza las siguientes variables:

- APP_NAME: El nombre de tu aplicación.

- APP_URL: La URL de tu aplicación local (normalmente http://localhost o la URL de tu entorno de desarrollo local).

- DB_CONNECTION: La base de datos que estas usando (e.g., mysql)

- DB_DATABASE: El nombre de tu base de datos (e.g., escalif_db).

- DB_USERNAME: Tu nombre de usuario de la base de datos (e.g., root).

- DB_PASSWORD: Tu contraseña de la base de datos.


Generar la Clave de la Aplicación
Genera una clave de aplicación única. Esto es crucial para la seguridad de Laravel:
```
php artisan key:generate
```

Configurar la Base de Datos
Crea una base de datos vacía en tu servidor de base de datos (e.g., MySQL Workbench, phpMyAdmin, o línea de comandos). Asegúrate de que el nombre de la base de datos, el usuario y la contraseña coincidan con los que configuraste en tu archivo .env.

Ejecuta las migraciones de la base de datos para crear las tablas de la aplicación:
```
php artisan migrate
```

Ejecutar este commando para generar datos de prueba o seeders:
```
php artisan db:seed
```

Instalar Dependencias de Node.js
Instala las dependencias de frontend usando npm o Yarn:
```
npm install
```

Compilar Activos Frontend
Para el desarrollo, inicia el servidor de desarrollo de Vite. Esto compilará tus CSS y JS y los servirá en caliente:
```
npm run dev
```

## Ejecutar la Aplicación
Una vez que todos los pasos anteriores se hayan completado, puedes iniciar el servidor de desarrollo de Laravel:
```
php artisan serve
```

Tu aplicación debería estar accesible en http://127.0.0.1:8000 (o la URL que configuraste en APP_URL si usas un host virtual).

## Como inicar
Ahora, si no proporcionaste una cuenta para admin, tu correo y contraseña por default sera superadmin@default.com y contraseña sera password