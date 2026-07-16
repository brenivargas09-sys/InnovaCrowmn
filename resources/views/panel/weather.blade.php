@extends('layouts.app')
@section('title', 'Configuración del Clima')
@section('page-title', 'Clima - Configuración')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="section-header">
            <h5><i class="bi bi-cloud-sun"></i> Configuración del Clima (OpenWeather)</h5>
        </div>

        {{-- Current Weather Preview --}}
        @if($weatherData)
        <div class="card mb-4 border-0" style="background:linear-gradient(135deg,var(--primary) 0%,#162038 60%,#1c2a4a 100%);color:#fff;overflow:hidden;position:relative;">
            <div style="position:absolute;top:-30px;right:-30px;width:200px;height:200px;background:rgba(201,169,110,.08);border-radius:50%;"></div>
            <div class="card-body p-4 position-relative" style="z-index:1;">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $weatherData['icon_url'] }}" alt="{{ $weatherData['description'] }}" style="width:72px;height:72px;filter:drop-shadow(0 2px 8px rgba(0,0,0,.3));">
                            <div>
                                <div style="font-size:2.8rem;font-weight:700;line-height:1;">{{ $weatherData['temp'] }}°C</div>
                                <div style="color:rgba(255,255,255,.7);font-size:.9rem;">{{ $weatherData['description'] }}</div>
                            </div>
                        </div>
                        <div class="d-flex gap-4 flex-wrap" style="font-size:.85rem;color:rgba(255,255,255,.6);">
                            <span><i class="bi bi-geo-alt me-1" style="color:var(--accent);"></i>{{ $weatherData['city_name'] }}{{ $weatherData['country'] ? ', ' . $weatherData['country'] : '' }}</span>
                            <span><i class="bi bi-droplet me-1" style="color:var(--accent);"></i>{{ $weatherData['humidity'] }}% humedad</span>
                            <span><i class="bi bi-wind me-1" style="color:var(--accent);"></i>{{ $weatherData['wind_speed'] }} km/h</span>
                            <span><i class="bi bi-eye me-1" style="color:var(--accent);"></i>{{ $weatherData['visibility'] }} km</span>
                        </div>
                        <div class="d-flex gap-4 flex-wrap mt-2" style="font-size:.8rem;color:rgba(255,255,255,.4);">
                            <span>Sensación: {{ $weatherData['feels_like'] }}°C</span>
                            <span>Mín: {{ $weatherData['temp_min'] }}°C | Máx: {{ $weatherData['temp_max'] }}°C</span>
                            @if($weatherData['sunrise'])<span>Amanecer: {{ $weatherData['sunrise'] }}</span>@endif
                            @if($weatherData['sunset'])<span>Atardecer: {{ $weatherData['sunset'] }}</span>@endif
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <small style="color:rgba(255,255,255,.35);display:block;margin-bottom:.5rem;">Última actualización: {{ $weatherData['updated_at'] }}</small>
                        <form action="{{ route('panel.weather.refresh') }}" method="POST" class="d-inline" id="refreshForm">
                            @csrf
                            <button type="submit" class="btn btn-sm" style="background:var(--accent);color:#fff;" id="refreshBtn">
                                <i class="bi bi-arrow-clockwise me-1"></i>Actualizar Ahora
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card mb-4 border-0" style="background:var(--surface-alt);text-align:center;padding:2rem;">
            <i class="bi bi-cloud-slash fs-1" style="color:var(--text-muted);opacity:.3;display:block;margin-bottom:.5rem;"></i>
            <p style="color:var(--text-muted);font-size:.9rem;margin:0;">No hay datos de clima disponibles. Configura la API key y la ubicación abajo.</p>
        </div>
        @endif

        {{-- Configuration Form --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-gear text-accent me-2"></i>Configuración de Ubicación y API</h6>
                <a href="{{ route('panel.index') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-arrow-left me-1"></i>Volver</a>
            </div>
            <div class="card-body">
                <form action="{{ route('panel.weather.update') }}" method="POST">
                    @csrf @method('PUT')

                    <h6 style="font-size:.75rem;text-transform:uppercase;letter-spacing:1px;color:var(--accent);font-weight:600;margin-bottom:1rem;">
                        <i class="bi bi-key me-1"></i> API Key de OpenWeather
                    </h6>
                    <div class="mb-4">
                        <label class="form-label">API Key</label>
                        <input type="text" name="weather_api_key" class="form-control" value="{{ old('weather_api_key', $config['api_key']) }}" required placeholder="Tu API Key de OpenWeatherMap">
                        <small class="text-muted">
                            Obtén tu API key gratis en <a href="https://openweathermap.org/api" target="_blank" rel="noopener">openweathermap.org/api</a>
                        </small>
                    </div>

                    <h6 style="font-size:.75rem;text-transform:uppercase;letter-spacing:1px;color:var(--accent);font-weight:600;margin-bottom:1rem;">
                        <i class="bi bi-geo-alt me-1"></i> Ubicación del Hotel
                    </h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Ciudad</label>
                            <input type="text" name="weather_city" class="form-control" value="{{ old('weather_city', $config['city']) }}" placeholder="Ej: Mérida">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estado / Provincia</label>
                            <input type="text" name="weather_state" class="form-control" value="{{ old('weather_state', $config['state']) }}" placeholder="Ej: Yucatán">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">País (código ISO)</label>
                            <input type="text" name="weather_country" class="form-control" value="{{ old('weather_country', $config['country']) }}" placeholder="Ej: MX" maxlength="2">
                        </div>
                    </div>

                    <div class="text-center mb-3" style="font-size:.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;">— O usa coordenadas GPS —</div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Latitud</label>
                            <input type="number" step="any" name="weather_lat" class="form-control" value="{{ old('weather_lat', $config['lat']) }}" placeholder="Ej: 20.9674" min="-90" max="90">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Longitud</label>
                            <input type="number" step="any" name="weather_lon" class="form-control" value="{{ old('weather_lon', $config['lon']) }}" placeholder="Ej: -89.5926" min="-180" max="180">
                        </div>
                    </div>

                    <h6 style="font-size:.75rem;text-transform:uppercase;letter-spacing:1px;color:var(--accent);font-weight:600;margin-bottom:1rem;">
                        <i class="bi bi-clock me-1"></i> Caché
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Actualizar caché cada (minutos)</label>
                            <input type="number" name="weather_cache_minutes" class="form-control" value="{{ old('weather_cache_minutes', '30') }}" min="5" max="1440">
                            <small class="text-muted">Mínimo 5 min. Evita exceder la cuota de la API.</small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar Configuración</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
