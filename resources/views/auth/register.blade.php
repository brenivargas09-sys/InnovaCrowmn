<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro - InnovaCrown</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0f1729;
            --primary-light: #1a2540;
            --accent: #c9a96e;
            --accent-hover: #b8964f;
            --surface: #ffffff;
            --surface-alt: #f8fafc;
            --border: #e2e8f0;
            --text: #1e293b;
            --text-muted: #64748b;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 50%, var(--primary) 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            font-family: 'Inter', sans-serif; margin: 0; padding: 2rem 1rem;
            -webkit-font-smoothing: antialiased;
        }

        .bg-deco { position: fixed; inset: 0; overflow: hidden; pointer-events: none; z-index: 0; }
        .bg-deco .orb { position: absolute; border-radius: 50%; filter: blur(80px); }
        .bg-deco .orb-1 {
            width: 500px; height: 500px; top: -15%; right: -10%;
            background: radial-gradient(circle, rgba(201,169,110,.1) 0%, transparent 70%);
        }
        .bg-deco .orb-2 {
            width: 400px; height: 400px; bottom: -10%; left: -5%;
            background: radial-gradient(circle, rgba(201,169,110,.06) 0%, transparent 70%);
        }
        .bg-deco .grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.02) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .register-wrapper { position: relative; z-index: 1; width: 100%; max-width: 480px; }

        .register-card {
            background: var(--surface); border: none; border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,.35), 0 0 0 1px rgba(255,255,255,.05);
            overflow: hidden; animation: slideUp .5s cubic-bezier(.4,0,.2,1);
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .register-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            padding: 2rem 2rem 1.75rem; text-align: center; position: relative;
        }
        .register-header::after {
            content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
            width: 60px; height: 3px; border-radius: 3px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
        }
        .register-logo {
            width: 52px; height: 52px; border-radius: 13px;
            background: linear-gradient(135deg, var(--accent), var(--accent-hover));
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: .75rem; font-family: 'Playfair Display', serif; color: var(--primary);
            font-weight: 700; font-size: 1.2rem;
            box-shadow: 0 8px 24px rgba(201,169,110,.3);
        }
        .register-header h3 {
            color: #fff; margin: 0 0 .2rem; font-family: 'Playfair Display', serif;
            font-weight: 700; font-size: 1.4rem; letter-spacing: .5px;
        }
        .register-header small {
            color: rgba(201,169,110,.8); font-size: .7rem; letter-spacing: 3px;
            text-transform: uppercase; font-weight: 500;
        }

        .register-body { padding: 1.75rem 2rem 2rem; }
        .register-body h5 {
            font-weight: 600; font-size: 1.05rem; color: var(--text); text-align: center;
            margin-bottom: 1.25rem;
        }

        .form-floating { position: relative; }
        .form-floating .form-control {
            border-radius: 10px; border: 1.5px solid var(--border); font-size: .85rem;
            padding: 1rem 1rem .625rem; transition: all .25s ease; background: var(--surface-alt);
            height: auto;
        }
        .form-floating .form-control:focus {
            border-color: var(--accent); box-shadow: 0 0 0 3px rgba(201,169,110,.12); background: #fff;
        }
        .form-floating label {
            font-weight: 500; font-size: .78rem; color: var(--text-muted); padding: 1rem;
            pointer-events: none; transition: all .2s ease;
        }
        .form-floating .form-control:focus ~ label,
        .form-floating .form-control:not(:placeholder-shown) ~ label {
            transform: scale(.82) translateY(-.6rem); color: var(--accent-hover);
        }
        .input-icon {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: 1rem; z-index: 5; cursor: pointer;
            transition: color .2s; background: none; border: none; padding: 4px;
        }
        .input-icon:hover { color: var(--accent); }

        .btn-register {
            background: linear-gradient(135deg, var(--accent), var(--accent-hover));
            border: none; color: var(--primary); font-weight: 600; padding: .75rem;
            border-radius: 10px; font-size: .9rem; letter-spacing: .3px;
            transition: all .25s ease; width: 100%;
        }
        .btn-register:hover {
            background: linear-gradient(135deg, var(--accent-hover), #a88640);
            color: #fff; transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(201,169,110,.35);
        }
        .btn-register:disabled { opacity: .7; cursor: not-allowed; transform: none; }
        .btn-register .spinner {
            display: none; width: 18px; height: 18px; border: 2.5px solid rgba(15,23,41,.2);
            border-top-color: var(--primary); border-radius: 50%;
            animation: spin .6s linear infinite; margin-right: .5rem;
        }
        .btn-register.loading .spinner { display: inline-block; }
        .btn-register.loading .btn-text { opacity: .6; }
        @keyframes spin { to { transform: rotate(360deg); } }

        .alert { border-radius: 10px; border: none; font-size: .83rem; font-weight: 500; }
        .alert-danger { background: #fef2f2; color: #991b1b; border-left: 3px solid #ef4444; }

        .register-footer {
            text-align: center; padding-top: 1.25rem; margin-top: .5rem;
            border-top: 1px solid #f1f5f9;
        }
        .register-footer a { color: var(--accent-hover); font-weight: 600; font-size: .85rem; }
        .register-footer a:hover { color: var(--primary); text-decoration: underline; }

        .form-label-custom { font-weight: 500; font-size: .78rem; color: var(--text-muted); margin-bottom: .35rem; display: block; }

        @media (max-width: 480px) {
            .register-header { padding: 1.75rem 1.25rem 1.5rem; }
            .register-body { padding: 1.25rem; }
            .register-logo { width: 44px; height: 44px; font-size: 1rem; }
            .register-header h3 { font-size: 1.25rem; }
        }
    </style>
</head>
<body>
    <div class="bg-deco">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="grid"></div>
    </div>

    <div class="register-wrapper">
        <div class="card register-card">
            <div class="register-header">
                <div class="register-logo">IC</div>
                <h3>InnovaCrown</h3>
                <small>Sistema de Gestión Hotelera</small>
            </div>
            <div class="register-body">
                <h5>Crear Cuenta</h5>

                @if($errors->any())
                    <div class="alert alert-danger d-flex align-items-start" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5 me-2 mt-1"></i>
                        <div>
                            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                    @csrf

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="first_name" id="first_name"
                                    class="form-control" placeholder=" " value="{{ old('first_name') }}" required>
                                <label for="first_name"><i class="bi bi-person me-1"></i> Nombre</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="last_name" id="last_name"
                                    class="form-control" placeholder=" " value="{{ old('last_name') }}" required>
                                <label for="last_name"><i class="bi bi-person me-1"></i> Apellido</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating position-relative">
                            <input type="text" name="username" id="username"
                                class="form-control" placeholder=" " value="{{ old('username') }}" required
                                pattern="[a-zA-Z0-9_-]+" minlength="3" maxlength="50">
                            <label for="username"><i class="bi bi-at me-1"></i> Usuario</label>
                            <i class="bi bi-at input-icon"></i>
                        </div>
                        <small class="text-muted" style="font-size:.7rem;margin-left:2px">Solo letras, números, guiones. Mínimo 3 caracteres.</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating position-relative">
                            <input type="email" name="email" id="email"
                                class="form-control" placeholder=" " value="{{ old('email') }}" required>
                            <label for="email"><i class="bi bi-envelope me-1"></i> Correo Electrónico</label>
                            <i class="bi bi-envelope input-icon"></i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating position-relative">
                            <input type="tel" name="phone" id="phone"
                                class="form-control" placeholder=" " value="{{ old('phone') }}">
                            <label for="phone"><i class="bi bi-telephone me-1"></i> Teléfono <span class="text-muted">(opcional)</span></label>
                            <i class="bi bi-telephone input-icon"></i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating position-relative">
                            <input type="password" name="password" id="password"
                                class="form-control" placeholder=" " required minlength="8">
                            <label for="password"><i class="bi bi-lock me-1"></i> Contraseña</label>
                            <button type="button" class="input-icon" id="togglePassword" title="Mostrar contraseña">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted" style="font-size:.7rem;margin-left:2px">Mínimo 8 caracteres.</small>
                    </div>

                    <div class="mb-4">
                        <div class="form-floating position-relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder=" " required>
                            <label for="password_confirmation"><i class="bi bi-lock-fill me-1"></i> Confirmar Contraseña</label>
                            <button type="button" class="input-icon" id="toggleConfirm" title="Mostrar contraseña">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-register" id="btnSubmit">
                        <span class="spinner"></span>
                        <span class="btn-text"><i class="bi bi-person-plus me-1"></i>Registrarse</span>
                    </button>
                </form>

                <div class="register-footer">
                    <small class="text-muted">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const btn = document.getElementById('btnSubmit');

            // Toggle password visibility
            function setupToggle(toggleId, inputId) {
                const toggle = document.getElementById(toggleId);
                const input = document.getElementById(inputId);
                toggle.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.replace('bi-eye', 'bi-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.replace('bi-eye-slash', 'bi-eye');
                    }
                });
            }
            setupToggle('togglePassword', 'password');
            setupToggle('toggleConfirm', 'password_confirmation');

            // Client-side validation
            form.addEventListener('submit', function(e) {
                form.querySelectorAll('.custom-error').forEach(el => el.remove());
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                const fields = {
                    first_name: document.getElementById('first_name').value.trim(),
                    last_name: document.getElementById('last_name').value.trim(),
                    username: document.getElementById('username').value.trim(),
                    email: document.getElementById('email').value.trim(),
                    password: document.getElementById('password').value,
                    password_confirmation: document.getElementById('password_confirmation').value,
                };

                let valid = true;

                if (!fields.first_name) { showErr('first_name', 'El nombre es obligatorio.'); valid = false; }
                if (!fields.last_name) { showErr('last_name', 'El apellido es obligatorio.'); valid = false; }

                if (!fields.username) {
                    showErr('username', 'El usuario es obligatorio.'); valid = false;
                } else if (fields.username.length < 3) {
                    showErr('username', 'El usuario debe tener al menos 3 caracteres.'); valid = false;
                } else if (!/^[a-zA-Z0-9_-]+$/.test(fields.username)) {
                    showErr('username', 'Solo se permiten letras, números, guiones y guiones bajos.'); valid = false;
                }

                if (!fields.email) {
                    showErr('email', 'El correo es obligatorio.'); valid = false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(fields.email)) {
                    showErr('email', 'Ingresa un correo electrónico válido.'); valid = false;
                }

                if (!fields.password) {
                    showErr('password', 'La contraseña es obligatoria.'); valid = false;
                } else if (fields.password.length < 8) {
                    showErr('password', 'La contraseña debe tener al menos 8 caracteres.'); valid = false;
                }

                if (!fields.password_confirmation) {
                    showErr('password_confirmation', 'Confirma tu contraseña.'); valid = false;
                } else if (fields.password !== fields.password_confirmation) {
                    showErr('password_confirmation', 'Las contraseñas no coinciden.'); valid = false;
                }

                if (!valid) { e.preventDefault(); return; }

                btn.classList.add('loading');
                btn.disabled = true;
            });

            function showErr(fieldId, message) {
                const field = document.getElementById(fieldId);
                field.classList.add('is-invalid');
                const div = document.createElement('div');
                div.className = 'invalid-feedback d-block custom-error';
                div.textContent = message;
                field.closest('.mb-3, .col-sm-6').appendChild(div);
            }
        });
    </script>
</body>
</html>
