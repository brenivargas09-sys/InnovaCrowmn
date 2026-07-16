<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['hotel_name'] ?? 'InnovaCrown' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0f1729;
            --primary-light: #162038;
            --primary-medium: #1c2a4a;
            --accent: #c9a96e;
            --accent-hover: #b8964f;
            --accent-light: rgba(201,169,110,.12);
            --accent-glow: rgba(201,169,110,.25);
            --dark: #1a2540;
            --cream: #f8f6f3;
            --cream-dark: #f0ece6;
            --text: #1e293b;
            --text-light: #64748b;
            --text-lighter: #94a3b8;
            --glass: rgba(255,255,255,.06);
            --glass-border: rgba(255,255,255,.1);
        }
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; color: var(--text); overflow-x: hidden; -webkit-font-smoothing: antialiased; }
        h1,h2,h3,h4,h5,h6 { font-family: 'Playfair Display', Georgia, serif; }
        img { max-width: 100%; }

        /* ══════════════════════════════════════════
           PRELOADER
        ══════════════════════════════════════════ */
        #preloader {
            position: fixed; inset: 0; z-index: 99999;
            background: var(--primary);
            display: flex; align-items: center; justify-content: center; flex-direction: column;
            transition: opacity .8s cubic-bezier(.4,0,.2,1), visibility .8s;
            animation: preloaderAutoHide 0s ease 4s forwards;
        }
        #preloader.loaded { opacity: 0; visibility: hidden; pointer-events: none; }
        @keyframes preloaderAutoHide { to { opacity: 0; visibility: hidden; pointer-events: none; } }
        .preloader-brand {
            font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700;
            color: #fff; margin-bottom: 2rem; opacity: 0;
            animation: preloaderFadeIn .6s ease forwards .3s;
        }
        .preloader-brand span { color: var(--accent); }
        .preloader-bar-track {
            width: 200px; height: 2px; background: rgba(255,255,255,.1); border-radius: 2px; overflow: hidden;
            opacity: 0; animation: preloaderFadeIn .6s ease forwards .5s;
        }
        .preloader-bar {
            height: 100%; width: 0; background: linear-gradient(90deg, var(--accent), var(--accent-hover));
            border-radius: 2px; animation: preloaderProgress 1.8s cubic-bezier(.4,0,.2,1) forwards .7s;
        }
        @keyframes preloaderFadeIn { to { opacity: 1; } }
        @keyframes preloaderProgress { to { width: 100%; } }

        /* ══════════════════════════════════════════
           NAVBAR
        ══════════════════════════════════════════ */
        .nav-hostel {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1050;
            padding: 1.2rem 0; transition: all .6s cubic-bezier(.4,0,.2,1);
            background: transparent;
        }
        .nav-hostel.scrolled {
            background: rgba(15,23,41,.97); padding: .6rem 0;
            box-shadow: 0 4px 40px rgba(0,0,0,.5); backdrop-filter: blur(24px);
        }
        .nav-hostel .navbar-brand {
            font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700;
            color: #fff; letter-spacing: .5px; display: flex; align-items: center; gap: .6rem;
            text-decoration: none; transition: transform .3s ease;
        }
        .nav-hostel .navbar-brand:hover { transform: scale(1.03); }
        .nav-hostel .navbar-brand .brand-icon {
            width: 38px; height: 38px; background: linear-gradient(135deg, var(--accent), var(--accent-hover));
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: #fff; box-shadow: 0 4px 15px rgba(201,169,110,.35);
            transition: transform .4s ease, box-shadow .4s ease;
        }
        .nav-hostel .navbar-brand:hover .brand-icon {
            transform: rotate(-8deg) scale(1.1); box-shadow: 0 6px 25px rgba(201,169,110,.5);
        }
        .nav-hostel .nav-link {
            color: rgba(255,255,255,.7); font-weight: 500; font-size: .85rem;
            letter-spacing: .3px; padding: .5rem 1.1rem !important; transition: all .35s ease;
            position: relative; border-radius: 6px;
        }
        .nav-hostel .nav-link:hover { color: #fff; background: rgba(255,255,255,.06); }
        .nav-hostel .nav-link.active { color: var(--accent); }
        .nav-hostel .nav-link::after {
            content: ''; position: absolute; bottom: 2px; left: 50%; transform: translateX(-50%);
            width: 0; height: 2px; background: var(--accent); border-radius: 2px;
            transition: width .35s cubic-bezier(.4,0,.2,1);
        }
        .nav-hostel .nav-link:hover::after, .nav-hostel .nav-link.active::after { width: 50%; }
        .nav-hostel .dropdown-menu {
            background: rgba(15,23,41,.97); border: 1px solid rgba(201,169,110,.15);
            border-radius: 14px; padding: .6rem; box-shadow: 0 25px 60px rgba(0,0,0,.5);
            backdrop-filter: blur(24px); margin-top: .6rem;
            transform: translateY(8px); opacity: 0; visibility: hidden;
            transition: all .35s cubic-bezier(.4,0,.2,1);
        }
        .nav-hostel .dropdown.show .dropdown-menu { transform: translateY(0); opacity: 1; visibility: visible; }
        .nav-hostel .dropdown-item {
            color: rgba(255,255,255,.65); font-size: .85rem; padding: .65rem 1.1rem;
            border-radius: 10px; transition: all .3s ease; display: flex; align-items: center; gap: .5rem;
        }
        .nav-hostel .dropdown-item:hover { background: rgba(201,169,110,.15); color: var(--accent); transform: translateX(4px); }
        .nav-hostel .dropdown-item i { width: 20px; text-align: center; font-size: .9rem; }
        .navbar-toggler { border: none; outline: none !important; box-shadow: none !important; padding: .25rem; }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255,255,255,.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            width: 24px; height: 24px;
        }

        /* ══════════════════════════════════════════
           BUTTONS
        ══════════════════════════════════════════ */
        .btn-gold {
            background: linear-gradient(135deg, var(--accent), var(--accent-hover)); color: #fff;
            border: none; padding: .85rem 2.4rem; font-size: .88rem; font-weight: 600;
            letter-spacing: .5px; border-radius: 10px;
            transition: all .45s cubic-bezier(.4,0,.2,1); position: relative; overflow: hidden;
            box-shadow: 0 4px 20px rgba(201,169,110,.3); text-decoration: none;
        }
        .btn-gold::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.25), transparent);
            transition: left .6s ease;
        }
        .btn-gold:hover::before { left: 100%; }
        .btn-gold:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 40px rgba(201,169,110,.5); color: #fff; text-decoration: none;
        }
        .btn-gold:active { transform: translateY(-1px) scale(.98); }
        .btn-gold-outline {
            background: rgba(255,255,255,.05); color: #fff; border: 1.5px solid rgba(255,255,255,.35);
            padding: .85rem 2.4rem; font-size: .88rem; font-weight: 600; letter-spacing: .5px;
            border-radius: 10px; transition: all .45s cubic-bezier(.4,0,.2,1); backdrop-filter: blur(6px);
            text-decoration: none;
        }
        .btn-gold-outline:hover {
            background: rgba(255,255,255,.15); border-color: rgba(255,255,255,.6); color: #fff;
            transform: translateY(-4px) scale(1.02); text-decoration: none;
        }
        .btn-outline-gold-nav {
            background: transparent; color: var(--accent); border: 1.5px solid rgba(201,169,110,.5);
            padding: .5rem 1.2rem; font-size: .8rem; font-weight: 600; transition: all .35s cubic-bezier(.4,0,.2,1);
            border-radius: 8px; text-decoration: none; display: inline-block; cursor: pointer;
        }
        .btn-outline-gold-nav:hover {
            background: var(--accent); color: #fff; border-color: var(--accent);
            transform: translateY(-2px); box-shadow: 0 6px 20px rgba(201,169,110,.35); text-decoration: none;
        }
        .btn-gold-nav {
            background: var(--accent); color: #fff; border: none; padding: .5rem 1.2rem;
            font-size: .8rem; font-weight: 600; transition: all .35s cubic-bezier(.4,0,.2,1);
            border-radius: 8px; text-decoration: none; display: inline-block; cursor: pointer;
        }
        .btn-gold-nav:hover {
            background: var(--accent-hover); color: #fff; transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(201,169,110,.35); text-decoration: none;
        }

        /* ══════════════════════════════════════════
           HERO
        ══════════════════════════════════════════ */
        .hero {
            position: relative; min-height: 100vh; display: flex; align-items: center;
            justify-content: center; color: #fff; overflow: hidden; background: #000;
        }
        .hero-bg {
            position: absolute; inset: 0; z-index: 1;
            background-size: cover; background-position: center;
            animation: heroSlowZoom 20s ease-in-out infinite alternate;
            will-change: transform;
        }
        @keyframes heroSlowZoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.08); }
        }
        .hero::before {
            content: ''; position: absolute; inset: 0; z-index: 2;
            background: rgba(0,0,0,.65);
        }
        .hero-content { text-align: center; max-width: 900px; padding: 2rem; position: relative; z-index: 5; }

        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4.5rem); font-weight: 700; line-height: 1.1; margin-bottom: .5rem;
            text-shadow: 0 2px 30px rgba(0,0,0,.5), 0 4px 80px rgba(0,0,0,.3);
            opacity: 0; transform: translateY(40px);
            animation: heroReveal 1.1s cubic-bezier(.4,0,.2,1) forwards .7s;
        }
        .hero h1 span { color: var(--accent); display: inline-block; }
        .hero-lead {
            font-size: 1.35rem; color: rgba(255,255,255,.85); font-weight: 300;
            font-family: 'Playfair Display', serif; font-style: italic; margin: .75rem 0;
            text-shadow: 0 1px 20px rgba(0,0,0,.4);
            opacity: 0; transform: translateY(30px);
            animation: heroReveal 1s cubic-bezier(.4,0,.2,1) forwards .9s;
        }
        .hero-line {
            width: 70px; height: 2px; background: linear-gradient(90deg, transparent, var(--accent), transparent);
            margin: 1.5rem auto 2rem; transform-origin: center;
            opacity: 0; transform: scaleX(0);
            animation: heroLineReveal 1s cubic-bezier(.4,0,.2,1) forwards 1.1s;
        }
        .hero-desc {
            font-size: 1rem; color: rgba(255,255,255,.65); max-width: 560px;
            margin: 0 auto 2.5rem; line-height: 1.8;
            text-shadow: 0 1px 10px rgba(0,0,0,.3);
            opacity: 0; transform: translateY(25px);
            animation: heroReveal 1s cubic-bezier(.4,0,.2,1) forwards 1.2s;
        }
        .hero-buttons {
            display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;
            opacity: 0; transform: translateY(25px);
            animation: heroReveal 1s cubic-bezier(.4,0,.2,1) forwards 1.4s;
        }
        .hero-scroll {
            position: absolute; bottom: 2.5rem; left: 50%; transform: translateX(-50%); z-index: 5;
            color: rgba(255,255,255,.35);
            opacity: 0; animation: heroReveal 1s ease forwards 2s;
        }
        .hero-scroll .scroll-mouse {
            width: 26px; height: 40px; border: 2px solid rgba(255,255,255,.35); border-radius: 13px;
            display: flex; justify-content: center; padding-top: 8px; position: relative;
        }
        .hero-scroll .scroll-wheel {
            width: 3px; height: 8px; background: var(--accent); border-radius: 3px;
            animation: scrollWheel 2s ease-in-out infinite;
        }
        @keyframes scrollWheel {
            0% { opacity: 1; transform: translateY(0); }
            50% { opacity: .3; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Hero decorative floating accent lines */
        .hero-accent-line {
            position: absolute; z-index: 3; pointer-events: none;
            background: linear-gradient(180deg, transparent, rgba(201,169,110,.12), transparent);
            width: 1px;
        }
        .hero-accent-line:nth-child(1) { top: 10%; left: 15%; height: 120px; }
        .hero-accent-line:nth-child(2) { top: 20%; right: 15%; height: 80px; }
        .hero-accent-line:nth-child(3) { bottom: 20%; left: 10%; height: 100px; }
        .hero-accent-line:nth-child(4) { bottom: 15%; right: 12%; height: 60px; }

        @keyframes heroReveal { to { opacity: 1; transform: translateY(0); } }
        @keyframes heroLineReveal { to { opacity: 1; transform: scaleX(1); } }

        /* ── Weather Floating ── */
        .weather-float {
            position: absolute; bottom: 5rem; right: 2rem; z-index: 5;
            background: rgba(0,0,0,.3); backdrop-filter: blur(16px);
            border: 1px solid rgba(201,169,110,.15); border-radius: 12px;
            padding: .6rem 1rem; display: flex; align-items: center; gap: .6rem;
            box-shadow: 0 8px 25px rgba(0,0,0,.3);
            opacity: 0; transform: translateY(20px);
            animation: heroReveal 1s cubic-bezier(.4,0,.2,1) forwards 1.8s;
            transition: transform .4s ease, box-shadow .4s ease;
        }
        .weather-float:hover { transform: translateY(-3px); box-shadow: 0 12px 35px rgba(0,0,0,.4); }
        .weather-float img { width: 32px; height: 32px; filter: drop-shadow(0 1px 4px rgba(0,0,0,.3)); }
        .weather-float .wf-temp { font-size: 1.1rem; font-weight: 700; color: #fff; line-height: 1; }
        .weather-float .wf-desc { font-size: .65rem; color: rgba(255,255,255,.5); text-transform: capitalize; }
        .weather-float .wf-detail { font-size: .6rem; color: rgba(255,255,255,.3); display: flex; gap: .5rem; margin-top: .2rem; }
        .weather-float .wf-detail i { color: var(--accent); font-size: .55rem; }

        /* ══════════════════════════════════════════
           SECTIONS
        ══════════════════════════════════════════ */
        .section-py { padding: 7rem 0; }
        .section-dark { background: var(--primary); color: #fff; }
        .section-cream { background: var(--cream); }
        .section-white { background: #fff; }

        .sec-header { text-align: center; margin-bottom: 4.5rem; }
        .sec-overline {
            display: inline-flex; align-items: center; gap: .75rem;
            font-size: .68rem; font-weight: 600; letter-spacing: 4px;
            text-transform: uppercase; color: var(--accent); margin-bottom: 1rem;
            font-family: 'Inter', sans-serif;
        }
        .sec-overline::before, .sec-overline::after {
            content: ''; width: 25px; height: 1px; background: var(--accent); opacity: .5;
        }
        .sec-header h2 { font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 700; color: var(--primary); margin-bottom: .5rem; }
        .sec-header .line {
            width: 55px; height: 2.5px; margin: 1.2rem auto;
            background: linear-gradient(90deg, var(--accent), var(--accent-hover)); border-radius: 2px;
        }
        .sec-header p { color: var(--text-light); font-size: 1rem; max-width: 520px; margin: 0 auto; line-height: 1.8; }
        .section-dark .sec-header h2 { color: #fff; }
        .section-dark .sec-header p { color: rgba(255,255,255,.55); }

        /* ── Parallax Section Divider ── */
        .parallax-divider {
            height: 300px; position: relative; overflow: hidden;
            background-attachment: fixed; background-size: cover; background-position: center;
        }
        .parallax-divider::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(15,23,41,.85), rgba(15,23,41,.75));
        }
        .parallax-divider .pd-content {
            position: absolute; inset: 0; z-index: 1; display: flex; align-items: center;
            justify-content: center; flex-direction: column; text-align: center; color: #fff; padding: 2rem;
        }
        .parallax-divider .pd-content h3 {
            font-size: 2rem; font-weight: 700; margin-bottom: .5rem;
            text-shadow: 0 2px 20px rgba(0,0,0,.3);
        }
        .parallax-divider .pd-content p { color: rgba(255,255,255,.6); font-size: 1rem; }

        /* ══════════════════════════════════════════
           SCROLL REVEAL
        ══════════════════════════════════════════ */
        .reveal-up {
            opacity: 0; transform: translateY(60px);
            transition: opacity .9s cubic-bezier(.4,0,.2,1), transform .9s cubic-bezier(.4,0,.2,1);
        }
        .reveal-up.visible { opacity: 1; transform: translateY(0); }

        .reveal-left {
            opacity: 0; transform: translateX(-60px);
            transition: opacity .9s cubic-bezier(.4,0,.2,1), transform .9s cubic-bezier(.4,0,.2,1);
        }
        .reveal-left.visible { opacity: 1; transform: translateX(0); }

        .reveal-right {
            opacity: 0; transform: translateX(60px);
            transition: opacity .9s cubic-bezier(.4,0,.2,1), transform .9s cubic-bezier(.4,0,.2,1);
        }
        .reveal-right.visible { opacity: 1; transform: translateX(0); }

        .reveal-scale {
            opacity: 0; transform: scale(.85);
            transition: opacity .9s cubic-bezier(.4,0,.2,1), transform .9s cubic-bezier(.4,0,.2,1);
        }
        .reveal-scale.visible { opacity: 1; transform: scale(1); }

        .reveal-rotate {
            opacity: 0; transform: rotate(-4deg) scale(.9);
            transition: opacity .9s cubic-bezier(.4,0,.2,1), transform .9s cubic-bezier(.4,0,.2,1);
        }
        .reveal-rotate.visible { opacity: 1; transform: rotate(0) scale(1); }

        /* stagger delay helpers */
        .d1 { transition-delay: .1s; } .d2 { transition-delay: .2s; }
        .d3 { transition-delay: .3s; } .d4 { transition-delay: .4s; }
        .d5 { transition-delay: .5s; } .d6 { transition-delay: .6s; }
        .d7 { transition-delay: .7s; } .d8 { transition-delay: .8s; }

        /* ══════════════════════════════════════════
           STATS
        ══════════════════════════════════════════ */
        .stats-bar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--dark) 50%, var(--primary-medium) 100%);
            padding: 4rem 0; position: relative; overflow: hidden;
        }
        .stats-bar::before {
            content: ''; position: absolute; top: -50%; right: -10%; width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(201,169,110,.07), transparent 70%); border-radius: 50%;
        }
        .stats-bar::after {
            content: ''; position: absolute; bottom: -50%; left: -10%; width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(201,169,110,.05), transparent 70%); border-radius: 50%;
        }
        .stat-item { text-align: center; padding: 1.5rem 1rem; position: relative; z-index: 1; }
        .stat-item:not(:last-child)::after {
            content: ''; position: absolute; right: 0; top: 25%; height: 50%;
            width: 1px; background: linear-gradient(to bottom, transparent, rgba(255,255,255,.1), transparent);
        }
        .stat-num {
            font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700;
            color: var(--accent); line-height: 1; margin-bottom: .5rem;
            transition: transform .4s ease;
        }
        .stat-item:hover .stat-num { transform: scale(1.1); }
        .stat-lbl {
            color: rgba(255,255,255,.45); font-size: .75rem; font-weight: 600;
            letter-spacing: 2px; text-transform: uppercase;
        }

        /* ══════════════════════════════════════════
           PROMOS
        ══════════════════════════════════════════ */
        .promo-card {
            background: linear-gradient(155deg, var(--primary), var(--dark));
            border: none; border-radius: 20px; overflow: hidden; color: #fff;
            transition: all .55s cubic-bezier(.4,0,.2,1); height: 100%;
            box-shadow: 0 4px 25px rgba(0,0,0,.15); position: relative;
        }
        .promo-card::before {
            content: ''; position: absolute; inset: 0; border-radius: 20px;
            background: linear-gradient(135deg, rgba(201,169,110,.1), transparent);
            opacity: 0; transition: opacity .5s ease; z-index: 1; pointer-events: none;
        }
        .promo-card:hover::before { opacity: 1; }
        .promo-card:hover { transform: translateY(-12px) scale(1.02); box-shadow: 0 25px 60px rgba(15,23,41,.5); }
        .promo-card img { width: 100%; height: 220px; object-fit: cover; transition: transform .7s cubic-bezier(.4,0,.2,1); }
        .promo-card:hover img { transform: scale(1.08); }
        .promo-card .promo-img-wrap { overflow: hidden; position: relative; }
        .promo-card .card-body { padding: 1.6rem; position: relative; z-index: 2; }
        .promo-tag {
            display: inline-block; background: linear-gradient(135deg, var(--accent), var(--accent-hover));
            color: #fff; padding: .3rem .85rem; font-size: .6rem; font-weight: 700;
            letter-spacing: 2px; text-transform: uppercase; border-radius: 50px;
            margin-bottom: .75rem;
        }
        .promo-card h5 { font-size: 1.15rem; margin-bottom: .5rem; transition: color .3s; }
        .promo-card:hover h5 { color: var(--accent); }
        .promo-card p { font-size: .85rem; color: rgba(255,255,255,.55); line-height: 1.7; margin-bottom: 1rem; }
        .promo-card a { color: var(--accent); font-weight: 600; font-size: .83rem; text-decoration: none; transition: all .3s; display: inline-flex; align-items: center; gap: .3rem; }
        .promo-card a i { transition: transform .3s ease; }
        .promo-card a:hover { color: #fff; }
        .promo-card a:hover i { transform: translateX(5px); }

        /* ══════════════════════════════════════════
           ROOMS
        ══════════════════════════════════════════ */
        .room-card {
            border: none; border-radius: 20px; overflow: hidden; background: #fff;
            box-shadow: 0 2px 25px rgba(0,0,0,.06); transition: all .55s cubic-bezier(.4,0,.2,1);
            height: 100%; position: relative;
        }
        .room-card:hover { transform: translateY(-14px); box-shadow: 0 25px 60px rgba(0,0,0,.14); }
        .room-img { position: relative; height: 260px; overflow: hidden; }
        .room-img img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform .8s cubic-bezier(.25,.46,.45,.94);
        }
        .room-card:hover .room-img img { transform: scale(1.12); }
        .room-img::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 60%;
            background: linear-gradient(to top, rgba(15,23,41,.65), transparent);
            pointer-events: none;
        }
        .room-img-placeholder {
            width: 100%; height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--primary-medium));
            display: flex; align-items: center; justify-content: center;
        }
        .room-img-placeholder i { font-size: 3rem; color: var(--accent); opacity: .25; }
        .room-badge {
            position: absolute; top: 1rem; right: 1rem; z-index: 1;
            background: rgba(15,23,41,.65); backdrop-filter: blur(10px);
            color: #fff; padding: .35rem .9rem; font-size: .72rem; font-weight: 600;
            border-radius: 50px; border: 1px solid rgba(255,255,255,.12);
            transition: transform .3s ease;
        }
        .room-card:hover .room-badge { transform: scale(1.08); }
        .room-card .card-body { padding: 1.6rem; }
        .room-card h5 {
            font-size: 1.2rem; font-weight: 700; color: var(--primary); margin-bottom: .5rem;
            transition: color .35s ease;
        }
        .room-card:hover h5 { color: var(--accent); }
        .room-card .card-text { font-size: .85rem; color: var(--text-light); line-height: 1.7; margin-bottom: 1rem; }
        .room-price { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: var(--accent); }
        .room-price small { font-family: 'Inter', sans-serif; font-size: .72rem; color: var(--text-lighter); font-weight: 400; }

        /* ══════════════════════════════════════════
           SERVICES
        ══════════════════════════════════════════ */
        .svc-card {
            background: #fff; border: 1px solid rgba(0,0,0,.04); border-radius: 20px;
            padding: 2.5rem 1.6rem; text-align: center; transition: all .55s cubic-bezier(.4,0,.2,1);
            height: 100%; position: relative; overflow: hidden; cursor: default;
        }
        .svc-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent-hover));
            transform: scaleX(0); transition: transform .5s cubic-bezier(.4,0,.2,1); transform-origin: left;
        }
        .svc-card:hover::before { transform: scaleX(1); }
        .svc-card:hover {
            background: var(--primary); color: #fff; transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(15,23,41,.35); border-color: transparent;
        }
        .svc-icon {
            width: 72px; height: 72px; border-radius: 50%;
            background: linear-gradient(135deg, rgba(201,169,110,.12), rgba(201,169,110,.04));
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.4rem; transition: all .5s cubic-bezier(.4,0,.2,1);
        }
        .svc-icon i { font-size: 1.6rem; color: var(--accent); transition: transform .5s ease; }
        .svc-card:hover .svc-icon { background: rgba(201,169,110,.2); transform: scale(1.15) rotate(-5deg); }
        .svc-card:hover .svc-icon i { transform: scale(1.1); }
        .svc-card h5 { font-size: 1.05rem; font-weight: 700; color: var(--primary); margin-bottom: .6rem; transition: color .4s; }
        .svc-card:hover h5 { color: #fff; }
        .svc-card p { font-size: .83rem; color: var(--text-light); line-height: 1.6; margin-bottom: .8rem; transition: color .4s; }
        .svc-card:hover p { color: rgba(255,255,255,.6); }
        .svc-price { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 700; color: var(--accent); transition: transform .3s; }
        .svc-card:hover .svc-price { transform: scale(1.1); }

        /* ══════════════════════════════════════════
           GALLERY
        ══════════════════════════════════════════ */
        .gallery-grid .g-item {
            position: relative; overflow: hidden; border-radius: 14px; margin-bottom: 1.2rem; cursor: pointer;
        }
        .gallery-grid .g-item img {
            width: 100%; height: 260px; object-fit: cover;
            transition: transform .7s cubic-bezier(.25,.46,.45,.94);
        }
        .gallery-grid .g-item:hover img { transform: scale(1.1); }
        .gallery-grid .g-item::before {
            content: ''; position: absolute; inset: 0; z-index: 1;
            background: linear-gradient(to top, rgba(15,23,41,.6), transparent 60%);
            opacity: 0; transition: opacity .5s ease;
        }
        .gallery-grid .g-item:hover::before { opacity: 1; }
        .gallery-grid .g-item .g-zoom {
            position: absolute; bottom: 1.2rem; right: 1.2rem; z-index: 2;
            width: 40px; height: 40px; background: rgba(201,169,110,.92); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: .9rem; opacity: 0; transform: translateY(15px) scale(.8);
            transition: all .45s cubic-bezier(.4,0,.2,1);
            box-shadow: 0 4px 15px rgba(201,169,110,.4);
        }
        .gallery-grid .g-item:hover .g-zoom { opacity: 1; transform: translateY(0) scale(1); }
        .gallery-empty { text-align: center; padding: 4rem 2rem; color: var(--text-lighter); }
        .gallery-empty i { font-size: 2.5rem; margin-bottom: 1rem; color: var(--accent); opacity: .3; }

        /* ══════════════════════════════════════════
           ABOUT
        ══════════════════════════════════════════ */
        .about-img-wrap {
            position: relative; border-radius: 20px; overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,.15);
        }
        .about-img-wrap::after {
            content: ''; position: absolute; inset: 0;
            border: 2px solid rgba(201,169,110,.2); border-radius: 20px; pointer-events: none;
        }
        .about-text { font-size: 1rem; color: var(--text-light); line-height: 2; margin-bottom: 1.5rem; }
        .about-list { list-style: none; padding: 0; margin-bottom: 2rem; }
        .about-list li {
            padding: .85rem 0; font-size: .92rem; color: var(--text);
            display: flex; align-items: flex-start; gap: .8rem;
            border-bottom: 1px solid rgba(0,0,0,.06);
            transition: transform .3s ease, padding-left .3s ease;
        }
        .about-list li:hover { transform: translateX(6px); padding-left: .5rem; }
        .about-list li:last-child { border-bottom: none; }
        .about-list li i { color: var(--accent); margin-top: .15rem; flex-shrink: 0; font-size: 1.1rem; }
        .social-links { display: flex; gap: .8rem; margin-top: 2rem; }
        .social-link {
            width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-size: 1.15rem; color: #fff;
            transition: all .45s cubic-bezier(.4,0,.2,1); text-decoration: none;
        }
        .social-link:hover { transform: translateY(-7px) scale(1.1); box-shadow: 0 10px 30px rgba(0,0,0,.35); color: #fff; text-decoration: none; }
        .social-link.fb { background: #3b5998; }
        .social-link.ig { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
        .social-link.tw { background: #1da1f2; }
        .social-link.wa { background: #25d366; }

        /* ══════════════════════════════════════════
           CONTACT
        ══════════════════════════════════════════ */
        .contact-card {
            background: #fff; border-radius: 20px; padding: 2.2rem; text-align: center;
            border: 1px solid rgba(0,0,0,.04); transition: all .5s cubic-bezier(.4,0,.2,1); height: 100%;
            position: relative; overflow: hidden;
        }
        .contact-card::before {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent-hover));
            transform: scaleX(0); transition: transform .45s ease; transform-origin: center;
        }
        .contact-card:hover::before { transform: scaleX(1); }
        .contact-card:hover { transform: translateY(-8px); box-shadow: 0 15px 40px rgba(0,0,0,.1); }
        .contact-card .cc-icon {
            width: 60px; height: 60px; border-radius: 50%;
            background: linear-gradient(135deg, rgba(201,169,110,.15), rgba(201,169,110,.05));
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.2rem; transition: all .45s ease;
        }
        .contact-card:hover .cc-icon { transform: scale(1.15) rotate(-5deg); background: rgba(201,169,110,.25); }
        .contact-card .cc-icon i { font-size: 1.4rem; color: var(--accent); }
        .contact-card h6 { font-family: 'Inter', sans-serif; font-weight: 600; font-size: .82rem; color: var(--text); margin-bottom: .5rem; text-transform: uppercase; letter-spacing: 1.5px; }
        .contact-card p { font-size: .88rem; color: var(--text-light); margin: 0; line-height: 1.7; }

        /* ── Map ── */
        .map-wrap {
            border-radius: 20px; overflow: hidden;
            box-shadow: 0 12px 50px rgba(0,0,0,.15); border: 3px solid var(--dark);
            transition: transform .5s ease, box-shadow .5s ease;
        }
        .map-wrap:hover { transform: scale(1.01); box-shadow: 0 18px 60px rgba(0,0,0,.2); }
        .map-wrap iframe { width: 100%; height: 450px; border: none; display: block; }

        /* ══════════════════════════════════════════
           FOOTER
        ══════════════════════════════════════════ */
        .footer-site { background: var(--primary); color: rgba(255,255,255,.65); padding: 5rem 0 0; position: relative; }
        .footer-site::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
        }
        .footer-site h5 {
            color: #fff; font-size: 1.1rem; margin-bottom: 1.3rem; position: relative;
            padding-bottom: .8rem; font-family: 'Playfair Display', serif;
        }
        .footer-site h5::after { content: ''; position: absolute; bottom: 0; left: 0; width: 35px; height: 2px; background: var(--accent); border-radius: 2px; transition: width .4s ease; }
        .footer-site h5:hover::after { width: 60px; }
        .footer-site p { font-size: .88rem; line-height: 1.8; }
        .footer-links { list-style: none; padding: 0; }
        .footer-links li { margin-bottom: .7rem; }
        .footer-links a {
            color: rgba(255,255,255,.45); text-decoration: none; font-size: .88rem;
            transition: all .35s ease; display: inline-flex; align-items: center; gap: .3rem;
        }
        .footer-links a:hover { color: var(--accent); transform: translateX(6px); }
        .fc-item { display: flex; align-items: flex-start; gap: .8rem; margin-bottom: .9rem; font-size: .88rem; transition: transform .3s; }
        .fc-item:hover { transform: translateX(4px); }
        .fc-item i { color: var(--accent); margin-top: .15rem; flex-shrink: 0; }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,.06); margin-top: 3.5rem; padding: 1.8rem 0;
            text-align: center; font-size: .8rem; color: rgba(255,255,255,.25);
        }

        /* ══════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════ */
        @media (max-width: 991.98px) {
            .weather-float { position: static; margin: 1.5rem auto 0; display: inline-flex; }
            .stat-item:not(:last-child)::after { display: none; }
            .parallax-divider { background-attachment: scroll; }
        }
        @media (max-width: 767.98px) {
            .section-py { padding: 5rem 0; }
            .hero h1 { font-size: 2.2rem; }
            .hero-lead { font-size: 1.05rem; }
            .stat-num { font-size: 2.2rem; }
            .gallery-grid .g-item img { height: 180px; }
            .weather-float { display: none; }
        }
        @media (max-width: 575.98px) {
            .hero h1 { font-size: 1.9rem; }
            .social-links { justify-content: center; }
            .map-wrap iframe { height: 280px; }
            .sec-header h2 { font-size: 1.7rem; }
        }
    </style>
