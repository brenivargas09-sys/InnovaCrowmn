<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\Checkin;
use App\Models\Payment;
use App\Models\Service;
use App\Models\ReservationService;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SiteSettingSeeder::class,
        ]);

        $password = Hash::make('password');

        $admin = User::create([
            'username' => 'admin',
            'email' => 'admin@innovacrown.com',
            'password' => $password,
            'role' => 'admin',
            'status' => 'activo',
        ]);

        $recepcionista = User::create([
            'username' => 'recepcionista1',
            'email' => 'recepcion@innovacrown.com',
            'password' => $password,
            'role' => 'recepcionista',
            'status' => 'activo',
        ]);

        $cliente1User = User::create([
            'username' => 'cliente1',
            'email' => 'cliente1@email.com',
            'password' => $password,
            'role' => 'cliente',
            'status' => 'activo',
        ]);

        $cliente2User = User::create([
            'username' => 'cliente2',
            'email' => 'cliente2@email.com',
            'password' => $password,
            'role' => 'cliente',
            'status' => 'activo',
        ]);

        $c1 = Client::create([
            'user_id' => $cliente1User->id,
            'first_name' => 'María',
            'last_name' => 'García',
            'phone' => '5551234567',
            'address' => 'Av. Reforma 123',
            'city' => 'Ciudad de México',
            'id_type' => 'INE',
            'id_number' => '1234567890123',
            'nationality' => 'Mexicana',
        ]);

        $c2 = Client::create([
            'user_id' => $cliente2User->id,
            'first_name' => 'Carlos',
            'last_name' => 'López',
            'phone' => '5559876543',
            'address' => 'Calle Juárez 456',
            'city' => 'Guadalajara',
            'id_type' => 'Pasaporte',
            'id_number' => 'AB123456',
            'nationality' => 'Mexicana',
        ]);

        $types = [
            RoomType::create(['name' => 'Suite Presidencial', 'description' => 'Amplia suite con vista panorámica, sala de estar, jacuzzi privado y servicio de mayordomo 24 horas.', 'price_per_night' => 4500, 'capacity' => 2, 'image' => 'suite-presidencial.jpg']),
            RoomType::create(['name' => 'Suite Junior', 'description' => 'Elegante suite con zona de descanso, baño de mármol y vistas al jardín.', 'price_per_night' => 2800, 'capacity' => 2, 'image' => 'suite-junior.jpg']),
            RoomType::create(['name' => 'Habitación Deluxe', 'description' => 'Habitación espaciosa con amenities premium, baño privado y balcón.', 'price_per_night' => 1800, 'capacity' => 3, 'image' => 'habitacion-deluxe.jpg']),
            RoomType::create(['name' => 'Suite Familiar', 'description' => 'Suite amplia con dos recámaras, sala y comedor, ideal para familias.', 'price_per_night' => 3200, 'capacity' => 4, 'image' => 'suite-familiar.jpg']),
            RoomType::create(['name' => 'Penthouse', 'description' => 'La suite más exclusiva del hotel, terraza privada, jacuzzi y vista 360°.', 'price_per_night' => 8500, 'capacity' => 2, 'image' => 'penthouse.jpg']),
            RoomType::create(['name' => 'Habitación Estándar', 'description' => 'Habitación confortable con todas las comodidades básicas de lujo.', 'price_per_night' => 1200, 'capacity' => 2, 'image' => 'habitacion-estandar.jpg']),
        ];

        $rooms = [
            Room::create(['room_number' => '101', 'room_type_id' => 1, 'floor' => 1, 'status' => 'disponible', 'description' => 'Suite Presidencial con vista al jardín principal']),
            Room::create(['room_number' => '102', 'room_type_id' => 2, 'floor' => 1, 'status' => 'disponible', 'description' => 'Suite Junior con vista al lobby']),
            Room::create(['room_number' => '201', 'room_type_id' => 3, 'floor' => 2, 'status' => 'ocupada', 'description' => 'Habitación Deluxe con balcón lateral']),
            Room::create(['room_number' => '202', 'room_type_id' => 3, 'floor' => 2, 'status' => 'disponible', 'description' => 'Habitación Deluxe con vista al patio']),
            Room::create(['room_number' => '301', 'room_type_id' => 4, 'floor' => 3, 'status' => 'reservada', 'description' => 'Suite Familiar amplia con vista panorámica']),
            Room::create(['room_number' => '302', 'room_type_id' => 5, 'floor' => 3, 'status' => 'disponible', 'description' => 'Penthouse con terraza privada']),
            Room::create(['room_number' => '401', 'room_type_id' => 6, 'floor' => 4, 'status' => 'mantenimiento', 'description' => 'Habitación Estándar en remodelación']),
            Room::create(['room_number' => '402', 'room_type_id' => 6, 'floor' => 4, 'status' => 'disponible', 'description' => 'Habitación Estándar vista interior']),
            Room::create(['room_number' => '501', 'room_type_id' => 1, 'floor' => 5, 'status' => 'disponible', 'description' => 'Suite Presidencial con vista al parque']),
            Room::create(['room_number' => '502', 'room_type_id' => 2, 'floor' => 5, 'status' => 'disponible', 'description' => 'Suite Junior con vista panorámica']),
        ];

        $r1 = Reservation::create([
            'client_id' => $c1->id,
            'room_id' => $rooms[2]->id,
            'check_in_date' => '2026-07-10',
            'check_out_date' => '2026-07-14',
            'status' => 'completada',
            'total_amount' => 7200,
            'notes' => 'Estancia de negocios',
            'created_by' => $recepcionista->id,
        ]);

        $r2 = Reservation::create([
            'client_id' => $c2->id,
            'room_id' => $rooms[4]->id,
            'check_in_date' => '2026-07-15',
            'check_out_date' => '2026-07-20',
            'status' => 'pendiente',
            'total_amount' => 16000,
            'notes' => 'Vacaciones familiares',
            'created_by' => $recepcionista->id,
        ]);

        Checkin::create([
            'reservation_id' => $r1->id,
            'actual_check_in' => '2026-07-10 15:30:00',
            'actual_check_out' => '2026-07-14 11:00:00',
            'notes' => 'Check-out a tiempo',
            'created_by' => $recepcionista->id,
        ]);

        Payment::create([
            'reservation_id' => $r1->id,
            'amount' => 7200,
            'payment_method' => 'tarjeta_credito',
            'payment_date' => '2026-07-10',
            'reference_number' => 'REF-001',
            'notes' => 'Pago total estancia',
            'created_by' => $recepcionista->id,
        ]);

        Payment::create([
            'reservation_id' => $r2->id,
            'amount' => 8000,
            'payment_method' => 'transferencia',
            'payment_date' => '2026-07-12',
            'reference_number' => 'REF-002',
            'notes' => 'Anticipo 50%',
            'created_by' => $recepcionista->id,
        ]);

        $services = [
            Service::create(['name' => 'Spa & Masajes', 'description' => 'Servicio de relajación y masajes terapéuticos.', 'price' => 1500, 'status' => 'activo']),
            Service::create(['name' => 'Restaurante', 'description' => 'Servicio de habitación y cena gourmet.', 'price' => 800, 'status' => 'activo']),
            Service::create(['name' => 'Lavandería', 'description' => 'Servicio de lavado y planchado de ropa.', 'price' => 250, 'status' => 'activo']),
            Service::create(['name' => 'Transporte Aeropuerto', 'description' => 'Traslado ida y vuelta al aeropuerto.', 'price' => 1200, 'status' => 'activo']),
            Service::create(['name' => 'Estacionamiento', 'description' => 'Cajón de estacionamiento privado.', 'price' => 300, 'status' => 'activo']),
            Service::create(['name' => 'Minibar', 'description' => 'Reabastecimiento diario del minibar.', 'price' => 500, 'status' => 'activo']),
        ];

        ReservationService::create([
            'reservation_id' => $r1->id,
            'service_id' => $services[0]->id,
            'quantity' => 2,
            'subtotal' => 3000,
            'notes' => 'Masaje relajante para 2 personas',
        ]);

        ReservationService::create([
            'reservation_id' => $r1->id,
            'service_id' => $services[1]->id,
            'quantity' => 3,
            'subtotal' => 2400,
            'notes' => 'Cenas en habitación',
        ]);

        ReservationService::create([
            'reservation_id' => $r2->id,
            'service_id' => $services[3]->id,
            'quantity' => 1,
            'subtotal' => 1200,
            'notes' => 'Traslado aeropuerto-terminal',
        ]);
    }
}
