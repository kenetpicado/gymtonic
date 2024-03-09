<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <meta name="title" content="{{ config('app.name', 'Laravel') }} - Inicio" />
    <meta name="description"
        content="Tu destino para un entrenamiento de primer nivel. Clases dirigidas, entrenamiento personalizado y equipos de última generación. Únete hoy y alcanza tus metas. Tu gym, tu transformación." />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://alonsogym.com" />
    <meta property="og:title" content="{{ config('app.name', 'Laravel') }} - Inicio" />
    <meta property="og:description"
        content="Tu destino para un entrenamiento de primer nivel. Clases dirigidas, entrenamiento personalizado y equipos de última generación. Únete hoy y alcanza tus metas. Tu gym, tu transformación." />
    <meta property="og:image" content="https://i.postimg.cc/QdKtqnrz/logo-ag.png" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://alonsogym.com" />
    <meta property="twitter:title" content="{{ config('app.name', 'Laravel') }} - Inicio" />
    <meta property="twitter:description"
        content="Tu destino para un entrenamiento de primer nivel. Clases dirigidas, entrenamiento personalizado y equipos de última generación. Únete hoy y alcanza tus metas. Tu gym, tu transformación." />
    <meta property="twitter:image" content="https://i.postimg.cc/QdKtqnrz/logo-ag.png" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
