# Login

Proyecto de autenticación en PHP.

## Requisitos

- PHP
- Composer

## Instalación

1. Instala las dependencias del proyecto con Composer (incluye **phpEmailer** y la carpeta `vendor`):

   ```bash
   composer install
   ```

2. Configura el archivo `.env` en la raíz del proyecto (mejor que esté en la raíz, no en subdirectorios):

   ```env
   DB_HOST=localhost
   DB_NAME=your_nameBD
   DB_USER=your_nameuser
   DB_PASS=your_password
   MAIL_HOST=smtp.example.com
   MAIL_USER=your_email@example.com
   MAIL_PASS=your_password
   MAIL_PORT=465
   MAIL_SECURE=ssl
   APP_URL=http://localhost:8080/antasturlogin
   ```

## Base de Datos

Crea las siguientes tablas en tu base de datos MySQL:

```sql
-- Tabla de usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    reset_token VARCHAR(255) DEFAULT NULL,
    reset_token_expirity DATETIME DEFAULT NULL
);

-- Tabla para bloqueo temporal tras varios intentos fallidos de login
CREATE TABLE failed_logins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    failed_at DATETIME NOT NULL
);
```

## Notas

- El archivo `.env` debe estar en la raíz del proyecto para su correcto funcionamiento.
- Recuerda instalar **phpEmailer** mediante Composer o incluirlo en tu archivo `composer.json`.

## Licencia

[MIT](LICENSE) (modifica esto según corresponda a tu proyecto)
