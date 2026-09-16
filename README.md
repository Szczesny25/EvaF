# VentasFix - Microservicio de Manejo de Carro de Compra

Backoffice + API para VentasFix, hecho en Laravel + Tailwind + MariaDB, con Atomic Design y autenticación JWT.

## Requisitos previos

- PHP 8.2 o superior
- Composer
- Node.js + npm
- MariaDB (o MySQL) corriendo

## Pasos para levantar el proyecto

1. **Clonar el repositorio**
   ```
   git clone https://github.com/Szczesny25/EvaF.git
   cd EvaF
   ```

2. **Instalar dependencias de PHP**
   ```
   composer install
   ```

3. **Copiar el archivo de entorno**
   ```
   cp .env.example .env        (Linux/Mac)
   copy .env.example .env      (Windows)
   ```

4. **Generar la llave de la aplicación**
   ```
   php artisan key:generate
   ```

5. **Configurar la base de datos en el `.env`**

   Crea una base de datos vacía en MariaDB (ej. `db_evaf`) y completa estas variables:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_evaf
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_clave
   ```

6. **Correr las migraciones**
   ```
   php artisan migrate
   ```

7. **Crear un usuario de prueba** (necesario para poder loguearse, ya que no hay usuarios por defecto)
   ```
   php artisan db:seed --class=UsuarioSeeder
   ```
   Esto crea el usuario:
   - Correo: `admin@ventasfix.cl`
   - Contraseña: `Admin123`

   *(También puedes crear una cuenta nueva desde `/registro` una vez el sistema esté corriendo.)*

8. **Enlazar el storage** (para que se vean las imágenes de productos)
   ```
   php artisan storage:link
   ```

9. **Instalar dependencias de frontend y compilar Tailwind**
   ```
   npm install
   npm run build
   ```

10. **Instalar y generar la documentación de Swagger**
    ```
    composer require darkaonline/l5-swagger
    php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
    php artisan l5-swagger:generate
    ```

11. **Levantar el servidor**
    ```
    php artisan serve
    ```

## Accesos

| Recurso | URL |
|---|---|
| Backoffice (login) | http://127.0.0.1:8000/login |
| Documentación Swagger (API) | http://127.0.0.1:8000/api/documentation |

## Flujo de la API

1. Autenticarse en `POST /api/login` con `correo` y `contraseña` → devuelve un token JWT.
2. Usar ese token en el header `Authorization: Bearer {token}` para el resto de los endpoints (`/api/usuarios`, `/api/productos`, `/api/clientes`).
3. En Swagger, esto se hace con el botón **Authorize** (arriba a la derecha), pegando el token ahí.

## Estructura del proyecto (Atomic Design)

```
resources/views/
├── layouts/          → app.blade.php (backoffice), invitado.blade.php (login/registro)
├── components/
│   ├── atoms/        → boton, input, label, select
│   ├── molecules/    → campo-formulario, campo-select
│   └── organisms/    → sidebar
├── auth/             → login, registro
├── usuarios/         → index, crear, editar
├── productos/        → index, crear, editar
├── clientes/         → index, crear, editar
└── dashboard.blade.php
```

## Módulos implementados

- ✅ CRUD de Usuarios (con registro público y cifrado de contraseña)
- ✅ CRUD de Productos (con cálculo automático de precio con IVA e imagen)
- ✅ CRUD de Clientes
- ✅ Dashboard con conteo de usuarios/productos/clientes
- ✅ Autenticación JWT (backoffice vía sesión, API vía Bearer token)
- ✅ API REST documentada con Swagger

## Problemas comunes

- **Error de conexión a la base de datos:** revisa que las credenciales del `.env` coincidan con un usuario real creado en MariaDB.
- **Las imágenes de productos no se ven:** asegúrate de haber corrido `php artisan storage:link`.
- **Swagger no muestra los endpoints:** corre `php artisan l5-swagger:generate` de nuevo después de cualquier cambio en las anotaciones.

---
Desarrollado por Andre — Instituto Profesional San Sebastián.