<?php

namespace BotMan\Drivers\QRInstance\Providers;

use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\QRInstance\QRInstanceDriver;
use BotMan\Studio\Providers\StudioServiceProvider;
use Illuminate\Support\ServiceProvider;

class QRInstanceServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->isRunningInBotManStudio()) {
            $this->loadDrivers();

            $this->publishes([
                __DIR__.'/../../stubs/QRInstance.php' => config_path('botman/QRInstance.php'),
            ]);

            $this->mergeConfigFrom(__DIR__.'/../../stubs/QRInstance.php', 'botman.QRInstance');
        }

    }

    /**
     * Load BotMan drivers.
     */
    protected function loadDrivers()
    {
        DriverManager::loadDriver(QRInstanceDriver::class);
    }

    /**
     * @return bool
     */
    protected function isRunningInBotManStudio()
    {
        return class_exists(StudioServiceProvider::class);
    }
}
