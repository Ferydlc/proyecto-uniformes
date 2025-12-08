<?php

namespace Meze\UnifiedLogin\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        parent::register();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        parent::boot();

        // Cargar rutas
        $this->loadRoutesFrom(__DIR__ . '/../Routes/shop.php');

        // Cargar vistas
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'unifiedlogin');

        // Publicar vistas (opcional)
        $this->publishes([
            __DIR__ . '/../Resources/views' => resource_path('views/vendor/unifiedlogin'),
        ], 'unifiedlogin-views');
    }
}