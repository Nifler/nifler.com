<?php

namespace App\Services\BotPool;

class Bot
{
    private $energi;
    private $latitude;
    private $longitude;
    private $genome;

    private function setCoordinates(int $latitude, int $longitude):void
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    private function setGenomeMutation(): void
    {
        if (mt_rand(1,4) >= 4) {
            $this->genome->mutate();
        }
    }

    public function __construct(Genome $genome, $latitude = 0, $longitude = 0)
    {
        $this->energi = 0;
        $this->setCoordinates($latitude, $longitude);
        $this->genome = $genome;
        $this->setGenomeMutation();
    }


}