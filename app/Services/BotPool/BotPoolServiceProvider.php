<?php

namespace App\Services\BotPool;

use App\Services\BotPool\Bot\CommandService;
use App\Services\BotPool\Bot\Genome;
use App\Services\BotPool\Bot\BotPopulation;
use App\Services\BotPool\Pool\Pool;
use Illuminate\Support\ServiceProvider;

class BotPoolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Pool::class, Pool::class);
        $this->app->singleton(BotPopulation::class, BotPopulation::class);
//        $this->app->bind(CommandService::class, function ($app) {
//            return new CommandService();
//        });


//        $this->app->bind(Genome::class, function ($app) {
//            return new Genome($app->make(CommandService::class));
//        });
    }
}
