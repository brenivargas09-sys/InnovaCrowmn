-- =====================================================
-- InnovaCrown - Sistema de Gestion Hotelera v1.0
-- Script de base de datos MySQL
-- =====================================================
-- Base de datos: innovacrown
-- Motor: MySQL 8.x
-- Fecha: Julio 2026
-- =====================================================

CREATE DATABASE IF NOT EXISTS `innovacrown`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `innovacrown`;

-- =====================================================
-- TABLA: users (usuarios del sistema)
-- =====================================================
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `reservation_service`;
DROP TABLE IF EXISTS `promotions`;
DROP TABLE IF EXISTS `site_settings`;
DROP TABLE IF EXISTS `payments`;
DROP TABLE IF EXISTS `checkins`;
DROP TABLE IF EXISTS `reservations`;
DROP TABLE IF EXISTS `rooms`;
DROP TABLE IF EXISTS `room_types`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `historial_estados`;
DROP TABLE IF EXISTS `clients`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','recepcionista','cliente') NOT NULL DEFAULT 'cliente',
  `status` ENUM('activo','inactivo') NOT NULL DEFAULT 'activo',
  `last_login_at` TIMESTAMP NULL DEFAULT NULL,
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: password_reset_tokens
-- =====================================================
CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: sessions
-- =====================================================
CREATE TABLE `sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` TEXT DEFAULT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: cache
-- =====================================================
CREATE TABLE `cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: jobs
-- =====================================================
CREATE TABLE `jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` TINYINT UNSIGNED NOT NULL,
  `reserved_at` INT UNSIGNED DEFAULT NULL,
  `available_at` INT UNSIGNED NOT NULL,
  `created_at` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` INT NOT NULL,
  `pending_jobs` INT NOT NULL,
  `failed_jobs` INT NOT NULL,
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` MEDIUMTEXT DEFAULT NULL,
  `cancelled_at` INT DEFAULT NULL,
  `created_at` INT NOT NULL,
  `finished_at` INT DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: clients (clientes del hotel)
-- =====================================================
CREATE TABLE `clients` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `address` VARCHAR(200) DEFAULT NULL,
  `city` VARCHAR(50) DEFAULT NULL,
  `id_type` ENUM('INE','Pasaporte','Licencia','Otro') NOT NULL DEFAULT 'INE',
  `id_number` VARCHAR(30) NOT NULL,
  `nationality` VARCHAR(50) NOT NULL DEFAULT 'Mexicana',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clients_user_id_foreign` (`user_id`),
  CONSTRAINT `clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: room_types (tipos de habitacion)
-- =====================================================
CREATE TABLE `room_types` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `price_per_night` DECIMAL(10,2) NOT NULL,
  `capacity` INT NOT NULL DEFAULT 2,
  `image` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: rooms (habitaciones)
-- =====================================================
CREATE TABLE `rooms` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_number` VARCHAR(10) NOT NULL,
  `room_type_id` BIGINT UNSIGNED NOT NULL,
  `floor` INT NOT NULL DEFAULT 1,
  `status` ENUM('disponible','reservada','ocupada','mantenimiento') NOT NULL DEFAULT 'disponible',
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rooms_room_number_unique` (`room_number`),
  KEY `rooms_room_type_id_foreign` (`room_type_id`),
  CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: reservations (reservaciones)
-- =====================================================
CREATE TABLE `reservations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `room_id` BIGINT UNSIGNED NOT NULL,
  `check_in_date` DATE NOT NULL,
  `check_out_date` DATE NOT NULL,
  `status` ENUM('pendiente','confirmada','cancelada','completada') NOT NULL DEFAULT 'pendiente',
  `total_amount` DECIMAL(10,2) NOT NULL,
  `notes` TEXT DEFAULT NULL,
  `created_by` BIGINT UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservations_client_id_foreign` (`client_id`),
  KEY `reservations_room_id_foreign` (`room_id`),
  KEY `reservations_created_by_foreign` (`created_by`),
  CONSTRAINT `reservations_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `reservations_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `reservations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: checkins (check-in / check-out)
