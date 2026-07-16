# InnovaCrown - Sistema de Gestion Hotelera v1.0

Sistema web de gestion hotelera con pagina publica de presentacion y panel administrativo. Proyecto en desarrollo continuo, esta version 1.0 incluye la estructura base y funcionalidades principales.

## Version actual: 1.0

**Fecha:** Julio 2026

Esta primera version incluye:
- Pagina publica del hotel con diseno responsive
- Panel administrativo con gestion basica de modulos
- Integracion con API de OpenWeather para clima en tiempo real
- Sistema de autenticacion con 3 roles de usuario

### Funcionalidades planificadas para versiones futuras
- Modulo de facturacion electronica
- Integracion con pasarelas de pago
- Sistema de notificaciones por correo y SMS
- App movil para clientes
- Reportes avanzados con exportacion a PDF y Excel
- Modulo de mantenimiento preventivo de habitaciones

## Tecnologias Utilizadas

| Componente | Tecnologia |
|---|---|
| Backend | PHP 8.2+ / Laravel 12 |
| Frontend | HTML5 / CSS3 / Bootstrap 5.3.3 |
| Base de datos | MySQL 8.x |
| API Externa | OpenWeather API (clima en tiempo real) |
| Servidor local | XAMPP (Apache + MySQL) |
| Fuentes | Google Fonts (Playfair Display + Inter) |
| Iconos | Bootstrap Icons 1.11.3 |

## Funcionalidades de la version 1.0

### Pagina Publica
- Hero con imagen de fondo y efecto parallax
- Seccion de servicios y habitaciones del hotel
- Galeria de imagenes
- Promociones activas
- Widget de clima en tiempo real (OpenWeather API)
- Informacion del hotel y contacto
- Diseno responsive

### Panel de Administracion
- Dashboard con estadisticas generales y widget de clima
- Gestion de Usuarios (CRUD) con busqueda y filtros
- Gestion de Clientes (CRUD) con busqueda
- Gestion de Habitaciones (CRUD) con busqueda y filtros por estado, piso y tipo
- Gestion de Tipos de Habitacion (CRUD) con busqueda
- Gestion de Reservaciones (CRUD) con busqueda y filtro por estado
- Gestion de Pagos (CRUD) con busqueda y filtro por metodo
- Gestion de Servicios (CRUD) con busqueda
- Panel de configuracion (hero, informacion, galeria, promociones)
- Reportes basicos de habitaciones, ingresos y reservaciones
- Check-in / Check-out de huéspedes
- Historial de actividad

### Roles de Usuario
| Rol | Acceso |
|---|---|
| Admin | Panel completo + Configuracion + Usuarios + Clima |
| Recepcionista | Habitaciones, Clientes, Reservaciones, Pagos, Servicios, Check-in/out, Reportes |
| Cliente | Dashboard personal + Mis Reservaciones |

## Usuarios de Prueba

| Usuario | Contrasena | Rol |
|---|---|---|
| admin@innovacrown.com | password | Administrador |
| recepcion@innovacrown.com | password | Recepcionista |
| cliente1@email.com | password | Cliente |
| cliente2@email.com | password | Cliente |

## Requisitos

- PHP 8.2 o superior
- MySQL 8.x
- Composer
- XAMPP (o cualquier servidor Apache + MySQL)
- Habilitar extensiones PHP: `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `curl`, `gd`

## Instalacion

### 1. Clonar el repositorio

```bash
git clone https://github.com/brenivargas09-sys/InnovaCrowmn.git
cd InnovaCrowmn
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Editar el archivo `.env` con los datos de tu base de datos:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=innovacrown
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Crear la base de datos

Abrir phpMyAdmin y crear una base de datos llamada `innovacrown` con cotejamiento `utf8mb4_unicode_ci`.

### 5. Ejecutar migraciones y seeders

```bash
php artisan migrate
php artisan db:seed
```

Esto creara las tablas y los usuarios de prueba.

### 6. Crear enlace de almacenamiento

```bash
php artisan storage:link
```

### 7. Iniciar el servidor

```bash
php artisan serve
```

El sistema estara disponible en: `http://localhost:8000`

Si usa XAMPP, acceda directamente en: `http://localhost/InnovaCrown/public/`

## API del Clima (OpenWeather)

Esta version integra la API de OpenWeather para mostrar el clima en tiempo real.

1. Obtener una API Key gratuita en [https://openweathermap.org/api](https://openweathermap.org/api)
2. Agregar la clave en el archivo `.env`:
   ```
   OPENWEATHER_API_KEY=tu_api_key_aqui
   ```
3. Configurar la ubicacion del hotel en Panel de Administracion > Clima

La informacion del clima se actualiza cada 30 minutos.

## Estructura del Proyecto

```
InnovaCrowmn/
├── app/
│   ├── Http/Controllers/    # Controladores
│   ├── Models/              # Modelos Eloquent
│   └── Services/            # Servicios
├── database/
│   ├── migrations/          # Migraciones de la BD
│   └── seeders/             # Seeders de datos iniciales
├── public/                  # Archivos publicos
├── resources/
│   └── views/
│       ├── auth/            # Vistas de login y registro
│       ├── panel/           # Vistas del panel administrativo
│       ├── layouts/         # Layout principal
│       └── welcome.blade.php
├── routes/
│   └── web.php              # Rutas de la aplicacion
└── .env.example             # Plantilla de configuracion
```

## Seguridad implementada en v1.0

- Autenticacion con hash de contrasenas (bcrypt)
- Proteccion CSRF en formularios
- Rate limiting en intentos de login
- Middleware de autorizacion por rol
- Sanitizacion de entradas

## Proximo desarrollo (v2.0)

- [ ] Facturacion electronica
- [ ] Pasarela de pagos en linea
- [ ] Notificaciones por correo
- [ ] Reportes con exportacion a PDF
- [ ] App movil para clientes
- [ ] Mantenimiento preventivo de habitaciones

## Licencia

Proyecto academico - InnovaCrown Hotel & Resort