</head>
<body>

    {{-- PRELOADER --}}
    <div id="preloader">
        <div class="preloader-brand"><span>IC</span> InnovaCrown</div>
        <div class="preloader-bar-track"><div class="preloader-bar"></div></div>
    </div>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg nav-hostel" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span class="brand-icon"><i class="bi bi-gem"></i></span>
                {{ $settings['hotel_name'] ?? 'InnovaCrown' }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#servicios">Servicios</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Catálogo</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#habitaciones"><i class="bi bi-door-open"></i> Habitaciones</a></li>
                            <li><a class="dropdown-item" href="#galeria"><i class="bi bi-images"></i> Galería</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Hotel</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#nosotros"><i class="bi bi-info-circle"></i> Sobre Nosotros</a></li>
                            <li><a class="dropdown-item" href="#contacto"><i class="bi bi-geo-alt"></i> Contacto y Ubicación</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2 flex-wrap justify-content-center">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('panel.index') }}" class="btn btn-gold-nav"><i class="bi bi-speedometer2 me-1"></i> Panel</a>
                        @elseif(auth()->user()->role === 'recepcionista')
                            <a href="{{ route('recepcionista.dashboard') }}" class="btn btn-gold-nav"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a>
                        @elseif(auth()->user()->role === 'cliente')
                            <a href="{{ route('my.reservations') }}" class="btn btn-gold-nav"><i class="bi bi-calendar-check me-1"></i> Mis Reservas</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">@csrf
                            <button type="submit" class="btn btn-outline-gold-nav"><i class="bi bi-box-arrow-right me-1"></i> Salir</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-gold-nav"><i class="bi bi-person me-1"></i> Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="btn btn-gold-nav"><i class="bi bi-person-plus me-1"></i> Registrarse</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="hero">
        <div class="hero-accent-line"></div>
        <div class="hero-accent-line"></div>
        <div class="hero-accent-line"></div>
        <div class="hero-accent-line"></div>
        <div class="hero-bg" id="heroBg" style="background-image:url('{{ $settings['hero_image'] ? asset("storage/" . $settings["hero_image"]) : '' }}');"></div>
        <div class="hero-content">
            <h1>{{ $settings['hero_title'] ?? 'Bienvenido a' }}<br><span>{{ $settings['hotel_name'] ?? 'InnovaCrown' }}</span></h1>
            @if(!empty($settings['hero_subtitle']))
                <p class="hero-lead">{{ $settings['hero_subtitle'] }}</p>
            @endif
            <div class="hero-line"></div>
            @if(!empty($settings['hero_description']))
                <p class="hero-desc">{{ $settings['hero_description'] }}</p>
            @endif
            <div class="hero-buttons">
                <a href="#habitaciones" class="btn btn-gold"><i class="bi bi-door-open me-2"></i>Ver Habitaciones</a>
                <a href="{{ route('register') }}" class="btn btn-gold-outline"><i class="bi bi-calendar-plus me-2"></i>Reservar Ahora</a>
            </div>
        </div>
        @if(!empty($weather))
        <div class="weather-float">
            <img src="{{ $weather['icon_url'] }}" alt="{{ $weather['description'] }}">
            <div>
                <div class="wf-temp">{{ $weather['temp'] }}°C</div>
                <div class="wf-desc">{{ $weather['description'] }}</div>
                <div class="wf-detail">
                    <span><i class="bi bi-droplet"></i> {{ $weather['humidity'] }}%</span>
                    <span><i class="bi bi-wind"></i> {{ $weather['wind_speed'] }}km/h</span>
                </div>
            </div>
        </div>
        @endif
        <div class="hero-scroll">
            <div class="scroll-mouse"><div class="scroll-wheel"></div></div>
        </div>
    </section>

    {{-- PROMOTIONS --}}
    @if(isset($promotions) && $promotions->count())
    <section class="section-py section-white">
        <div class="container">
            <div class="sec-header reveal-up">
                <div class="sec-overline">Ofertas Especiales</div>
                <h2>Promociones</h2>
                <div class="line"></div>
                <p>Aprovecha nuestras ofertas especiales para una experiencia inolvidable</p>
            </div>
            <div class="row g-4">
                @foreach($promotions as $i => $promo)
                <div class="col-lg-4 col-md-6 reveal-up d{{ $i + 1 }}">
                    <div class="promo-card">
                        <div class="promo-img-wrap">
                            @if(!empty($promo->image))<img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}">@endif
                        </div>
                        <div class="card-body">
                            <span class="promo-tag">Promoción</span>
                            <h5>{{ $promo->title }}</h5>
                            <p>{{ $promo->description }}</p>
                            @if(!empty($promo->link))<a href="{{ $promo->link }}">Ver más <i class="bi bi-arrow-right"></i></a>@endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- STATS --}}
    <section class="stats-bar">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-6 reveal-up d1"><div class="stat-item"><div class="stat-num counter" data-target="{{ $stats['total_rooms'] ?? 0 }}">0</div><div class="stat-lbl">Habitaciones</div></div></div>
                <div class="col-lg-3 col-md-6 col-6 reveal-up d2"><div class="stat-item"><div class="stat-num counter" data-target="{{ $stats['total_types'] ?? 0 }}">0</div><div class="stat-lbl">Tipos</div></div></div>
                <div class="col-lg-3 col-md-6 col-6 reveal-up d3"><div class="stat-item"><div class="stat-num counter" data-target="{{ $stats['total_services'] ?? 0 }}">0</div><div class="stat-lbl">Servicios</div></div></div>
                <div class="col-lg-3 col-md-6 col-6 reveal-up d4"><div class="stat-item"><div class="stat-num counter" data-target="{{ $stats['total_clients'] ?? 0 }}">0</div><div class="stat-lbl">Clientes</div></div></div>
            </div>
        </div>
    </section>

    {{-- ROOMS --}}
    <section class="section-py section-cream" id="habitaciones">
        <div class="container">
            <div class="sec-header reveal-up">
                <div class="sec-overline">Nuestras Habitaciones</div>
                <h2>Confort y Elegancia</h2>
                <div class="line"></div>
                <p>Descubre el confort y la elegancia en cada estancia</p>
            </div>
            <div class="row g-4">
                @forelse($roomTypes as $i => $room)
                <div class="col-lg-4 col-md-6 reveal-up d{{ ($i % 3) + 1 }}">
                    <div class="card room-card">
                        <div class="room-img">
                            @if(!empty($room->image))
                                <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}">
                            @else
                                <div class="room-img-placeholder"><i class="bi bi-building"></i></div>
                            @endif
                            @if(!empty($room->capacity))
                                <span class="room-badge"><i class="bi bi-people-fill me-1"></i>{{ $room->capacity }}</span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5>{{ $room->name }}</h5>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($room->description, 120) }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <div class="room-price">${{ number_format($room->price_per_night, 0) }} <small>/noche</small></div>
                                <a href="{{ route('register') }}" class="btn btn-gold" style="padding:.5rem 1.3rem;font-size:.78rem;">Reservar</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5 reveal-up">
                    <i class="bi bi-building fs-1 text-muted d-block mb-3" style="opacity:.2;"></i>
                    <p class="text-muted">Próximamente tendremos habitaciones disponibles.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- PARALLAX DIVIDER --}}
    @if(!empty($settings['hero_image']))
    <div class="parallax-divider" style="background-image: url('{{ asset('storage/' . $settings['hero_image']) }}');">
        <div class="pd-content reveal-up">
            <h3>Una Experiencia Única</h3>
            <p>Cada detalle pensado para tu confort</p>
        </div>
    </div>
    @endif

    {{-- SERVICES --}}
    <section class="section-py section-white" id="servicios">
        <div class="container">
            <div class="sec-header reveal-up">
                <div class="sec-overline">Servicios Exclusivos</div>
                <h2>Todo lo que Necesitas</h2>
                <div class="line"></div>
                <p>Una experiencia completa para hacer inolvidable tu estancia</p>
            </div>
            @php
                $iconMap = [
                    'restaurante' => 'bi-cup-hot', 'spa' => 'bi-water', 'piscina' => 'bi-droplet',
                    'gimnasio' => 'bi-bicycle', 'wifi' => 'bi-wifi', 'estacionamiento' => 'bi-car-front',
                    'bar' => 'bi-cup-straw', 'salon' => 'bi-easel', 'jardin' => 'bi-flower1',
                    'lavanderia' => 'bi-tsunami', 'seguridad' => 'bi-shield-check', 'recepcion' => 'bi-bell',
                    'conferencia' => 'bi-megaphone', 'turismo' => 'bi-compass', 'transporte' => 'bi-bus-front',
                    'servicio a la habitaci' => 'bi-cone-striped', 'minibar' => 'bi-cup',
                    'aire acondicionado' => 'bi-snow', 'caja fuerte' => 'bi-lock', 'televisor' => 'bi-tv',
                ];
                $defaultIcon = 'bi-star';
            @endphp
            <div class="row g-4">
                @forelse($services as $i => $service)
                    @php
                        $icon = $defaultIcon;
                        $lowerName = mb_strtolower($service->name);
                        foreach($iconMap as $key => $value) { if(str_contains($lowerName, $key)) { $icon = $value; break; } }
                    @endphp
                    <div class="col-lg-3 col-md-4 col-6 reveal-up d{{ ($i % 4) + 1 }}">
                        <div class="svc-card">
                            <div class="svc-icon"><i class="bi {{ $icon }}"></i></div>
                            <h5>{{ $service->name }}</h5>
                            <p>{{ \Illuminate\Support\Str::limit($service->description, 90) }}</p>
                            <div class="svc-price">${{ number_format($service->price, 0) }}</div>
                        </div>
                    </div>
                @empty
                <div class="col-12 text-center py-5 reveal-up">
                    <i class="bi bi-gear fs-1 text-muted d-block mb-3" style="opacity:.2;"></i>
                    <p class="text-muted">Servicios disponibles próximamente.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- GALLERY --}}
    <section class="section-py section-cream" id="galeria">
        <div class="container">
            <div class="sec-header reveal-up">
                <div class="sec-overline">Nuestras Instalaciones</div>
                <h2>Galería</h2>
                <div class="line"></div>
                <p>Un recorrido visual por nuestros espacios</p>
            </div>
            @if(isset($gallery) && count($gallery))
                <div class="row gallery-grid">
                    @foreach($gallery as $i => $image)
                    <div class="col-lg-3 col-md-4 col-6 reveal-scale d{{ ($i % 4) + 1 }}">
                        <div class="g-item">
                            <img src="{{ asset('storage/' . ($image->value ?? $image->imagen ?? $image)) }}" alt="Galería">
                            <div class="g-zoom"><i class="bi bi-arrows-fullscreen"></i></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="gallery-empty reveal-up"><i class="bi bi-images d-block"></i><p>Galería en construcción</p></div>
            @endif
        </div>
    </section>

    {{-- ABOUT --}}
    <section class="section-py section-white" id="nosotros">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 reveal-left">
                    <div class="sec-header" style="text-align:left;margin-bottom:1.5rem;">
                        <div class="sec-overline" style="display:block;margin-bottom:.5rem;">Conócenos</div>
                        <h2>Sobre Nosotros</h2>
                        <div class="line" style="margin-left:0;"></div>
                    </div>
                    <p class="about-text">{{ $settings['about_text'] ?? 'Somos un hotel comprometido con brindar la mejor experiencia a nuestros huéspedes. Con instalaciones de primera clase y un equipo dedicado, nos esforzamos por superar sus expectativas en cada visita.' }}</p>
                    @if(!empty($settings['mission']))
                        <ul class="about-list"><li><i class="bi bi-bullseye"></i><div><strong>Misión:</strong> {{ $settings['mission'] }}</div></li></ul>
                    @endif
                    @if(!empty($settings['vision']))
                        <ul class="about-list"><li><i class="bi bi-eye"></i><div><strong>Visión:</strong> {{ $settings['vision'] }}</div></li></ul>
                    @endif
                    @if(!empty($settings['values']))
                        <ul class="about-list"><li><i class="bi bi-heart"></i><div><strong>Valores:</strong> {{ $settings['values'] }}</div></li></ul>
                    @endif
                </div>
                <div class="col-lg-5 reveal-right">
                    <div class="text-center">
                        <h4 style="font-family:'Playfair Display',serif;color:var(--primary);margin-bottom:1rem;">Síguenos</h4>
                        <p style="color:var(--text-light);margin-bottom:1.5rem;">Conéctate con nosotros en redes sociales</p>
                        <div class="social-links justify-content-center">
                            @if(!empty($settings['social_facebook']))<a href="{{ $settings['social_facebook'] }}" class="social-link fb" target="_blank"><i class="bi bi-facebook"></i></a>@endif
                            @if(!empty($settings['social_instagram']))<a href="{{ $settings['social_instagram'] }}" class="social-link ig" target="_blank"><i class="bi bi-instagram"></i></a>@endif
                            @if(!empty($settings['social_twitter']))<a href="{{ $settings['social_twitter'] }}" class="social-link tw" target="_blank"><i class="bi bi-twitter-x"></i></a>@endif
                            @if(!empty($settings['social_whatsapp']))<a href="https://wa.me/{{ $settings['social_whatsapp'] }}" class="social-link wa" target="_blank"><i class="bi bi-whatsapp"></i></a>@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CONTACT --}}
    <section class="section-py section-cream" id="contacto">
        <div class="container">
            <div class="sec-header reveal-up">
                <div class="sec-overline">Encuéntranos</div>
                <h2>Contacto y Ubicación</h2>
                <div class="line"></div>
                <p>Estamos listos para recibirte</p>
            </div>
            <div class="row g-4 mb-5">
                @if(!empty($settings['contact_address']))
                <div class="col-lg-3 col-md-6 reveal-up d1">
                    <div class="contact-card">
                        <div class="cc-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <h6>Dirección</h6>
                        <p>{{ $settings['contact_address'] }}</p>
                    </div>
                </div>
                @endif
                @if(!empty($settings['contact_phone']))
                <div class="col-lg-3 col-md-6 reveal-up d2">
                    <div class="contact-card">
                        <div class="cc-icon"><i class="bi bi-telephone-fill"></i></div>
                        <h6>Teléfono</h6>
                        <p>{{ $settings['contact_phone'] }}@if(!empty($settings['contact_phone2']))<br>{{ $settings['contact_phone2'] }}@endif</p>
                    </div>
                </div>
                @endif
                @if(!empty($settings['contact_email']))
                <div class="col-lg-3 col-md-6 reveal-up d3">
                    <div class="contact-card">
                        <div class="cc-icon"><i class="bi bi-envelope-fill"></i></div>
                        <h6>Correo</h6>
                        <p>{{ $settings['contact_email'] }}@if(!empty($settings['contact_email2']))<br>{{ $settings['contact_email2'] }}@endif</p>
                    </div>
                </div>
                @endif
                @if(!empty($settings['schedule_weekdays']))
                <div class="col-lg-3 col-md-6 reveal-up d4">
                    <div class="contact-card">
                        <div class="cc-icon"><i class="bi bi-clock-fill"></i></div>
                        <h6>Horario</h6>
                        <p>Lunes a Viernes: {{ $settings['schedule_weekdays'] }}<br>Fines de semana: {{ $settings['schedule_weekends'] ?? '24 horas' }}</p>
                    </div>
                </div>
                @endif
            </div>
            @if(!empty($settings['map_latitude']) && !empty($settings['map_longitude']))
            <div class="map-wrap reveal-scale">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3850!2d{{ $settings['map_longitude'] }}!3d{{ $settings['map_latitude'] }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x858b2bead53e5de3%3A0xf0d49f29f8b9ec5e!2sHotel%20Corona!5e0!3m2!1ses!2smx!4v1!5m2!1ses!2smx" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            @endif
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="footer-site">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 reveal-up d1">
                    <h5><i class="bi bi-gem" style="color:var(--accent);margin-right:.3rem;"></i> {{ $settings['hotel_name'] ?? 'InnovaCrown' }}</h5>
                    <p>{{ $settings['footer_text'] ?? 'Un hotel donde cada detalle está pensado para brindarte una experiencia única e inolvidable.' }}</p>
                </div>
                <div class="col-lg-2 col-md-6 reveal-up d2">
                    <h5>Navegación</h5>
                    <ul class="footer-links">
                        <li><a href="#servicios">Servicios</a></li>
                        <li><a href="#habitaciones">Habitaciones</a></li>
                        <li><a href="#galeria">Galería</a></li>
                        <li><a href="#nosotros">Sobre Nosotros</a></li>
                        <li><a href="#contacto">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 reveal-up d3">
                    <h5>Contacto</h5>
                    @if(!empty($settings['contact_address']))<div class="fc-item"><i class="bi bi-geo-alt-fill"></i><span>{{ $settings['contact_address'] }}</span></div>@endif
                    @if(!empty($settings['contact_phone']))<div class="fc-item"><i class="bi bi-telephone-fill"></i><span>{{ $settings['contact_phone'] }}</span></div>@endif
                    @if(!empty($settings['contact_phone2']))<div class="fc-item"><i class="bi bi-telephone-fill"></i><span>{{ $settings['contact_phone2'] }}</span></div>@endif
                    @if(!empty($settings['contact_email']))<div class="fc-item"><i class="bi bi-envelope-fill"></i><span>{{ $settings['contact_email'] }}</span></div>@endif
                    @if(!empty($settings['contact_email2']))<div class="fc-item"><i class="bi bi-envelope-fill"></i><span>{{ $settings['contact_email2'] }}</span></div>@endif
                </div>
                <div class="col-lg-3 col-md-6 reveal-up d4">
                    <h5>Horario</h5>
                    @if(!empty($settings['schedule_weekdays']))
                        <div class="fc-item"><i class="bi bi-clock-fill"></i><span>Lunes a Viernes: {{ $settings['schedule_weekdays'] }}<br>Fines de semana: {{ $settings['schedule_weekends'] ?? '24 horas' }}</span></div>
                    @else
                        <div class="fc-item"><i class="bi bi-clock-fill"></i><span>Recepción: 24 horas</span></div>
                    @endif
                </div>
            </div>
            <div class="footer-bottom">&copy; {{ date('Y') }} {{ $settings['hotel_name'] ?? 'InnovaCrown' }}. Todos los derechos reservados.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        /* ════════════════════════════════════════
           PRELOADER
        ════════════════════════════════════════ */
        function hidePreloader() {
            const p = document.getElementById('preloader');
            if (p && !p.classList.contains('loaded')) p.classList.add('loaded');
        }
        if (document.readyState === 'complete') {
            setTimeout(hidePreloader, 1500);
        } else {
            window.addEventListener('load', () => setTimeout(hidePreloader, 1500));
        }
        // Fallback: force hide preloader after 2.5s max
        setTimeout(hidePreloader, 2500);
        // Ultra-fallback: hide after 4s no matter what
        setTimeout(hidePreloader, 4000);

        /* ════════════════════════════════════════
           NAVBAR SCROLL
        ════════════════════════════════════════ */
        const nav = document.getElementById('mainNav');
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const y = window.scrollY;
            nav.classList.toggle('scrolled', y > 80);
            lastScroll = y;
        });

        /* ════════════════════════════════════════
           HERO PARALLAX ON SCROLL
        ════════════════════════════════════════ */
        const heroBg = document.getElementById('heroBg');
        window.addEventListener('scroll', () => {
            if (heroBg && window.scrollY < window.innerHeight) {
                heroBg.style.transform = `translateY(${window.scrollY * 0.35}px) scale(1.05)`;
            }
        });

        /* ════════════════════════════════════════
           SCROLL REVEAL
        ════════════════════════════════════════ */
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right, .reveal-scale, .reveal-rotate')
            .forEach(el => revealObserver.observe(el));

        /* ════════════════════════════════════════
           COUNTER ANIMATION
        ════════════════════════════════════════ */
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-target'));
                    const duration = 2000;
                    const startTime = performance.now();

                    function updateCounter(currentTime) {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        el.textContent = Math.round(target * eased) + '+';
                        if (progress < 1) requestAnimationFrame(updateCounter);
                    }
                    requestAnimationFrame(updateCounter);
                    counterObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.counter').forEach(el => counterObserver.observe(el));

        /* ════════════════════════════════════════
           MOBILE NAV CLOSE
        ════════════════════════════════════════ */
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                const c = document.getElementById('navbarContent');
                if (c.classList.contains('show')) new bootstrap.Collapse(c).hide();
            });
        });
        document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {
            item.addEventListener('click', () => {
                const c = document.getElementById('navbarContent');
                if (c.classList.contains('show')) new bootstrap.Collapse(c).hide();
            });
        });

        /* ════════════════════════════════════════
           ACTIVE NAV LINK
        ════════════════════════════════════════ */
        const sections = document.querySelectorAll('section[id]');
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY + 150;
            sections.forEach(s => {
                const link = document.querySelector(`.navbar-nav a[href="#${s.id}"]`);
                if (link) link.classList.toggle('active', scrollY >= s.offsetTop && scrollY < s.offsetTop + s.offsetHeight);
            });
        });

        /* ════════════════════════════════════════
           SMOOTH SCROLL
        ════════════════════════════════════════ */
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (!href || href === '#' || href.length < 2) return;
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const offset = 80;
                    const y = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: y, behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>