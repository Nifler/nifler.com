<?php

namespace App\Services\BotPool\Command\Commands;

use Illuminate\Support\Collection;

class Move implements CommandInterface
{

    private $botInfoMap = [
        "latitude",
        "longitude",
        "energy"
    ];

    private $botInfo;

    private $changesOfBotInfo;

    private function checkBotInfo(Collection $botInfo)
    {
        $diff = array_diff($this->botInfoMap, $botInfo->keys()->all());
        if (!empty($diff)) {
            $message =
                'Command '
                . self::class
                . ' don\'t have enough data in botInfo. '
                . implode(',', $diff)
                . ' are needed.';
            throw new \Exception($message);// переделать с нормальными исключениями
        }

        $this->botInfo = $botInfo;
    }

    private function getDirection()
    {
        // получать с генома и проверить есть ли место.
        // если нет - переполучить. также проверить не конец ли карты по высоте.
        return rand(1, 8);
    }

    private function getPositionChanges(int $direction)
    {
        // если да, то движение должно быть круговым(умножаем х на ширину пула)
        switch ($direction) {
            case 1:
                return [0, -1];
            case 2:
                return [1, -1];
            case 3:
                return [1, 0];
            case 4:
                return [1, 1];
            case 5:
                return [0, 1];
            case 6:
                return [-1, 1];
            case 7:
                return [-1, 0];
            case 8:
                return [-1, -1];
            default:
                throw new \Exception('Wrong direction '.$direction);
        }
    }

    private function changePosition()
    {
        $positionChanges = $this->getPositionChanges($this->getDirection());

        dd($this->changesOfBotInfo);
        $this->changesOfBotInfo->put('latitude', $positionChanges[0]);
        $this->changesOfBotInfo->put('longitude', $positionChanges[1]);

        //Обовить состояние пула (освободить предыдущий пиксель и занять новый)
    }

    private function changeBotInfo()
    {
        $this->changePosition();
        // смена енергии
    }

    public function getInfoList(): array
    {
        $res = [
            'bot' => [
                'genom' => true,
                'commandId' => true
            ],
            'pool' => [
                'area' => 1
            ]
        ];

        return $res;
    }
}
