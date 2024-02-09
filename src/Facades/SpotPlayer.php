<?php

namespace SajedZarinpour\Spotplayer\Facades;

use Illuminate\Support\Facades\Facade;

class SpotPlayer extends Facade
{
    /** Declaring the accessor for this Facade. */
    protected static function getFacadeAccessor()
    {
      return 'spot-player';
    }  
}
