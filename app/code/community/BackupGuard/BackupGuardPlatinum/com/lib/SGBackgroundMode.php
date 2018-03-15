<?php

class SGBackgroundMode
{
    const DELAY = 200000; //in microseconds (1 second = 1000000 microseconds)

    public static function next()
    {
        usleep(self::DELAY);
    }
}
