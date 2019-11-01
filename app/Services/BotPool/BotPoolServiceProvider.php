<?php

namespace App\Services\BotPool;

use App\Services\BotPool\Command\CommandService;
use App\Services\BotPool\Bot\BotPopulation;
use App\Services\BotPool\Pool\Pool;
use Illuminate\Support\ServiceProvider;

class BotPoolServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Pool::class, Pool::class);
        $this->app->singleton(BotPopulation::class, BotPopulation::class);
        $this->app->singleton(CommandService::class, CommandService::class);
    }
}
