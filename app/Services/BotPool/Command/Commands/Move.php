<?php

namespace App\Services\BotPool\Command\Commands;

use Illuminate\Support\Collection;

class Move extends AbstractCommand
{
    protected $necessaryEnergy = 1;

    private function foo(int $dir): array
    {
        switch ($dir) {
            case 0:
                return [
                    'y' => -1,
                    'x' => 0
                ];
            case 1:
                return [
                    'y' => -1,
                    'x' => 1
                ];
            case 2:
                return [
                    'y' => 0,
                    'x' => 1
                ];
            case 3:
                return [
                    'y' => 1,
                    'x' => 1
                ];
            case 4:
                return [
                    'y' => 1,
                    'x' => 0
                ];
            case 5:
                return [
                    'y' => 1,
                    'x' => -1
                ];
            case 6:
                return [
                    'y' => 0,
                    'x' => -1
                ];
            case 7:
                return [
                    'y' => -1,
                    'x' => -1
                ];
            default:
                throw new \Exception('Wrong direction ' . $dir);
        }
    }

    private function getCoordinateChange(array $genome, int $commandId): array
    {
        $dir = $genome[$commandId] % 8;
        for ($i = 0; $i < 8; $i++) {
            $direction = $this->foo($dir);
            $area = $this->poolInfo['area'];

            if($area[$direction['y']][$direction['x']] === 0) {
                return $direction;
            }
            $dir = ($dir + 1) % 8;
        }
        $this->necessaryEnergy = 0;
        return [0,0];
    }

    public function getInfoList(): array
    {
        $res = [
            'bot' => [
                'genome' => true,
                'commandId' => true,
                'energy' => true
            ],
            'pool' => [
                'area' => 1
            ]
        ];

        return $res;
    }

    public function run(): array
    {
        if (!$this->checkEnergyForRun()) {
            throw new \Exception('need more energy');
        }

        $coordinateChange = $this->getCoordinateChange(
            $this->botInfo['genome'],
            $this->botInfo['commandId']
        );

        $energyChange = -$this->necessaryEnergy;

        return [
            'pool' => [
                'coordinateChange' => $coordinateChange
            ],
            'bot' => [
                'energyChange' => $energyChange
            ]
        ];
    }

    protected function checkEnergyForRun()
    {
        return $this->botInfo['energy'] - $this->necessaryEnergy >= 0;
    }
}
