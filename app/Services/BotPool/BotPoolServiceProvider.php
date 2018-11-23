<?php

namespace App\Services\BotPool;

use App\Services\BotPool\Bot\Bot;
use App\Services\BotPool\Bot\CommandService;
use App\Services\BotPool\Bot\Genome;
use App\Services\BotPool\Bot\Population;
use App\Services\BotPool\Pool\Pool;
use App\Services\BotPool\Pool\PoolPixel;
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
        $this->app->bind(CommandService::class, function ($app) {
            return new CommandService();
        });

        $this->app->bind(Genome::class, function ($app) {
            return new Genome($app->make(CommandService::class));
        });

        $this->app->bind(Bot::class, function ($app) {
//он здесь не нужен - выпилить и создавать при создании первого организма. следующие только клонированием
            return new Bot($app->make(Genome::class));
        });

        $this->app->bind(Pool::class, function ($app) {
            $width = 5;
            $height = 3;
            $poolPoints = [];
            for ($i=1; $i<=$width; $i++) {
                for ($j=1; $j<=$height; $j++) {
                    $poolPoints[] = new PoolPixel($i, $j);
                }
            }
            return new Pool(collect($poolPoints));
        });

        $this->app->bind(Population::class, function ($app) {
            return new Population();
        });
    }
}
