<?php

use Illuminate\Support\Facades\Route;

use SajedZarinpour\Spotplayer\Controllers\SpotPlayerController;

/** The _spotplayer_ player will use this route to generate the **X** cookie if it does not exists. */
Route::get('spotx',[SpotPlayerController::class, 'generateCookie']);
