<!DOCTYPE html>

<html
    class="{{ request()->cookie('dark_mode') ?? 0 ? 'dark' : '' }}"
    lang="{{ app()->getLocale() }}"
    dir="{{ core()->getCurrentLocale()->direction }}"
>

<head>
    {!! view_render_event('bagisto.admin.layout.head.before') !!}

    <title>{{ $title ?? '' }} - Colegio Meze Admin</title>

    <meta charset="UTF-8">

    <meta
        http-equiv="X-UA-Compatible"
        content="IE=edge"
    >
    <meta
        http-equiv="content-language"
        content="{{ app()->getLocale() }}"
    >
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <meta
        name="base-url"
        content="{{ url()->to('/') }}"
    >
    <meta
        name="currency"
        content="{{ core()->getBaseCurrency()->toJson() }}"
    >
    <meta 
        name="generator" 
        content="Bagisto"
    >

    @stack('meta')

    @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />

    <link
        rel="preload"
        as="image"
        href="{{ url('cache/logo/bagisto.png') }}"
    >

    @if ($favicon = core()->getConfigData('general.design.admin_logo.favicon'))
        <link
            type="image/x-icon"
            href="{{ Storage::url($favicon) }}"
            rel="shortcut icon"
            sizes="16x16"
        >
    @else
        <link
            type="image/x-icon"
            href="{{ bagisto_asset('images/favicon.ico') }}"
            rel="shortcut icon"
            sizes="16x16"
        />
    @endif

    @stack('styles')

 <style>
    /* Personalización Colegio Meze */
    :root {
        --meze-blue-primary: #1e3c72;
        --meze-blue-secondary: #2a5298;
        --meze-blue-light: #3b6bb8;
        --meze-blue-dark: #152a52;
    }

    body {
        font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    /* Personalizar colores del admin - MÁS ESPECÍFICO */
    .bg-blue-600,
    button.bg-blue-600,
    a.bg-blue-600,
    span.bg-blue-600 {
        background-color: var(--meze-blue-primary) !important;
    }

    .text-blue-600,
    a.text-blue-600 {
        color: var(--meze-blue-primary) !important;
    }

    .hover\:bg-blue-600:hover,
    button:hover.bg-blue-600 {
        background-color: var(--meze-blue-secondary) !important;
    }

    .border-blue-600,
    .border-b-blue-600 {
        border-color: var(--meze-blue-primary) !important;
    }

    /* Botones de acción principales */
    button.primary-button,
    .primary-button,
    button[class*="bg-blue"],
    .bg-blue-500,
    .bg-blue-600,
    .bg-blue-700 {
        background: linear-gradient(135deg, var(--meze-blue-primary) 0%, var(--meze-blue-secondary) 100%) !important;
        border: none !important;
        color: white !important;
    }

    button.primary-button:hover,
    .primary-button:hover,
    button[class*="bg-blue"]:hover {
        background: linear-gradient(135deg, var(--meze-blue-dark) 0%, var(--meze-blue-primary) 100%) !important;
    }

    /* Elementos con fondo azul en hover */
    .hover\:bg-blue-50:hover {
        background-color: rgba(30, 60, 114, 0.05) !important;
    }

    .hover\:bg-blue-100:hover {
        background-color: rgba(30, 60, 114, 0.1) !important;
    }

    /* Tabs y navegación */
    .border-b-2.border-blue-600 {
        border-bottom-color: var(--meze-blue-primary) !important;
    }

    /* Checkboxes y radio buttons */
    input[type="checkbox"]:checked,
    input[type="radio"]:checked {
        background-color: var(--meze-blue-primary) !important;
        border-color: var(--meze-blue-primary) !important;
    }

    /* Focus states */
    input:focus,
    textarea:focus,
    select:focus {
        border-color: var(--meze-blue-secondary) !important;
        ring-color: var(--meze-blue-light) !important;
    }

    /* Enlaces */
    a {
        transition: all 0.2s ease;
    }

    a:hover {
        opacity: 0.9;
    }

    /* Iconos activos del menú */
    .peer:has(+ .bg-blue-600) {
        color: white !important;
    }

    /* Suavizar transiciones */
    * {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
</style>

    {!! view_render_event('bagisto.admin.layout.head.after') !!}
</head>

<body class="h-full bg-gray-50 dark:bg-gray-950">
    {!! view_render_event('bagisto.admin.layout.body.before') !!}

    <div
        id="app"
        class="h-full"
    >
        <!-- Flash Message Blade Component -->
        <x-admin::flash-group />

        <!-- Confirm Modal Blade Component -->
        <x-admin::modal.confirm />

        {!! view_render_event('bagisto.admin.layout.content.before') !!}

        <!-- Page Header Blade Component -->
        <x-admin::layouts.header />

        <div
            class="group/container {{ request()->cookie('sidebar_collapsed') ?? 0 ? 'sidebar-collapsed' : 'sidebar-not-collapsed' }} flex flex-col lg:flex-row gap-0 lg:gap-4"
            ref="appLayout"
        >
            <!-- Page Sidebar Blade Component -->
            <div class="lg:fixed lg:top-[62px] lg:left-0 rtl:lg:right-0 rtl:lg:left-auto lg:z-10 w-full lg:w-auto">
                <x-admin::layouts.sidebar />
            </div>

            <div class="flex min-h-[calc(100vh-62px)] max-w-full flex-1 flex-col bg-white transition-all duration-300 dark:bg-gray-950 pt-3 px-2 sm:px-4 lg:pt-3 lg:px-4 lg:ltr:pl-[286px] lg:group-[.sidebar-collapsed]/container:ltr:pl-[85px] lg:rtl:pr-[286px] lg:group-[.sidebar-collapsed]/container:rtl:pr-[85px]">
                <!-- Added dynamic tabs for third level menus  -->
                <div class="pb-4 lg:pb-6">
                    @if (! request()->routeIs('admin.configuration.index'))
                        <div class="overflow-x-auto">
                            <x-admin::layouts.tabs />
                        </div>
                    @endif

                    <!-- Page Content Blade Component -->
                    <div class="w-full overflow-x-hidden">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Powered By -->
                <div class="mt-auto">
                    <div class="border-t bg-white py-3 text-center text-xs sm:text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                        <p class="text-gray-600 dark:text-gray-400">
                            © {{ date('Y') }} Colegio Meze - Panel de Administración
                        </p>
                        <p class="text-gray-500 dark:text-gray-500 text-xs mt-1">
                            Desarrollado con 
                            <a class="text-blue-600 hover:underline dark:text-blue-400" href="https://bagisto.com" target="_blank">Bagisto</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {!! view_render_event('bagisto.admin.layout.content.after') !!}
    </div>

    {!! view_render_event('bagisto.admin.layout.body.after') !!}

    @stack('scripts')

    {!! view_render_event('bagisto.admin.layout.vue-app-mount.before') !!}

    <script>
        window.addEventListener("load", function(event) {
            app.mount("#app");
        });
    </script>

    {!! view_render_event('bagisto.admin.layout.vue-app-mount.after') !!}
</body>

</html>