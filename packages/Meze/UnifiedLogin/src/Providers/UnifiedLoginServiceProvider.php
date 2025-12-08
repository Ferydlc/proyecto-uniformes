<?php

namespace Meze\UnifiedLogin\Providers;

use Illuminate\Support\ServiceProvider;

class UnifiedLoginServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Cargar rutas
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        // Cargar vistas
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'unifiedlogin');
    }

    public function boot()
{
    $this->loadRoutesFrom(__DIR__ . '/../Routes/shop.php');

    $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'unifiedlogin');
}

}
