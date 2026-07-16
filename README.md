# InnovaCrown - Sistema de Gestión Hotelera

Sistema completo de gestión hotelera con página pública de presentación y panel administrativo modular. Desarrollado como proyecto académico con estándares industriales.

## Demo

- **URL:** `http://localhost/InnovaCrown/public/`

## Tecnologías Utilizadas

| Componente | Tecnología |
|---|---|
| Backend | PHP 8.2+ / Laravel 12 |
| Frontend | HTML5 / CSS3 / Bootstrap 5.3.3 |
| Base de datos | MySQL 8.x |
| API Externa | OpenWeather API (clima en tiempo real) |
| Servidor local | XAMPP (Apache + MySQL) |
| Fuentes | Google Fonts (Playfair Display + Inter) |
| Iconos | Bootstrap Icons 1.11.3 |

## Funcionalidades

### Página Pública (Welcome)
- Hero fullscreen con imagen de fondo y parallax
- Sección de servicios, habitaciones y galería
- Promociones activas
- Widget de clima en tiempo real (OpenWeather API)
- Información del hotel y contacto con mapa
- Preloader animado con barra de progreso
- Scroll reveal y contadores animados
- Diseño responsive (mobile-first)

### Panel de Administración
- **Dashboard** con estadísticas generales y widget de clima
- **Gestión de Usuarios** - CRUD completo (crear, leer, actualizar, eliminar) con búsqueda y filtros por rol
- **Gestión de Clientes** - CRUD completo con búsqueda por nombre, documento, teléfono
- **Gestión de Habitaciones** - CRUD completo con búsqueda, filtros por estado, piso y tipo
- **Tipos de Habitación** - CRUD con búsqueda y vista detallada
- **Reservaciones** - CRUD completo con búsqueda y filtro por estado
- **Pagos** - CRUD completo con búsqueda y filtro por método de pago
- **Servicios** - CRUD completo con búsqueda
- **Panel de Configuración** - Gestión de hero, información, galería, promociones
- **Reportes** - Reportes de habitaciones, ingresos y reservaciones
- **Check-in / Check-out** - Control de entrada y salida de huéspedes
- **Historial** - Registro de actividad del sistema

### Roles de Usuario
| Rol | Acceso |
|---|---|
| Admin | Panel completo + Configuración + Usuarios + Clima |
| Recepcionista | Habitaciones, Clientes, Reservaciones, Pagos, Servicios, Check-in/out, Reportes |
| Cliente | Dashboard personal + Mis Reservaciones |

## Usuarios de Prueba

| Usuario | Contraseña | Rol |
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

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/TU_USUARIO/InnovaCrown.git
cd InnovaCrown
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

Esto creará las tablas y los usuarios de prueba mencionados arriba.

### 6. Crear enlace de almacenamiento

```bash
php artisan storage:link
```

### 7. Iniciar el servidor

```bash
php artisan serve
```

El sistema estará disponible en: `http://localhost:8000`

Si usa XAMPP, puede acceder directamente en: `http://localhost/InnovaCrown/public/`

## API del Clima (OpenWeather)

El sistema integra la API de OpenWeather para mostrar el clima en tiempo real de la ubicación del hotel.

1. Obtener una API Key gratuita en [https://openweathermap.org/api](https://openweathermap.org/api)
2. Agregar la clave en el archivo `.env`:
   ```
   OPENWEATHER_API_KEY=tu_api_key_aqui
   ```
3. Configurar la ubicación del hotel en Panel de Administración > Clima

La información del clima se actualiza automáticamente cada 30 minutos.

## Estructura del Proyecto

```
InnovaCrown/
├── app/
│   ├── Http/Controllers/    # Controladores (Auth, Admin, Panel, API)
│   ├── Models/              # Modelos Eloquent
│   └── Services/            # Servicios (WeatherService)
├── database/
│   ├── migrations/          # Migraciones de la base de datos
│   └── seeders/             # Seeders de datos iniciales
├── public/                  # Archivos públicos
├── resources/
│   └── views/
│       ├── auth/            # Vistas de login y registro
│       ├── panel/           # Vistas del panel administrativo
│       ├── layouts/         # Layout principal del panel
│       └── welcome.blade.php # Página pública
├── routes/
│   └── web.php              # Rutas de la aplicación
└── .env.example             # Plantilla de configuración
```

## Seguridad

- Autenticación con hash de contraseñas (bcrypt)
- Protección CSRF en formularios
- Rate limiting en intentos de login (5 intentos / 15 minutos)
- Middleware de autorización por rol en todas las rutas
- Sanitización de entradas y prevención de inyección SQL
- Sesiones seguras con regeneración de tokens

## Licencia

Proyecto académico - InnovaCrown Hotel & Resort
