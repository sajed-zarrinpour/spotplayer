<?php

namespace SajedZarinpour\SpotPlayer\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

use SajedZarinpour\SpotPlayer\Facades\SpotPlayer;

class SpotPlayerController extends Controller
{
    /**
     * Generate cookie X for spot player.
     * If you are runing this on a localhost machine, make sure you run your laravel program using:
     * ```
     *    php artisan serve --host=localhost
     * ```
     * Otherwise **the cookie won't set**. Moreover, make sure the cookie **X** won't encrypt by laravel by adding
     * ``` 
     *    protected $except = ['X'];
     * ```
     * to the **$except** array in **Midllware/EncryptCookies**.
     * 
     * @param Illuminate\Http\Request $request
     * 
     * @return Illuminate\Http\Response $response 
     */
    public function generateCookie(Request $request){
        
        $X = $request->cookie('X');

        if (SpotPlayer::checkCookie($X))
        { 
            return response()->noContent()->cookie(
                        $name = 'X',
                        $value = SpotPlayer::generateCookie($X)[1],
                        $minutes = time() + (3600*24*365*100),
                        $path = '/',
                        $domain=config('spotplayer.domain'),
                        $secure=true,
                        $httpsOnly=false
                    );
        } 
        else 
        {
            return response()->noContent();
        }
    }

}