-- =====================================================
CREATE TABLE `checkins` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reservation_id` BIGINT UNSIGNED NOT NULL,
  `actual_check_in` DATETIME DEFAULT NULL,
  `actual_check_out` DATETIME DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `created_by` BIGINT UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `checkins_reservation_id_foreign` (`reservation_id`),
  KEY `checkins_created_by_foreign` (`created_by`),
  CONSTRAINT `checkins_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `checkins_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: payments (pagos)
-- =====================================================
CREATE TABLE `payments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reservation_id` BIGINT UNSIGNED NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `payment_method` ENUM('efectivo','tarjeta_credito','tarjeta_debito','transferencia') NOT NULL DEFAULT 'efectivo',
  `payment_date` DATE NOT NULL,
  `reference_number` VARCHAR(50) DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `created_by` BIGINT UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_reservation_id_foreign` (`reservation_id`),
  KEY `payments_created_by_foreign` (`created_by`),
  CONSTRAINT `payments_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: services (servicios del hotel)
-- =====================================================
CREATE TABLE `services` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `status` ENUM('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: historial_estados
-- =====================================================
CREATE TABLE `historial_estados` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(50) NOT NULL,
  `registro_id` BIGINT UNSIGNED NOT NULL,
  `estado_anterior` VARCHAR(50) DEFAULT NULL,
  `estado_nuevo` VARCHAR(50) NOT NULL,
  `cambiado_por` BIGINT UNSIGNED DEFAULT NULL,
  `observaciones` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `historial_estados_cambiado_por_foreign` (`cambiado_por`),
  CONSTRAINT `historial_estados_cambiado_por_foreign` FOREIGN KEY (`cambiado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: reservation_service (servicios por reservacion)
-- =====================================================
CREATE TABLE `reservation_service` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reservation_id` BIGINT UNSIGNED NOT NULL,
  `service_id` BIGINT UNSIGNED NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  `subtotal` DECIMAL(10,2) NOT NULL,
  `notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reservation_service_unique` (`reservation_id`, `service_id`),
  KEY `reservation_service_reservation_id_foreign` (`reservation_id`),
  KEY `reservation_service_service_id_foreign` (`service_id`),
  CONSTRAINT `reservation_service_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservation_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: site_settings (configuracion del sitio)
-- =====================================================
CREATE TABLE `site_settings` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` VARCHAR(100) NOT NULL,
  `value` TEXT DEFAULT NULL,
  `type` VARCHAR(20) NOT NULL DEFAULT 'text',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: promotions (promociones)
-- =====================================================
CREATE TABLE `promotions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(150) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `link` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('activo','inactivo') NOT NULL DEFAULT 'activo',
  `start_date` DATE DEFAULT NULL,
  `end_date` DATE DEFAULT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =====================================================
-- DATOS DE PRUEBA
-- =====================================================
-- Contrasena para todos los usuarios: password
-- Hash bcrypt generado con Hash::make('password') en Laravel
-- =====================================================

