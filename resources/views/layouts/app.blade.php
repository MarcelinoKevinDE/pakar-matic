<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PakarMatik — Sistem Pakar Kerusakan Motor')</title>

    <!-- Google Fonts: Bebas Neue (display) + IBM Plex Mono (body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=IBM+Plex+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ====================================================================
           NEUBRUTALISM DESIGN TOKENS
        ==================================================================== */
        :root {
            --black:     #0a0a0a;
            --white:     #fafaf8;
            --yellow:    #FFE047;
            --red:       #FF3B2F;
            --blue:      #1A5CFF;
            --green:     #00C060;
            --orange:    #FF7020;
            --paper:     #FFF9EC;
            --border:    3px solid #0a0a0a;
            --shadow:    5px 5px 0px #0a0a0a;
            --shadow-lg: 8px 8px 0px #0a0a0a;
            --radius:    0px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'IBM Plex Mono', monospace;
            background-color: var(--paper);
            color: var(--black);
            background-image:
                radial-gradient(circle, #0a0a0a 1px, transparent 1px);
            background-size: 28px 28px;
            min-height: 100vh;
        }

        /* ====================================================================
           TYPOGRAPHY
        ==================================================================== */
        h1, h2, h3, h4, h5, h6,
        .display, .nav-brand {
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 0.04em;
            line-height: 1;
        }

        /* ====================================================================
           NAVBAR
        ==================================================================== */
        .nb-nav {
            background: var(--black);
            border-bottom: var(--border);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nb-nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: stretch;
            min-height: 60px;
        }

        .nb-nav-brand {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.6rem;
            color: var(--yellow);
            letter-spacing: 0.06em;
            display: flex;
            align-items: center;
            padding-right: 2rem;
            border-right: 2px solid #333;
            text-decoration: none;
        }

        .nb-nav-brand span { color: var(--white); }

        .nb-nav-links {
            display: flex;
            align-items: stretch;
            list-style: none;
            margin-left: auto;
        }

        .nb-nav-links li a {
            display: flex;
            align-items: center;
            padding: 0 1.25rem;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border-left: 2px solid transparent;
            transition: color 0.15s, background 0.15s;
        }

        .nb-nav-links li a:hover,
        .nb-nav-links li a.active {
            color: var(--yellow);
            background: rgba(255,224,71,0.06);
            border-left-color: var(--yellow);
        }

        /* ====================================================================
           CONTAINER
        ==================================================================== */
        .nb-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ====================================================================
           CARDS — thick border + flat shadow
        ==================================================================== */
        .nb-card {
            background: var(--white);
            border: var(--border);
            box-shadow: var(--shadow);
            padding: 1.5rem;
        }

        .nb-card-yellow  { background: var(--yellow); }
        .nb-card-black   { background: var(--black); color: var(--white); }
        .nb-card-red     { background: var(--red); color: var(--white); }
        .nb-card-blue    { background: var(--blue); color: var(--white); }
        .nb-card-green   { background: var(--green); }
        .nb-card-orange  { background: var(--orange); color: var(--white); }

        /* ====================================================================
           BUTTONS
        ==================================================================== */
        .nb-btn {
            display: inline-block;
            padding: 0.75rem 1.75rem;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            border: var(--border);
            box-shadow: var(--shadow);
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.1s, box-shadow 0.1s;
            background: var(--yellow);
            color: var(--black);
        }

        .nb-btn:hover {
            transform: translate(-2px, -2px);
            box-shadow: 7px 7px 0px var(--black);
            color: var(--black);
            text-decoration: none;
        }

        .nb-btn:active {
            transform: translate(3px, 3px);
            box-shadow: 2px 2px 0px var(--black);
        }

        .nb-btn-black { background: var(--black); color: var(--white); }
        .nb-btn-black:hover { color: var(--white); }

        .nb-btn-red { background: var(--red); color: var(--white); }
        .nb-btn-red:hover { color: var(--white); }

        .nb-btn-blue { background: var(--blue); color: var(--white); }
        .nb-btn-blue:hover { color: var(--white); }

        .nb-btn-white { background: var(--white); color: var(--black); }
        .nb-btn-sm { padding: 0.45rem 1rem; font-size: 0.72rem; }

        .nb-btn-outline {
            background: transparent;
            color: var(--black);
        }

        /* ====================================================================
           FORM ELEMENTS
        ==================================================================== */
        .nb-input {
            width: 100%;
            padding: 0.75rem 1rem;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.85rem;
            border: var(--border);
            background: var(--white);
            color: var(--black);
            outline: none;
            transition: box-shadow 0.15s;
        }

        .nb-input:focus {
            box-shadow: 4px 4px 0px var(--black);
        }

        .nb-input::placeholder { color: #888; }

        .nb-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 0.4rem;
        }

        /* Checkbox row */
        .nb-check-row {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.85rem 1rem;
            border: 2px solid var(--black);
            background: var(--white);
            cursor: pointer;
            transition: background 0.1s;
            margin-bottom: -2px; /* collapse borders */
        }

        .nb-check-row:hover,
        .nb-check-row.checked { background: var(--yellow); }

        .nb-check-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border: 2px solid var(--black);
            accent-color: var(--black);
            flex-shrink: 0;
            margin-top: 2px;
            cursor: pointer;
        }

        .nb-check-label { font-size: 0.82rem; line-height: 1.4; }
        .nb-check-code  { font-size: 0.7rem; color: #555; display: block; margin-top: 2px; }

        /* ====================================================================
           BADGES
        ==================================================================== */
        .nb-badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border: 2px solid var(--black);
        }

        .badge-high     { background: var(--green); }
        .badge-med-high { background: var(--blue); color: var(--white); }
        .badge-medium   { background: var(--yellow); }
        .badge-low      { background: #ccc; }

        /* ====================================================================
           TABLE
        ==================================================================== */
        .nb-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
        }

        .nb-table th {
            background: var(--black);
            color: var(--yellow);
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.7rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            border: 2px solid var(--black);
        }

        .nb-table td {
            padding: 0.75rem 1rem;
            border: 2px solid var(--black);
            vertical-align: top;
            background: var(--white);
        }

        .nb-table tr:hover td { background: #fff9d8; }

        /* ====================================================================
           SECTION HEADER STRIP
        ==================================================================== */
        .nb-section-header {
            background: var(--black);
            color: var(--yellow);
            padding: 0.6rem 1.25rem;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.1rem;
            letter-spacing: 0.08em;
            border: var(--border);
            margin-bottom: -3px;
        }

        /* ====================================================================
           STAT TILE
        ==================================================================== */
        .nb-stat {
            padding: 1.5rem;
            border: var(--border);
            box-shadow: var(--shadow);
        }

        .nb-stat-value {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3.5rem;
            line-height: 1;
        }

        .nb-stat-label {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-top: 0.3rem;
            opacity: 0.8;
        }

        /* ====================================================================
           PROGRESS BAR
        ==================================================================== */
        .nb-bar-track {
            height: 20px;
            background: #e0e0d8;
            border: 2px solid var(--black);
            overflow: hidden;
        }

        .nb-bar-fill {
            height: 100%;
            background: var(--yellow);
            border-right: 2px solid var(--black);
            transition: width 1s cubic-bezier(.4,0,.2,1);
            width: 0;
        }

        .nb-bar-fill.fill-green  { background: var(--green); }
        .nb-bar-fill.fill-blue   { background: var(--blue); }
        .nb-bar-fill.fill-red    { background: var(--red); }
        .nb-bar-fill.fill-orange { background: var(--orange); }

        /* ====================================================================
           MODAL
        ==================================================================== */
        .nb-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .nb-modal-overlay.open { display: flex; }

        .nb-modal {
            background: var(--white);
            border: var(--border);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 700px;
            max-height: 88vh;
            overflow-y: auto;
        }

        .nb-modal-header {
            background: var(--black);
            color: var(--yellow);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
        }

        .nb-modal-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.4rem;
            letter-spacing: 0.06em;
        }

        .nb-modal-close {
            background: var(--yellow);
            border: 2px solid var(--yellow);
            color: var(--black);
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            padding: 0.15rem 0.6rem;
            line-height: 1;
        }

        .nb-modal-body { padding: 1.5rem; }

        /* ====================================================================
           STEP BLOCK
        ==================================================================== */
        .nb-step {
            display: flex;
            gap: 1rem;
            padding: 0.75rem 1rem;
            border: 2px solid var(--black);
            background: var(--white);
            margin-bottom: -2px;
        }

        .nb-step-num {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.4rem;
            color: var(--red);
            min-width: 2rem;
            text-align: center;
            line-height: 1;
        }

        .nb-step-body { font-size: 0.78rem; line-height: 1.6; }
        .nb-step-formula { font-size: 0.72rem; color: #444; margin-top: 0.25rem; }

        /* ====================================================================
           ALERT
        ==================================================================== */
        .nb-alert {
            padding: 1rem 1.25rem;
            border: var(--border);
            font-size: 0.82rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .nb-alert-error  { background: #FFE0DE; border-color: var(--red); }
        .nb-alert-warn   { background: var(--yellow); }
        .nb-alert-success{ background: #D6FFE6; border-color: var(--green); }

        .nb-alert-title {
            font-weight: 700;
            font-size: 0.72rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 0.4rem;
        }

        /* ====================================================================
           HERO BANNER
        ==================================================================== */
        .nb-hero {
            background: var(--black);
            border-bottom: var(--border);
            padding: 2.5rem 0 2rem;
            position: relative;
            overflow: hidden;
        }

        .nb-hero::before {
            content: '';
            position: absolute;
            right: 0; top: 0;
            width: 340px; height: 100%;
            background: var(--yellow);
            clip-path: polygon(30% 0%, 100% 0%, 100% 100%, 0% 100%);
            opacity: 0.12;
        }

        .nb-hero-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3rem;
            color: var(--white);
            letter-spacing: 0.06em;
            line-height: 1;
        }

        .nb-hero-title span { color: var(--yellow); }

        .nb-hero-sub {
            color: rgba(255,255,255,0.6);
            font-size: 0.78rem;
            margin-top: 0.6rem;
            letter-spacing: 0.04em;
        }

        /* ====================================================================
           UTILITY
        ==================================================================== */
        .grid   { display: grid; }
        .g-3    { gap: 1rem; }
        .g-4    { gap: 1.5rem; }
        .cols-2 { grid-template-columns: repeat(2, 1fr); }
        .cols-3 { grid-template-columns: repeat(3, 1fr); }
        .cols-4 { grid-template-columns: repeat(4, 1fr); }
        .cols-7-5 { grid-template-columns: 7fr 5fr; }
        .cols-6-4 { grid-template-columns: 6fr 4fr; }

        .mt-1 { margin-top: 0.4rem; }
        .mt-2 { margin-top: 0.8rem; }
        .mt-3 { margin-top: 1.2rem; }
        .mt-4 { margin-top: 1.75rem; }
        .mt-5 { margin-top: 2.5rem; }
        .mb-1 { margin-bottom: 0.4rem; }
        .mb-2 { margin-bottom: 0.8rem; }
        .mb-3 { margin-bottom: 1.2rem; }
        .mb-4 { margin-bottom: 1.75rem; }
        .mb-5 { margin-bottom: 2.5rem; }

        .py-5 { padding-top: 2.5rem; padding-bottom: 2.5rem; }
        .py-4 { padding-top: 1.75rem; padding-bottom: 1.75rem; }

        .text-sm   { font-size: 0.78rem; }
        .text-xs   { font-size: 0.7rem; }
        .text-muted { color: #666; }
        .fw-700    { font-weight: 700; }
        .upper     { text-transform: uppercase; letter-spacing: 0.08em; }
        .mono      { font-family: 'IBM Plex Mono', monospace; }

        .flex          { display: flex; }
        .flex-center   { display: flex; align-items: center; }
        .flex-between  { display: flex; align-items: center; justify-content: space-between; }
        .gap-1         { gap: 0.4rem; }
        .gap-2         { gap: 0.8rem; }
        .gap-3         { gap: 1.2rem; }

        .w-100 { width: 100%; }
        .text-center { text-align: center; }
        .text-right  { text-align: right; }

        /* ====================================================================
           FOOTER
        ==================================================================== */
        .nb-footer {
            background: var(--black);
            border-top: var(--border);
            color: rgba(255,255,255,0.45);
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            text-align: center;
            padding: 1.25rem;
            margin-top: 4rem;
        }

        .nb-footer a { color: var(--yellow); text-decoration: none; }

        /* ====================================================================
           RESPONSIVE
        ==================================================================== */
        @media (max-width: 768px) {
            .cols-2, .cols-3, .cols-4,
            .cols-7-5, .cols-6-4 { grid-template-columns: 1fr; }
            .nb-hero-title { font-size: 2rem; }
            .nb-nav-links { display: none; }
        }

        /* ====================================================================
           SCROLLBAR
        ==================================================================== */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--paper); }
        ::-webkit-scrollbar-thumb { background: var(--black); }
    </style>

    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="nb-nav">
    <div class="nb-nav-inner">
        <a href="{{ route('diagnosa.index') }}" class="nb-nav-brand">
            PAKAR<span>MATIK</span>
        </a>
        <ul class="nb-nav-links">
            <li>
                <a href="{{ route('diagnosa.index') }}"
                   class="{{ request()->routeIs('diagnosa.*') ? 'active' : '' }}">
                    Diagnosis
                </a>
            </li>
            <li>
                <a href="{{ route('about') }}"
                   class="{{ request()->routeIs('about') ? 'active' : '' }}">
                    Tentang
                </a>
            </li>
            @auth
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    Admin
                </a>
            </li>
            @endauth
        </ul>
    </div>
</nav>

<!-- MAIN -->
<main>
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="nb-footer">
    &copy; {{ date('Y') }} PAKARMATIK &mdash;
    SISTEM PAKAR KERUSAKAN MOTOR &mdash;
    METODE <a href="#">CERTAINTY FACTOR</a> &mdash;
    LARAVEL {{ app()->version() }} &mdash;
    By Marcelino Kevin D.E
</footer>
@stack('scripts')
</body>
</html>