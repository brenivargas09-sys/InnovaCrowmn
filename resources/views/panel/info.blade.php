@extends('layouts.app')
@section('title', 'Información del Hotel')
@section('page-title', 'Información del Hotel')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-info-circle text-accent me-2"></i>Editar Información del Hotel</h6>
                <a href="{{ route('panel.index') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-arrow-left me-1"></i>Volver</a>
            </div>
            <div class="card-body">
                <form action="{{ route('panel.info.update') }}" method="POST">
                    @csrf @method('PUT')

                    <h6 style="font-size:.8rem;text-transform:uppercase;letter-spacing:1px;color:var(--accent);font-weight:600;margin-bottom:1rem;">
                        <i class="bi bi-building me-1"></i> Identidad del Hotel
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nombre del Hotel</label>
                            <input type="text" name="hotel_name" class="form-control" value="{{ old('hotel_name', $settings['hotel_name'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Texto de Pie de Página</label>
                            <input type="text" name="footer_text" class="form-control" value="{{ old('footer_text', $settings['footer_text'] ?? '') }}">
                        </div>
                    </div>

                    <h6 style="font-size:.8rem;text-transform:uppercase;letter-spacing:1px;color:var(--accent);font-weight:600;margin-bottom:1rem;">
                        <i class="bi bi-book me-1"></i> Historia y Descripción
                    </h6>
                    <div class="mb-4">
                        <label class="form-label">Texto "Sobre Nosotros"</label>
                        <textarea name="about_text" class="form-control" rows="4">{{ old('about_text', $settings['about_text'] ?? '') }}</textarea>
                    </div>

                    <h6 style="font-size:.8rem;text-transform:uppercase;letter-spacing:1px;color:var(--accent);font-weight:600;margin-bottom:1rem;">
                        <i class="bi bi-compass me-1"></i> Misión, Visión y Valores
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Misión</label>
                            <textarea name="mission" class="form-control" rows="3">{{ old('mission', $settings['mission'] ?? '') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Visión</label>
                            <textarea name="vision" class="form-control" rows="3">{{ old('vision', $settings['vision'] ?? '') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Valores</label>
                            <textarea name="values" class="form-control" rows="3">{{ old('values', $settings['values'] ?? '') }}</textarea>
                        </div>
                    </div>

                    <h6 style="font-size:.8rem;text-transform:uppercase;letter-spacing:1px;color:var(--accent);font-weight:600;margin-bottom:1rem;">
                        <i class="bi bi-telephone me-1"></i> Información de Contacto
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="contact_address" class="form-control" value="{{ old('contact_address', $settings['contact_address'] ?? '') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Teléfono Principal</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Teléfono Secundario</label>
                            <input type="text" name="contact_phone2" class="form-control" value="{{ old('contact_phone2', $settings['contact_phone2'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo Electrónico Principal</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo Electrónico Secundario</label>
                            <input type="email" name="contact_email2" class="form-control" value="{{ old('contact_email2', $settings['contact_email2'] ?? '') }}">
                        </div>
                    </div>

                    <h6 style="font-size:.8rem;text-transform:uppercase;letter-spacing:1px;color:var(--accent);font-weight:600;margin-bottom:1rem;">
                        <i class="bi bi-clock me-1"></i> Horarios
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Horario Lunes a Viernes</label>
                            <input type="text" name="schedule_weekdays" class="form-control" value="{{ old('schedule_weekdays', $settings['schedule_weekdays'] ?? '') }}" placeholder="Ej: 8:00 AM - 10:00 PM">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Horario Fines de Semana</label>
                            <input type="text" name="schedule_weekends" class="form-control" value="{{ old('schedule_weekends', $settings['schedule_weekends'] ?? '') }}" placeholder="Ej: 24 horas">
                        </div>
                    </div>

                    <h6 style="font-size:.8rem;text-transform:uppercase;letter-spacing:1px;color:var(--accent);font-weight:600;margin-bottom:1rem;">
                        <i class="bi bi-share me-1"></i> Redes Sociales
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label"><i class="bi bi-facebook me-1"></i>Facebook URL</label>
                            <input type="url" name="social_facebook" class="form-control" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="bi bi-instagram me-1"></i>Instagram URL</label>
                            <input type="url" name="social_instagram" class="form-control" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="bi bi-twitter-x me-1"></i>Twitter/X URL</label>
                            <input type="url" name="social_twitter" class="form-control" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="bi bi-whatsapp me-1"></i>WhatsApp (número con código de país)</label>
                            <input type="text" name="social_whatsapp" class="form-control" value="{{ old('social_whatsapp', $settings['social_whatsapp'] ?? '') }}" placeholder="Ej: 521234567890">
                        </div>
                    </div>

                    <h6 style="font-size:.8rem;text-transform:uppercase;letter-spacing:1px;color:var(--accent);font-weight:600;margin-bottom:1rem;">
                        <i class="bi bi-geo-alt me-1"></i> Mapa (Google Maps)
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Latitud</label>
                            <input type="text" name="map_latitude" class="form-control" value="{{ old('map_latitude', $settings['map_latitude'] ?? '') }}" placeholder="Ej: 16.5155694">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Longitud</label>
                            <input type="text" name="map_longitude" class="form-control" value="{{ old('map_longitude', $settings['map_longitude'] ?? '') }}" placeholder="Ej: -90.6524524">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
