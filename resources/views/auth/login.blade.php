<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - InnovaCrown</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #0f1729;
            --primary-light: #1a2540;
            --primary-mid: #141e35;
            --accent: #c9a96e;
            --accent-hover: #b8964f;
            --accent-glow: rgba(201, 169, 110, .15);
            --surface: #ffffff;
            --surface-alt: #f8fafc;
            --border: #e2e8f0;
            --text: #1e293b;
            --text-muted: #64748b;
            --danger: #ef4444;
            --danger-bg: #fef2f2;
            --danger-border: #fecaca;
            --success: #10b981;
            --radius: 16px;
            --radius-sm: 10px;
            --shadow-card: 0 25px 60px rgba(0, 0, 0, .35), 0 0 0 1px rgba(255, 255, 255, .04);
            --shadow-input: 0 1px 3px rgba(0, 0, 0, .04);
            --transition: all .25s cubic-bezier(.4, 0, .2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        /* ── Animated Background ── */
        .bg-layer {
            position: fixed; inset: 0; overflow: hidden; pointer-events: none; z-index: 0;
        }
        .bg-layer .orb {
            position: absolute; border-radius: 50%; filter: blur(100px);
            animation: float 20s ease-in-out infinite;
        }
        .bg-layer .orb-1 {
            width: 600px; height: 600px; top: -20%; right: -15%;
            background: radial-gradient(circle, rgba(201, 169, 110, .08) 0%, transparent 70%);
            animation-delay: 0s;
        }
        .bg-layer .orb-2 {
            width: 500px; height: 500px; bottom: -15%; left: -10%;
            background: radial-gradient(circle, rgba(201, 169, 110, .05) 0%, transparent 70%);
            animation-delay: -7s;
        }
        .bg-layer .orb-3 {
            width: 300px; height: 300px; top: 40%; left: 50%;
            background: radial-gradient(circle, rgba(15, 23, 41, .3) 0%, transparent 70%);
            animation-delay: -14s;
        }
        .bg-layer .grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .015) 1px, transparent 1px);
            background-size: 80px 80px;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -20px) scale(1.05); }
            66% { transform: translate(-20px, 15px) scale(.95); }
        }

        /* ── Login Container ── */
        .login-container {
            position: relative; z-index: 1; width: 100%; max-width: 440px;
            animation: cardEntry .6s cubic-bezier(.16, 1, .3, 1);
        }
        @keyframes cardEntry {
            from { opacity: 0; transform: translateY(30px) scale(.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ── Card ── */
        .login-card {
            background: var(--surface);
            border-radius: 24px;
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        /* ── Header ── */
        .login-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-mid) 50%, var(--primary-light) 100%);
            padding: 2.75rem 2rem 2.25rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .login-header::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse at 50% 0%, rgba(201, 169, 110, .08) 0%, transparent 60%);
        }
        .login-header::after {
            content: '';
            position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
            width: 80px; height: 3px; border-radius: 3px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
        }

        .brand-icon {
            width: 64px; height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--accent), var(--accent-hover));
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: 1.15rem;
            font-family: 'Playfair Display', serif;
            color: var(--primary); font-weight: 700; font-size: 1.4rem;
            box-shadow: 0 12px 32px rgba(201, 169, 110, .3);
            position: relative;
        }
        .brand-icon::after {
            content: '';
            position: absolute; inset: -3px;
            border-radius: 21px;
            background: linear-gradient(135deg, rgba(201, 169, 110, .2), transparent);
            z-index: -1;
        }

        .login-header h1 {
            color: #fff;
            font-family: 'Playfair Display', serif;
            font-weight: 700; font-size: 1.65rem;
            margin: 0 0 .35rem;
            letter-spacing: .5px;
        }
        .login-header .tagline {
            color: rgba(201, 169, 110, .7);
            font-size: .7rem; letter-spacing: 3px;
            text-transform: uppercase; font-weight: 500;
        }

        /* ── Body ── */
        .login-body {
            padding: 2.25rem 2rem 2rem;
        }
        .login-body .greeting {
            font-weight: 600; font-size: 1.1rem; color: var(--text);
            text-align: center; margin-bottom: .35rem;
        }
        .login-body .sub-greeting {
            text-align: center; color: var(--text-muted);
            font-size: .83rem; margin-bottom: 1.75rem;
        }

        /* ── Flash Messages ── */
        .flash-message {
            padding: .85rem 1rem;
            border-radius: var(--radius-sm);
            font-size: .83rem; font-weight: 500;
            margin-bottom: 1.25rem;
            display: flex; align-items: flex-start; gap: .6rem;
            animation: flashIn .3s ease-out;
        }
        .flash-message i { font-size: 1.1rem; margin-top: 1px; flex-shrink: 0; }
        .flash-message.flash-error {
            background: var(--danger-bg); color: #991b1b;
            border: 1px solid var(--danger-border);
        }
        .flash-message.flash-success {
            background: #ecfdf5; color: #065f46;
            border: 1px solid #a7f3d0;
        }
        @keyframes flashIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Form Fields ── */
        .field-group {
            margin-bottom: 1.25rem;
        }
        .field-label {
            display: block;
            font-size: .78rem; font-weight: 600;
            color: var(--text-muted);
            margin-bottom: .45rem;
            letter-spacing: .3px;
        }
        .input-wrapper {
            position: relative;
        }
        .input-wrapper .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: 1.05rem;
            pointer-events: none; transition: color .2s;
        }
        .input-wrapper input {
            width: 100%;
            padding: .85rem .95rem .85rem 2.75rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: .9rem; font-family: inherit;
            color: var(--text);
            background: var(--surface-alt);
            box-shadow: var(--shadow-input);
            transition: var(--transition);
            outline: none;
        }
        .input-wrapper input::placeholder { color: #94a3b8; }
        .input-wrapper input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
            background: #fff;
        }
        .input-wrapper input:focus ~ .input-icon,
        .input-wrapper input:focus + .input-icon {
            color: var(--accent);
        }
        .input-wrapper input.is-invalid {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .1);
        }
        .input-wrapper input.is-valid {
            border-color: var(--success);
        }
        .input-wrapper select {
            width: 100%;
            padding: .85rem .95rem .85rem 2.75rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: .9rem; font-family: inherit;
            color: var(--text);
            background: var(--surface-alt);
            box-shadow: var(--shadow-input);
            transition: var(--transition);
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 14px;
        }
        .input-wrapper select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
            background-color: #fff;
        }
        .input-wrapper select:focus ~ .input-icon,
        .input-wrapper select:focus + .input-icon {
            color: var(--accent);
        }
        .input-wrapper select.is-invalid {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .1);
        }

        /* Password toggle */
        .toggle-password {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none;
            color: var(--text-muted); font-size: 1.1rem;
            cursor: pointer; padding: 4px;
            border-radius: 6px; transition: var(--transition);
            display: flex; align-items: center; justify-content: center;
            z-index: 2;
        }
        .toggle-password:hover { color: var(--accent); background: rgba(201, 169, 110, .08); }

        /* Field error */
        .field-error {
            font-size: .76rem; color: var(--danger);
            margin-top: .4rem; font-weight: 500;
            display: flex; align-items: center; gap: .3rem;
            animation: errorIn .2s ease-out;
        }
        @keyframes errorIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Remember + Forgot ── */
        .form-options {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 1.5rem;
        }
        .remember-check {
            display: flex; align-items: center; gap: .5rem;
            cursor: pointer; font-size: .82rem; color: var(--text-muted);
            user-select: none;
        }
        .remember-check input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--accent);
            cursor: pointer;
        }
        .forgot-link {
            font-size: .82rem; font-weight: 600;
            color: var(--accent-hover); text-decoration: none;
            transition: var(--transition);
        }
        .forgot-link:hover { color: var(--primary); text-decoration: underline; }

        /* ── Submit Button ── */
        .btn-submit {
            width: 100%; padding: .9rem;
            background: linear-gradient(135deg, var(--accent), var(--accent-hover));
            border: none; border-radius: var(--radius-sm);
            font-size: .92rem; font-weight: 600; font-family: inherit;
            color: var(--primary); cursor: pointer;
            transition: var(--transition);
            position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            letter-spacing: .3px;
        }
        .btn-submit:hover:not(:disabled) {
            background: linear-gradient(135deg, var(--accent-hover), #a88640);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(201, 169, 110, .35);
        }
        .btn-submit:active:not(:disabled) { transform: translateY(0); }
        .btn-submit:disabled {
            opacity: .75; cursor: not-allowed; transform: none;
        }

        /* Spinner */
        .btn-submit .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 2.5px solid rgba(15, 23, 41, .15);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin .6s linear infinite;
        }
        .btn-submit.loading .spinner { display: inline-block; }
        .btn-submit.loading .btn-label { opacity: .6; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Footer ── */
        .login-footer {
            text-align: center; padding-top: 1.5rem;
            margin-top: .25rem;
            border-top: 1px solid #f1f5f9;
        }
        .login-footer p {
            font-size: .82rem; color: var(--text-muted);
        }
        .login-footer a {
            color: var(--accent-hover); font-weight: 600;
            text-decoration: none; transition: var(--transition);
        }
        .login-footer a:hover { color: var(--primary); text-decoration: underline; }

        /* ── Security Badge ── */
        .security-note {
            display: flex; align-items: center; justify-content: center;
            gap: .4rem; margin-top: 1.25rem;
            font-size: .7rem; color: var(--text-muted);
            opacity: .7;
        }
        .security-note i { font-size: .8rem; }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            body { padding: 1rem; }
            .login-header { padding: 2.25rem 1.25rem 1.75rem; }
            .login-body { padding: 1.75rem 1.25rem 1.5rem; }
            .brand-icon { width: 56px; height: 56px; font-size: 1.2rem; border-radius: 15px; }
            .login-header h1 { font-size: 1.4rem; }
            .login-card { border-radius: 20px; }
            .form-options { flex-direction: column; gap: .75rem; align-items: flex-start; }
        }

        @media (max-width: 360px) {
            .login-body { padding: 1.5rem 1rem 1.25rem; }
            .login-header { padding: 2rem 1rem 1.5rem; }
        }

        /* ── Accessibility ── */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* ── Focus visible ── */
        :focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="bg-layer">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="grid"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            {{-- Header --}}
            <div class="login-header">
                <div class="brand-icon">IC</div>
                <h1>InnovaCrown</h1>
                <span class="tagline">Sistema de Gestión Hotelera</span>
            </div>

            {{-- Body --}}
            <div class="login-body">
                <p class="greeting">Bienvenido de vuelta</p>
                <p class="sub-greeting">Ingresa tus credenciales para acceder al sistema</p>

                {{-- Flash Messages --}}
                @if(session('error'))
                    <div class="flash-message flash-error" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="flash-message flash-success" role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="flash-message flash-error" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate autocomplete="on">
                    @csrf

                    {{-- Email or Username --}}
                    <div class="field-group">
                        <label class="field-label" for="email">Correo Electrónico o Usuario</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person input-icon"></i>
                            <input
                                type="text"
                                name="email"
                                id="email"
                                placeholder="tu@correo.com o tu_usuario"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                spellcheck="false"
                                aria-describedby="email-error"
                                @error('email') aria-invalid="true" @enderror
                            >
                        </div>
                        @error('email')
                            <div class="field-error" id="email-error" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="field-group">
                        <label class="field-label" for="role">Rol de Acceso</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-badge input-icon"></i>
                            <select name="role" id="role" required aria-describedby="role-error" @error('role') aria-invalid="true" @enderror>
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Selecciona tu rol</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="recepcionista" {{ old('role') == 'recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                                <option value="cliente" {{ old('role') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                            </select>
                        </div>
                        @error('role')
                            <div class="field-error" id="role-error" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="field-group">
                        <label class="field-label" for="password">Contraseña</label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock input-icon"></i>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Ingresa tu contraseña"
                                required
                                autocomplete="current-password"
                                minlength="6"
                                aria-describedby="password-error"
                                @error('password') aria-invalid="true" @enderror
                            >
                            <button type="button" class="toggle-password" id="togglePassword" aria-label="Mostrar contraseña" title="Mostrar contraseña">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="field-error" id="password-error" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Options --}}
                    <div class="form-options">
                        <label class="remember-check">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            Recordarme
                        </label>
                        <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-submit" id="btnSubmit">
                        <span class="spinner"></span>
                        <span class="btn-label">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Iniciar Sesión
                        </span>
                    </button>
                </form>

                {{-- Footer --}}
                <div class="login-footer">
                    <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
                </div>

                <div class="security-note">
                    <i class="bi bi-shield-lock"></i>
                    <span>Conexión segura y cifrada</span>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('btnSubmit');
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const emailInput = document.getElementById('email');
        const roleInput = document.getElementById('role');

        // ── Toggle Password Visibility ──
        toggleBtn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('bi-eye', !isPassword);
            icon.classList.toggle('bi-eye-slash', isPassword);
            this.setAttribute('aria-label', isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña');
            this.title = isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña';
            passwordInput.focus();
        });

        // ── Real-time Validation ──
        function validateEmail(value) {
            if (!value.trim()) return { valid: false, message: 'El correo o usuario es obligatorio.' };
            if (value.trim().length < 3) return { valid: false, message: 'Ingresa un correo válido o al menos 3 caracteres de usuario.' };
            return { valid: true };
        }

        function validatePassword(value) {
            if (!value) return { valid: false, message: 'La contraseña es obligatoria.' };
            if (value.length < 6) return { valid: false, message: 'La contraseña debe tener al menos 6 caracteres.' };
            return { valid: true };
        }

        function validateRole(value) {
            if (!value) return { valid: false, message: 'Debes seleccionar un rol para continuar.' };
            return { valid: true };
        }

        function setFieldState(input, isValid, message) {
            const fieldGroup = input.closest('.field-group');
            const existingError = fieldGroup.querySelector('.field-error');

            if (existingError) existingError.remove();

            input.classList.remove('is-invalid', 'is-valid');

            if (isValid) {
                input.classList.add('is-valid');
            } else {
                input.classList.add('is-invalid');
                if (message) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'field-error';
                    errorDiv.setAttribute('role', 'alert');
                    errorDiv.innerHTML = '<i class="bi bi-exclamation-triangle-fill"></i> ' + message;
                    fieldGroup.appendChild(errorDiv);
                }
            }
        }

        // Validate on blur
        emailInput.addEventListener('blur', function() {
            const result = validateEmail(this.value);
            setFieldState(this, result.valid, result.message);
        });

        passwordInput.addEventListener('blur', function() {
            const result = validatePassword(this.value);
            setFieldState(this, result.valid, result.message);
        });

        roleInput.addEventListener('change', function() {
            const result = validateRole(this.value);
            setFieldState(this, result.valid, result.message);
        });

        // Clear error on input
        emailInput.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                const result = validateEmail(this.value);
                if (result.valid) setFieldState(this, true);
            }
        });

        passwordInput.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                const result = validatePassword(this.value);
                if (result.valid) setFieldState(this, true);
            }
        });

        // ── Form Submit ──
        form.addEventListener('submit', function(e) {
            // Clear previous server errors
            form.querySelectorAll('.flash-message.flash-error').forEach(el => el.remove());

            const emailResult = validateEmail(emailInput.value);
            const passwordResult = validatePassword(passwordInput.value);
            const roleResult = validateRole(roleInput.value);

            setFieldState(emailInput, emailResult.valid, emailResult.message);
            setFieldState(passwordInput, passwordResult.valid, passwordResult.message);
            setFieldState(roleInput, roleResult.valid, roleResult.message);

            if (!emailResult.valid || !passwordResult.valid || !roleResult.valid) {
                e.preventDefault();
                // Focus first invalid field
                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) firstInvalid.focus();
                return;
            }

            // Show loading state
            btn.classList.add('loading');
            btn.disabled = true;
        });

        // ── Enter key navigation ──
        emailInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                passwordInput.focus();
            }
        });
    });
    </script>
</body>
</html>
