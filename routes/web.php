<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationServiceController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HistorialEstadoController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\WeatherController;

Route::get('/', WelcomeController::class)->name('welcome');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/api/weather', [WeatherController::class, 'getWeatherData'])->name('api.weather');

Route::middleware(['auth', 'throttle:60,1'])->group(function () {

    // Admin Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    // Recepcionista Dashboard
    Route::get('/recepcionista/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:recepcionista')
        ->name('recepcionista.dashboard');

    // Cliente Dashboard
    Route::get('/cliente/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:cliente')
        ->name('cliente.dashboard');

    // Admin only - Panel de administración
    Route::middleware(['role:admin'])->prefix('admin')->name('panel.')->group(function () {
        Route::get('/', [PanelController::class, 'index'])->name('index');
        Route::get('/hero', [PanelController::class, 'hero'])->name('hero');
        Route::put('/hero', [PanelController::class, 'heroUpdate'])->name('hero.update');
        Route::get('/galeria', [PanelController::class, 'gallery'])->name('gallery');
        Route::post('/galeria', [PanelController::class, 'galleryUpload'])->name('gallery.upload');
        Route::delete('/galeria/{id}', [PanelController::class, 'galleryDelete'])->name('gallery.delete');
        Route::get('/informacion', [PanelController::class, 'info'])->name('info');
        Route::put('/informacion', [PanelController::class, 'infoUpdate'])->name('info.update');
        Route::get('/habitaciones', [PanelController::class, 'roomsManage'])->name('rooms');
        Route::post('/habitaciones', [PanelController::class, 'roomTypeStore'])->name('rooms.store');
        Route::put('/habitaciones/{roomType}', [PanelController::class, 'roomTypeUpdate'])->name('rooms.update');
        Route::delete('/habitaciones/{roomType}', [PanelController::class, 'roomTypeDelete'])->name('rooms.delete');
        Route::get('/servicios', [PanelController::class, 'servicesManage'])->name('services');
        Route::post('/servicios', [PanelController::class, 'serviceStore'])->name('services.store');
        Route::put('/servicios/{service}', [PanelController::class, 'serviceUpdate'])->name('services.update');
        Route::delete('/servicios/{service}', [PanelController::class, 'serviceDelete'])->name('services.delete');
        Route::get('/clima', [WeatherController::class, 'config'])->name('weather');
        Route::put('/clima', [WeatherController::class, 'configUpdate'])->name('weather.update');
        Route::post('/clima/refresh', [WeatherController::class, 'refresh'])->name('weather.refresh');
        Route::get('/promociones', [PanelController::class, 'promotions'])->name('promotions');
        Route::get('/promociones/crear', [PanelController::class, 'promotionCreate'])->name('promotions.create');
        Route::post('/promociones', [PanelController::class, 'promotionStore'])->name('promotions.store');
        Route::get('/promociones/{promotion}/editar', [PanelController::class, 'promotionEdit'])->name('promotions.edit');
        Route::put('/promociones/{promotion}', [PanelController::class, 'promotionUpdate'])->name('promotions.update');
        Route::delete('/promociones/{promotion}', [PanelController::class, 'promotionDelete'])->name('promotions.delete');
        Route::resource('users', UserController::class);
    });

    // Admin + Recepcionista - Gestión y operaciones
    Route::middleware(['role:admin,recepcionista'])->group(function () {
        Route::resource('clients', ClientController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('room-types', RoomTypeController::class);
        Route::resource('reservations', ReservationController::class);
        Route::post('/reservations/{reservation}/services', [ReservationServiceController::class, 'store'])->name('reservations.services.store');
        Route::delete('/reservations/{reservation}/services/{reservationService}', [ReservationServiceController::class, 'destroy'])->name('reservations.services.destroy');
        Route::resource('payments', PaymentController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
        Route::resource('services', ServiceController::class);
        Route::get('/checkins', [CheckinController::class, 'index'])->name('checkins.index');
        Route::post('/checkins/checkin/{reservation}', [CheckinController::class, 'checkin'])->name('checkins.checkin');
        Route::post('/checkins/checkout/{checkin}', [CheckinController::class, 'checkout'])->name('checkins.checkout');
        Route::prefix('reportes')->name('reports.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('/reservaciones', [ReportController::class, 'reservaciones'])->name('reservaciones');
            Route::get('/habitaciones', [ReportController::class, 'habitaciones'])->name('habitaciones');
            Route::get('/ingresos', [ReportController::class, 'ingresos'])->name('ingresos');
        });
        Route::get('/historial', [HistorialEstadoController::class, 'index'])->name('historial.index');
    });

    // Cliente
    Route::middleware(['role:cliente'])->group(function () {
        Route::get('/mis-reservaciones', [ReservationController::class, 'index'])->name('my.reservations');
    });
});
