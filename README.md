# InnovaCrown

## Versión

*v1.0*

---

# Descripción

InnovaCrown es un sistema web diseñado para la gestión y administración de un hotel, cuyo propósito es facilitar el control de clientes, habitaciones y reservaciones mediante una plataforma centralizada.

Esta versión (v1.0) representa la primera entrega funcional del proyecto. Aunque ya cuenta con la estructura principal del sistema y la integración de diversos componentes, el desarrollo continúa y en futuras versiones se incorporarán nuevas funcionalidades, mejoras de rendimiento y optimizaciones generales.

---

# Objetivo General

Desarrollar un sistema web que permita administrar de manera eficiente la información del hotel, optimizando los procesos administrativos y mejorando el control de las operaciones.

---

# Objetivos Específicos

- Administrar la información de los clientes.
- Gestionar las habitaciones del hotel.
- Registrar y administrar reservaciones.
- Implementar una API para la comunicación entre componentes.
- Integrar Web Services para el intercambio de información.
- Aplicar mecanismos básicos de seguridad.
- Mantener una estructura organizada y escalable para futuras versiones.

---

# Características

- Sistema web.
- Arquitectura organizada por módulos.
- API integrada.
- Web Services implementados.
- Base de datos relacional.
- Gestión de usuarios.
- Gestión de clientes.
- Gestión de habitaciones.
- Gestión de reservaciones.
- Diseño pensado para facilitar futuras ampliaciones.

---

# Tecnologías utilizadas

- HTML5
- CSS3
- JavaScript
- Bootstrap
- PHP
- Laravel 12
- MySQL
- API REST
- Web Services
- Git
- GitHub

---

# Requisitos

- PHP 8.0 o superior
- MySQL
- Composer
- Apache (XAMPP, WAMP o Laragon)
- Navegador web actualizado

---

# Instalación

## Clonar el repositorio

```bash
git clone https://github.com/brenivargas09-sys/InnovaCrowmn.git
```

## Acceder al proyecto

```bash
cd InnovaCrowmn
```

## Instalar dependencias

```bash
composer install
```

## Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

## Configurar la base de datos

- Crear una base de datos en MySQL llamada `innovacrown`.
- Configurar las credenciales de conexión en el archivo `.env`.

## Ejecutar migraciones y datos de prueba

```bash
php artisan migrate
php artisan db:seed
```

## Iniciar el servidor

```bash
php artisan serve
```

Abrir en el navegador: `http://localhost:8000`

Si se utiliza XAMPP, acceder directamente a: `http://localhost/InnovaCrown/public/`

---

# Estructura del proyecto

```
InnovaCrowmn/
├── app/
│   ├── Http/Controllers/    # Controladores
│   ├── Http/Middleware/      # Middleware de seguridad
│   ├── Models/              # Modelos Eloquent
│   └── Services/            # Servicios externos
├── bootstrap/
├── config/
├── database/
│   ├── migrations/          # Migraciones de la BD
│   └── seeders/             # Seeders de datos iniciales
├── public/                  # Archivos públicos
├── resources/
│   └── views/
│       ├── auth/            # Vistas de login y registro
│       ├── panel/           # Vistas del panel administrativo
│       ├── layouts/         # Layout principal
│       └── welcome.blade.php
├── routes/
│   └── web.php              # Rutas de la aplicación
├── .env.example
└── README.md
```

---

# Estado del proyecto

## Versión actual

*v1.0*

El proyecto se encuentra en su primera versión funcional.

Actualmente dispone de la estructura principal del sistema, integración de la API, Web Services y mecanismos básicos de seguridad.

Algunos módulos administrativos aún se encuentran en desarrollo y serán completados en futuras versiones.

---

# Próximas versiones

Entre las mejoras planificadas se encuentran:

- Finalización de los módulos administrativos.
- Implementación completa de todas las funcionalidades de gestión.
- Optimización del rendimiento.
- Mejoras en la interfaz de usuario.
- Sistema de recuperación de contraseña.
- Nuevos reportes administrativos.
- Validaciones adicionales.
- Mejoras de seguridad.
- Corrección de errores encontrados durante las pruebas.
- Optimización del código.
- Incorporación de nuevas funcionalidades según los requerimientos del hotel.

---

# Contribuciones

Este proyecto continúa en desarrollo. Las futuras versiones estarán enfocadas en mejorar la funcionalidad, seguridad, estabilidad y experiencia de usuario.

---

# Autores

- Breni Elizabeth Vargas
- Flor de Guadalupe Cruz
- Ruth Elizabeth Jiménez

Ingeniería en Desarrollo y Gestión de Software.

Universidad Tecnológica de la Selva.

---

# Licencia

Proyecto desarrollado con fines académicos.

Todos los derechos reservados 2026.
