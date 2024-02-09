<?php

use SajedZarinpour\Spotplayer\SpotPlayer;
/**
 * Adding helper functionality to the package. The following calls are equivalent.
 * ```
 *      SpotPlayer::some_func()
 * ```
 * vs
 * ```
 *      spotplayer()->some_func()
 * ```
 */
if (! function_exists('spotplayer')) {
    function spotplayer(): SpotPlayer
    {
        return new SpotPlayer();
    }
}