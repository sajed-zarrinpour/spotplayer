<?php
/** This file contains the config for using spotplayer api */

return [
    
    
    /*
    |--------------------------------------------------------------------------
    | SpotPlayer Api Key
    |--------------------------------------------------------------------------
    |
    | This value is your API KEY from spotplayer.ir.
    |
    */
    'api' => env('SPOTPLAYER_API','ZZ+sm5KPRPne81Da/NGBsFz13hA='),
    
    /*
    |--------------------------------------------------------------------------
    | Domain
    |--------------------------------------------------------------------------
    |
    | This value is your website domain. It will be used to generate cookie from the rout /spotx.
    |
    */
    'domain' => env('SPOTPLAYER_DOMAIN', 'localhost'),

    /*
    |--------------------------------------------------------------------------
    | Device
    |--------------------------------------------------------------------------
    |
    | This array holds the setting for the allowed devices to use the generated licence. 
    | p0 is the number of devices which you can register for this licence.
    | p1...p6 is the number of devices which can register for the licence.
    | For example, you can set p0 to 2 and all else to 2. Then you can register licence for only
    | p0(=2) device of any of those types for this licence.
    |
    */
    'device' => [
        "p0" => 1, // All Devices 1-99
        "p1" => 0, // Windows 0-99
        "p2" => 0, // MacOS 0-99
        "p3" => 0, // Ubuntu 0-99
        "p4" => 0, // Android 0-99
        "p5" => 0, // IOS 0-99
        "p6" => 1  // WebApp 0-99
    ],

    /*
    |--------------------------------------------------------------------------
    | Mode
    |--------------------------------------------------------------------------
    |
    | This value is your developement mode. It will be use in generation of a licence. 
    | It can be either **test** or **production** which you must specify according to your usecase.
    |
    */
    'mode' => env('SPOTPLAYER_MODE', 'test') // production

];
