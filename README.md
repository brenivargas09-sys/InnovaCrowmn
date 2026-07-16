# InnovaCrown

## Version

*v1.0*

---

# Descripcion

InnovaCrown es un sistema web disenado para la gestion y administracion de un hotel, cuyo proposito es facilitar el control de clientes, habitaciones y reservaciones mediante una plataforma centralizada.

Esta version (v1.0) representa la primera entrega funcional del proyecto. Aunque ya cuenta con la estructura principal del sistema y la integracion de diversos componentes, el desarrollo continua y en futuras versiones se incorporaran nuevas funcionalidades, mejoras de rendimiento y optimizaciones generales.

---

# Objetivo General

Desarrollar un sistema web que permita administrar de manera eficiente la informacion del hotel, optimizando los procesos administrativos y mejorando el control de las operaciones.

---

# Objetivos Especificos

- Administrar la informacion de los clientes.
- Gestionar las habitaciones del hotel.
- Registrar y administrar reservaciones.
- Implementar una API para la comunicacion entre componentes.
- Integrar Web Services para el intercambio de informacion.
- Aplicar mecanismos basicos de seguridad.
- Mantener una estructura organizada y escalable para futuras versiones.

---

# Caracteristicas

- Sistema web.
- Arquitectura organizada por modulos.
- API integrada.
- Web Services implementados.
- Base de datos relacional.
- Gestion de usuarios.
- Gestion de clientes.
- Gestion de habitaciones.
- Gestion de reservaciones.
- Diseno pensado para facilitar futuras ampliaciones.

---

# Tecnologias utilizadas

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

# Instalacion

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
- Configurar las credenciales de conexion en el archivo `.env`.

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
├── public/                  # Archivos publicos
├── resources/
│   └── views/
│       ├── auth/            # Vistas de login y registro
│       ├── panel/           # Vistas del panel administrativo
│       ├── layouts/         # Layout principal
│       └── welcome.blade.php
├── routes/
│   └── web.php              # Rutas de la aplicacion
├── .env.example
└── README.md
```

---

# Estado del proyecto

## Version actual

*v1.0*

El proyecto se encuentra en su primera version funcional.

Actualmente dispone de la estructura principal del sistema, integracion de la API, Web Services y mecanismos basicos de seguridad.

Algunos modulos administrativos aun se encuentran en desarrollo y seran completados en futuras versiones.

---

# Proximas versiones

Entre las mejoras planificadas se encuentran:

- Finalizacion de los modulos administrativos.
- Implementacion completa de todas las funcionalidades de gestion.
- Optimizacion del rendimiento.
- Mejoras en la interfaz de usuario.
- Sistema de recuperacion de contrasena.
- Nuevos reportes administrativos.
- Validaciones adicionales.
- Mejoras de seguridad.
- Correccion de errores encontrados durante las pruebas.
- Optimizacion del codigo.
- Incorporacion de nuevas funcionalidades segun los requerimientos del hotel.

---

# Contribuciones

Este proyecto continua en desarrollo. Las futuras versiones estaran enfocadas en mejorar la funcionalidad, seguridad, estabilidad y experiencia de usuario.

---

# Autores

- Breni Elizabeth Vargas
- Flor de Guadalupe Cruz
- Ruth Elizabeth Jimenez

Ingenieria en Desarrollo y Gestion de Software.

Universidad Tecnologica de la Selva.

---

# Licencia

Proyecto desarrollado con fines academicos.

Todos los derechos reservados 2026.
