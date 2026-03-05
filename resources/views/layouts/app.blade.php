<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'EasyColoc')</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

  <script>
    (function () {
      const root = document.documentElement;
      root.classList.remove('theme-modern');
      root.classList.add('theme-classic');
      root.dataset.theme = 'classic';
    })();
  </script>

  {{-- Tailwind (Play CDN) — no build/Vite required --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'Rubik', 'system-ui', '-apple-system', 'sans-serif'],
          },
          boxShadow: {
            't': '0 -1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
            'orange': '0px 20px 20px -15px rgba(245,56,56,0.81)',
            'orange-md': '0px 20px 40px -15px rgba(245,56,56,0.81)',
            'orange-glow': '0 0 20px rgba(245,56,56,0.4)',
            'card': '0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03)',
            'card-hover': '0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04)',
          },
          colors: {
            black: { 500: '#475569', 600: '#0F172A' }, /* Softer slate instead of harsh black */
            orange: { 50: '#fff1f2', 100: '#ffe4e6', 400: '#fb7185', 500: '#F53855', 600: '#e11d48' },
            green: { 50: '#ecfdf5', 100: '#d1fae5', 500: '#2FAB73', 600: '#059669' },
            white: { DEFAULT: '#fff', 300: '#F8FAFC', 500: '#fff' },
            gray: { 50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 400: '#94a3b8', 500: '#64748b' },
          }
        }
      }
    }
  </script>

  {{-- Global styles --}}
  <style type="text/tailwindcss">
    @tailwind base;
    @tailwind components;
    @tailwind utilities;

    /* ─── Base ─────────────────────────────────────────────── */
    html {
      font-family: 'Inter', 'Rubik', system-ui, sans-serif;
      scroll-behavior: smooth;
    }

    :root {
      color-scheme: light;
    }
    
    /* Universal smooth transitions for a premium feel */
    *, *::before, *::after {
      transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
      transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
      transition-duration: 300ms;
    }
    
    body {
      @apply bg-slate-50 text-black-500 antialiased selection:bg-orange-500/20 selection:text-orange-600;
    }

    p { @apply text-black-500 leading-relaxed; }

    html.theme-modern body {
      background-image:
        radial-gradient(1200px 420px at -10% -20%, rgba(251, 113, 133, 0.16), transparent 55%),
        radial-gradient(860px 360px at 110% 0%, rgba(56, 189, 248, 0.14), transparent 58%),
        linear-gradient(180deg, #f8fafc 0%, #f1f5f9 70%, #eef2ff 100%);
      background-attachment: fixed;
    }

    html.theme-modern .ec-card {
      border-color: rgba(148, 163, 184, 0.22);
      background: linear-gradient(150deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.86) 100%);
      box-shadow: 0 18px 45px -30px rgba(15, 23, 42, 0.55);
      backdrop-filter: blur(6px);
    }

    html.theme-modern .ec-card:hover {
      box-shadow: 0 26px 70px -38px rgba(15, 23, 42, 0.52);
    }

    html.theme-modern .ec-btn-primary {
      box-shadow:
        0 14px 30px -14px rgba(244, 63, 94, 0.75),
        inset 0 1px 0 rgba(255, 255, 255, 0.35);
    }

    html.theme-modern .ec-btn-outline {
      border-color: rgba(244, 63, 94, 0.45);
      background-color: rgba(255, 255, 255, 0.86);
    }

    html.theme-modern .ec-btn-outline:hover {
      box-shadow: 0 14px 28px -20px rgba(244, 63, 94, 0.7);
    }

    html.theme-modern .ec-badge {
      backdrop-filter: blur(6px);
    }

    html.theme-modern input:not([type="checkbox"]):not([type="radio"]),
    html.theme-modern select,
    html.theme-modern textarea {
      border-color: rgba(148, 163, 184, 0.38) !important;
      background-color: rgba(255, 255, 255, 0.82) !important;
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.65), 0 10px 35px -30px rgba(15, 23, 42, 0.58);
    }

    html.theme-modern input:not([type="checkbox"]):not([type="radio"]):focus,
    html.theme-modern select:focus,
    html.theme-modern textarea:focus {
      border-color: rgba(244, 63, 94, 0.55) !important;
      box-shadow:
        0 0 0 4px rgba(244, 63, 94, 0.08),
        inset 0 1px 0 rgba(255, 255, 255, 0.7),
        0 16px 36px -30px rgba(244, 63, 94, 0.7);
    }

    html.theme-modern table {
      border-collapse: separate;
      border-spacing: 0 0.45rem;
    }

    html.theme-modern table thead tr,
    html.theme-modern table thead th {
      border: 0 !important;
    }

    html.theme-modern table tbody tr {
      background: rgba(255, 255, 255, 0.76);
      box-shadow: 0 14px 30px -28px rgba(15, 23, 42, 0.48);
    }

    html.theme-modern table tbody tr td {
      border-top: 1px solid rgba(226, 232, 240, 0.82);
      border-bottom: 1px solid rgba(226, 232, 240, 0.82);
    }

    html.theme-modern table tbody tr td:first-child {
      border-left: 1px solid rgba(226, 232, 240, 0.82);
      border-top-left-radius: 0.85rem;
      border-bottom-left-radius: 0.85rem;
    }

    html.theme-modern table tbody tr td:last-child {
      border-right: 1px solid rgba(226, 232, 240, 0.82);
      border-top-right-radius: 0.85rem;
      border-bottom-right-radius: 0.85rem;
    }

    html.theme-modern table tbody tr:hover {
      transform: translateY(-1px);
      background: rgba(255, 255, 255, 0.95);
    }

    .theme-switch {
      @apply inline-flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-sm font-bold text-slate-600 hover:text-slate-800 hover:border-orange-400;
      background: rgba(255, 255, 255, 0.72);
      backdrop-filter: blur(8px);
    }

    html.theme-modern .theme-switch {
      border-color: rgba(251, 113, 133, 0.34);
      background: linear-gradient(145deg, rgba(255, 255, 255, 0.85), rgba(255, 241, 242, 0.72));
      box-shadow: 0 10px 20px -18px rgba(244, 63, 94, 0.7);
    }

    html.theme-modern .theme-switch:hover {
      box-shadow: 0 16px 30px -18px rgba(244, 63, 94, 0.72);
    }

    /* ─── Nav link underline animation ─────────────────────── */
    .animation-hover:after {
      background: none repeat scroll 0 0 transparent;
      content: "";
      height: 2px;
      transition: width 0.3s ease 0s, left 0.3s ease 0s;
      @apply w-0 bg-gradient-to-r from-orange-400 to-orange-600 left-1/2 block bottom-0 absolute rounded-t-sm;
    }
    .animation-active:after { @apply left-0 w-full; }
    .animation-hover:hover:after { @apply left-0 w-full; }

    /* ─── Custom list markers ───────────────────────────────── */
    li.custom-list:before {
      content: "\2022";
      text-indent: -9999999px;
      width: 0.4em;
      height: 1em;
      background-repeat: no-repeat;
      background-size: 0.4em 0.7em;
      background-position: 0 0.3em;
      font-size: 300%;
      top: -0.35em;
      @apply absolute block;
    }
    li.circle-check:before {
      background-image: url("/assets/Icon/checklist.svg");
      left: -0.7em;
      top: -0.4em;
      transition: transform 0.3s ease;
    }
    li.circle-check:hover:before {
      transform: scale(1.1);
    }
    li.check:before {
      left: -0.5em;
      background-image: url("/assets/Icon/jam_check.svg");
      top: -0.5em;
      font-size: 400%;
    }

    /* ─── Form Inputs ───────────────────────────────────────── */
    input, textarea, select {
      @apply transition-all duration-300 ease-out;
    }

    /* ─── Scrollbar (subtle & premium) ─────────────────────── */
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { @apply bg-transparent; }
    ::-webkit-scrollbar-thumb { @apply bg-gray-200 rounded-full border-2 border-slate-50 hover:bg-gray-300; }

    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
      }
    }
  </style>
</head>
<body class="min-h-screen flex flex-col transition-colors duration-500">

  @include('partials.navbar')

  <main class="pt-28 pb-16 flex-grow">
    <div class="max-w-screen-xl px-6 sm:px-8 lg:px-16 mx-auto">
      @include('partials.flash')
      @yield('content')
    </div>
  </main>

  @include('partials.footer')
  <script src="{{ asset('js/copy.js') }}"></script>
</body>
</html>
