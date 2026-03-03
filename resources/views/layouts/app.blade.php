<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'EasyColoc')</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

  {{-- Tailwind (Play CDN) — no build/Vite required --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          boxShadow: {
            't': '0 -1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
            'orange': '0px 20px 20px -15px rgba(245,56,56,0.81)',
            'orange-md': '0px 20px 40px -15px rgba(245,56,56,0.81)'
          },
          colors: {
            black: { 500: '#4F5665', 600: '#0B132A' },
            orange: { 100: '#FFECEC', 500: '#F53855' },
            green: { 500: '#2FAB73' },
            white: { 300: '#F8F8F8', 500: '#fff' },
            gray: { 100: '#EEEFF2', 400: '#AFB5C0', 500: '#DDDDDD' }
          }
        }
      }
    }
  </script>

  {{-- Tailwind-aware custom CSS (ported from the template) --}}
  <style type="text/tailwindcss">
    @tailwind base;
    @tailwind components;
    @tailwind utilities;

    /* Design tokens / defaults (ported from LaslesVPN template) */
    html { font-family: "Rubik", system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }
    body { @apply bg-white-500 text-black-500; }

    p { @apply text-black-500; }

    /* Link underline animation (used in navbar) */
    .animation-hover:after {
      background: none repeat scroll 0 0 transparent;
      content: "";
      height: 2px;
      transition: width 0.3s ease 0s, left 0.3s ease 0s;
      @apply w-0 bg-orange-500 left-1/2 block bottom-0 absolute;
    }
    .animation-active:after { @apply left-0 w-full; }
    .animation-hover:hover:after { @apply left-0 w-full; }

    /* Custom list markers */
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
    }
    li.check:before {
      left: -0.5em;
      background-image: url("/assets/Icon/jam_check.svg");
      top: -0.5em;
      font-size: 400%;
    }
  </style>
</head>
<body class="min-h-screen">

  @include('partials.navbar')

  <main class="pt-28 pb-16">
    <div class="max-w-screen-xl px-6 sm:px-8 lg:px-16 mx-auto">
      @include('partials.flash')
      @yield('content')
    </div>
  </main>

  @include('partials.footer')
<script src="{{ asset('js/copy.js') }}"></script>
</body>
</html>
