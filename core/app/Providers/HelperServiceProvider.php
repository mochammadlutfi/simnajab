<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/GeneralHelp.php';
        require_once app_path() . '/Helpers/MapJembatan.php';
        require_once app_path() . '/Helpers/MapDrainase.php';
        // require_once app_path() . '/Helpers/MapJalan.php';
        require_once app_path() . '/Helpers/MapTPT.php';
        require_once app_path() . '/Helpers/MapBeton.php';
        require_once app_path() . '/Helpers/PenganggaranHelp.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}