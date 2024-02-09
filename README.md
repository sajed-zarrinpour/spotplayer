spotplayer
==========

A wrapper for spotplayer.ir video service (DRM) API
-----------------------
### Author: Sajed Zarinpour

This package provides an API wrapper for [spotplayer.ir](https://spotplayer.ir) website. Spotplayer is a video-sharing website for teachers that provides a way to stream their video on either their website or the Spotplayer application (which is available for Windows, MacOS, Ubuntu, IOS, and Android) that ensures the copyrighting of their content. 

### Installation 

Step 1:

Install the package using Composer:

    composer require sajed-zarrinpour/spotplayer

Step 2:

Publish the config file of the package using the following command

    php artisan vendor:publish --provider="SajedZarinpour\Spotplayer\Providers\SpotPlayerServiceProvider"

Step 3:

Set values in the

    config/spotplayer.php

### Usage

The package provides both Facade and helper functions. Suppose you want to call a function **some\_func. Following calls are equivalent:**

    <?php
    
    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
    
    use SajedZarinpour\Spotplayer\Facades\SpotPlayer;
    
    class SpotPlayerController extends Controller
    {
        
        public function play(Request $request)
        {
           ...
           SpotPlayer::some_func();
           ...
        }
    }

and

    <?php
    
    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
    
    use SajedZarinpour\Spotplayer\Facades\SpotPlayer;
    
    class SpotPlayerController extends Controller
    {
        
        public function play(Request $request)
        {
             ...
             spotplayer()->some_func();
             ...
        }
    }
    

Note the import when using the Facade.

### Basic Usage

Environement variables

    SPOTPLAYER_API=YOURAPIKEY
    SPOTPLAYER_MODE=test # OR production
    SPOTPLAYER_DOMAIN=localhost # YOUR DOMAIN

Generating a licence

    // Setting up a device
    $device = spotplayer()->setDevice(
        $numberOfAllowedActiveDevices=2, 
        $Windows=0, 
        $MacOS=0, 
        $Ubuntu=0, 
        $Android=0, 
        $IOS=0, 
        $WebApp=2
    );
    
    // Generating a license
    $licence = spotplayer()->licence(
        $name='John Doe', 
        $courses=['courseId1','courseId2'], 
        $watermarks='watermark text', 
        $device, 
        $payload='payload'
    );
    
    dump('licence id is:' . $licence['_id']);
    dump('licence key is:' . $license['key']);
    dump('licence URL is:' . $licence['url']);
    
    die;

### Example
### Docs
