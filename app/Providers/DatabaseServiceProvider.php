<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\SeedCommand;
use Illuminate\Contracts\Events\Dispatcher;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register the seed command
        $this->app->singleton('seeder', function ($app) {
            return new Seeder($app);
        });

        $this->app->singleton(SeedCommand::class, function ($app) {
            return new SeedCommand($app['db'], $app['seeder']);
        });

        $this->commands([
            SeedCommand::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register the database seeders
        $this->app->afterResolving('seeder', function (Seeder $seeder) {
            $seeder->setContainer($this->app);
            
            // Register the default database seeder
            $seeder->register(\Database\Seeders\DatabaseSeeder::class);
        });
    }
}