-- USUARIOS
-- Contrasena: password (hash bcrypt)
INSERT INTO `users` (`username`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
('admin',         'admin@innovacrown.com',    '$2y$10$6aSfpQtcEpZryo3Qa/eBwuAXIJRodGqF.L27IlH5iM/dtgvWTg/3O', 'admin',         'activo', NOW(), NOW()),
('recepcionista1','recepcion@innovacrown.com','$2y$10$6aSfpQtcEpZryo3Qa/eBwuAXIJRodGqF.L27IlH5iM/dtgvWTg/3O', 'recepcionista', 'activo', NOW(), NOW()),
('cliente1',      'cliente1@email.com',      '$2y$10$6aSfpQtcEpZryo3Qa/eBwuAXIJRodGqF.L27IlH5iM/dtgvWTg/3O', 'cliente',       'activo', NOW(), NOW()),
('cliente2',      'cliente2@email.com',      '$2y$10$6aSfpQtcEpZryo3Qa/eBwuAXIJRodGqF.L27IlH5iM/dtgvWTg/3O', 'cliente',       'activo', NOW(), NOW());

-- CLIENTES
INSERT INTO `clients` (`user_id`, `first_name`, `last_name`, `phone`, `address`, `city`, `id_type`, `id_number`, `nationality`, `created_at`, `updated_at`) VALUES
(3, 'María',  'García', '5551234567', 'Av. Reforma 123',     'Ciudad de México', 'INE',        '1234567890123', 'Mexicana', NOW(), NOW()),
(4, 'Carlos', 'López',  '5559876543', 'Calle Juárez 456',    'Guadalajara',      'Pasaporte',  'AB123456',      'Mexicana', NOW(), NOW());

-- TIPOS DE HABITACION
INSERT INTO `room_types` (`name`, `description`, `price_per_night`, `capacity`, `image`, `created_at`, `updated_at`) VALUES
('Suite Presidencial',   'Amplia suite con vista panorámica, sala de estar, jacuzzi privado y servicio de mayordomo 24 horas.', 4500.00, 2, 'suite-presidencial.jpg',  NOW(), NOW()),
('Suite Junior',         'Elegante suite con zona de descanso, baño de mármol y vistas al jardín.',                           2800.00, 2, 'suite-junior.jpg',         NOW(), NOW()),
('Habitación Deluxe',    'Habitación espaciosa con amenities premium, baño privado y balcón.',                                1800.00, 3, 'habitacion-deluxe.jpg',    NOW(), NOW()),
('Suite Familiar',       'Suite amplia con dos recámaras, sala y comedor, ideal para familias.',                              3200.00, 4, 'suite-familiar.jpg',       NOW(), NOW()),
('Penthouse',            'La suite más exclusiva del hotel, terraza privada, jacuzzi y vista 360°.',                          8500.00, 2, 'penthouse.jpg',            NOW(), NOW()),
('Habitación Estándar',  'Habitación confortable con todas las comodidades básicas de lujo.',                                  1200.00, 2, 'habitacion-estandar.jpg',  NOW(), NOW());

-- HABITACIONES
INSERT INTO `rooms` (`room_number`, `room_type_id`, `floor`, `status`, `description`, `created_at`, `updated_at`) VALUES
('101', 1, 1, 'disponible',    'Suite Presidencial con vista al jardín principal',       NOW(), NOW()),
('102', 2, 1, 'disponible',    'Suite Junior con vista al lobby',                         NOW(), NOW()),
('201', 3, 2, 'ocupada',       'Habitación Deluxe con balcón lateral',                   NOW(), NOW()),
('202', 3, 2, 'disponible',    'Habitación Deluxe con vista al patio',                   NOW(), NOW()),
('301', 4, 3, 'reservada',     'Suite Familiar amplia con vista panorámica',              NOW(), NOW()),
('302', 5, 3, 'disponible',    'Penthouse con terraza privada',                           NOW(), NOW()),
('401', 6, 4, 'mantenimiento', 'Habitación Estándar en remodelación',                     NOW(), NOW()),
('402', 6, 4, 'disponible',    'Habitación Estándar vista interior',                      NOW(), NOW()),
('501', 1, 5, 'disponible',    'Suite Presidencial con vista al parque',                  NOW(), NOW()),
('502', 2, 5, 'disponible',    'Suite Junior con vista panorámica',                       NOW(), NOW());

-- RESERVACIONES
INSERT INTO `reservations` (`client_id`, `room_id`, `check_in_date`, `check_out_date`, `status`, `total_amount`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 3, '2026-07-10', '2026-07-14', 'completada',  7200.00, 'Estancia de negocios',         2, NOW(), NOW()),
(2, 5, '2026-07-15', '2026-07-20', 'pendiente',  16000.00, 'Vacaciones familiares',        2, NOW(), NOW());

-- CHECK-IN / CHECK-OUT
INSERT INTO `checkins` (`reservation_id`, `actual_check_in`, `actual_check_out`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '2026-07-10 15:30:00', '2026-07-14 11:00:00', 'Check-out a tiempo', 2, NOW(), NOW());

-- PAGOS
INSERT INTO `payments` (`reservation_id`, `amount`, `payment_method`, `payment_date`, `reference_number`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 7200.00, 'tarjeta_credito', '2026-07-10', 'REF-001', 'Pago total estancia',   2, NOW(), NOW()),
(2, 8000.00, 'transferencia',   '2026-07-12', 'REF-002', 'Anticipo 50%',          2, NOW(), NOW());

-- SERVICIOS
INSERT INTO `services` (`name`, `description`, `price`, `status`, `created_at`, `updated_at`) VALUES
('Spa & Masajes',         'Servicio de relajación y masajes terapéuticos.',              1500.00, 'activo', NOW(), NOW()),
('Restaurante',           'Servicio de habitación y cena gourmet.',                       800.00, 'activo', NOW(), NOW()),
('Lavandería',            'Servicio de lavado y planchado de ropa.',                      250.00, 'activo', NOW(), NOW()),
('Transporte Aeropuerto', 'Traslado ida y vuelta al aeropuerto.',                        1200.00, 'activo', NOW(), NOW()),
('Estacionamiento',       'Cajón de estacionamiento privado.',                             300.00, 'activo', NOW(), NOW()),
('Minibar',               'Reabastecimiento diario del minibar.',                          500.00, 'activo', NOW(), NOW());

-- SERVICIOS POR RESERVACION
INSERT INTO `reservation_service` (`reservation_id`, `service_id`, `quantity`, `subtotal`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 3000.00, 'Masaje relajante para 2 personas', NOW(), NOW()),
(1, 2, 3, 2400.00, 'Cenas en habitación',              NOW(), NOW()),
(2, 4, 1, 1200.00, 'Traslado aeropuerto-terminal',      NOW(), NOW());

-- CONFIGURACION DEL SITIO
INSERT INTO `site_settings` (`key`, `value`, `type`, `created_at`, `updated_at`) VALUES
('hero_title',         'Bienvenido a',                                                                                                                  'text',  NOW(), NOW()),
('hero_subtitle',      'InnovaCrown',                                                                                                                   'text',  NOW(), NOW()),
('hero_description',   'Disfruta de una experiencia de hospedaje de lujo en el corazón de la ciudad. Habitaciones elegantes, servicio excepcional y atención personalizada.', 'text',  NOW(), NOW()),
('hero_image',         '',                                                                                                                              'text',  NOW(), NOW()),
('hotel_name',         'InnovaCrown',                                                                                                                   'text',  NOW(), NOW()),
('hotel_subtitle',     'Hotel de Lujo',                                                                                                                 'text',  NOW(), NOW()),
('about_text',         'InnovaCrown es un hotel de lujo que combina elegancia moderna con atención personalizada. Desde nuestra apertura, nos hemos comprometido a ofrecer una experiencia única a cada huésped, con instalaciones de primer nivel y un equipo dedicado a superar sus expectativas.', 'text', NOW(), NOW()),
('mission',            'Brindar a nuestros huéspedes una experiencia de hospedaje excepcional, superando sus expectativas a través de un servicio personalizado, instalaciones de primera calidad y un ambiente de confort y elegancia.', 'text',  NOW(), NOW()),
('vision',             'Ser reconocidos como el hotel de lujo preferido en la región, destacando por nuestra innovación constante, compromiso con la excelencia y atención al detalle que nos diferencia.', 'text',  NOW(), NOW()),
('values',             'Excelencia, integridad, hospitalidad, innovación y compromiso con la satisfacción de nuestros huéspedes.',                      'text',  NOW(), NOW()),
('contact_address',    'Av. Principal 123, Col. Centro, Ciudad de México, CP 06000',                                                                   'text',  NOW(), NOW()),
('contact_phone',      '+52 55 1234 5678',                                                                                                             'text',  NOW(), NOW()),
('contact_phone2',     '+52 55 8765 4321',                                                                                                             'text',  NOW(), NOW()),
('contact_email',      'reservaciones@innovacrown.com',                                                                                                 'text',  NOW(), NOW()),
('contact_email2',     'info@innovacrown.com',                                                                                                         'text',  NOW(), NOW()),
('schedule_weekdays',  '24 horas',                                                                                                                      'text',  NOW(), NOW()),
('schedule_weekends',  '24 horas',                                                                                                                      'text',  NOW(), NOW()),
('social_facebook',    '',                                                                                                                              'text',  NOW(), NOW()),
('social_instagram',   '',                                                                                                                              'text',  NOW(), NOW()),
('social_twitter',     '',                                                                                                                              'text',  NOW(), NOW()),
('social_whatsapp',    '525512345678',                                                                                                                  'text',  NOW(), NOW()),
('footer_text',        'Hotel de lujo en el corazón de la ciudad. Tu confort es nuestra prioridad. Disfruta de nuestras habitaciones de ensueño, restaurantes gourmet y servicios exclusivos.', 'text',  NOW(), NOW()),
('map_latitude',       '16.5155694',                                                                                                                    'text',  NOW(), NOW()),
('map_longitude',      '-90.6524524',                                                                                                                   'text',  NOW(), NOW()),
('map_zoom',           '17',                                                                                                                            'text',  NOW(), NOW());

-- =====================================================
-- FIN DEL SCRIPT
-- =====================================================
