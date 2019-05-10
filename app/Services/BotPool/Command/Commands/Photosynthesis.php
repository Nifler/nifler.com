<?php

namespace App\Services\BotPool\Command\Commands;

class Photosynthesis extends AbstractCommand
{
    private function getEnergy()
    {
        return 2;
    }

    public function getInfoList(): array
    {
        $res = [
            'bot' => [
            ],
            'pool' => [
                'y' => true
            ]
        ];

        return $res;
    }

    public function run(): array
    {
        return [
            'pool' => [],
            'bot' => ['energyChange' => $this->getEnergy()]
        ];
    }
}
