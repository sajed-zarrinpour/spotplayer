<?php
namespace SajedZarinpour\SpotPlayer;

class SpotPlayer{
  /**
   * SpotPlayer Core Functionality
   * 
   * This file declares the core class which is used by the rest of the package to deliver the expected value of the package.
   * Here is a list of constants used in this package (all of which can be fine tuned by publishing and wditing the package config file):
   * 
   * * $api The api key acquired from spotplayer.ir
   * * $level According to spotplayer api docs this is always equal to -1
   * * $mode The mode with which we call upon spotplayer api. the test value in config converts to true and developement converts to false
   * 
   * To publish the config file use the following command:
   * ```
   *    php artisan vendor:publish
   * ```
   * and select the package from the package list.
   */


  /**
   * Check if the cookie is still valid.
   * 
   * @param string $cookie The cookie to check it's validity
   * 
   * @return bool The cookie validity.
   */
  public function checkCookie($cookie) : bool
  {
    return (microtime(true) * 1000) > hexdec(substr($cookie, 24, 12));
  }

  /**
   * Generating cookie.
   * 
   * @param string $cookie
   * 
   * @return array Use the second element of the array as the cookie value. 
   */
  public function generateCookie($cookie) : array
  {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_HEADER => true,
        CURLOPT_NOBODY => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => 'https://app.spotplayer.ir/',
        CURLOPT_HTTPHEADER => ['cookie: X=' . $cookie]
    ]);
    preg_match('/X=([a-f0-9]+);/', curl_exec($ch), $mm);
    return $mm;
  }

  /**
   * Ommit all null values from the options array.
   * 
   * @param array $a the array to get filtered.
   * 
   * @return array The filtered array.
   */
  private function filter($a) : array 
  {
    return array_filter($a, function ($v) { return !is_null($v); });
  }

  /**
   * Setting up request to send to api end point.
   * 
   * @param string $url the endpoint to sent the request to.
   * @param array $options the options of the request.
   * 
   * @return array The response sent back from the api end point.
   */
  private function request($url, $options = null) : array 
  {
    curl_setopt_array($c = curl_init(), [
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => $options ? 'POST' : 'GET',
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_FOLLOWLOCATION => false,
      CURLOPT_HTTPHEADER => ['$API: ' . config('spotplayer.api'), '$LEVEL: -1', 'content-type: application/json' ],
    ]);
    if ($options) curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($this->filter($options)));
    $json = json_decode(curl_exec($c), true);
    curl_close($c);
    if (is_array($json) && ($ex = @$json['ex'])) throw new \Exception($ex['msg']);
    return $json;
  }

  /**
   * Get files as JSON.
   * 
   * Retrieves the materials of a course.
   * 
   * @param string $url the downloadable url which is generated when you create a license.
   * 
   * @return array A list of all the content for a course in spotplayer.
   */
  public function getJSONFileList($url) : array 
  {
    return $this->request('http://dl.spotplayer.ir'.$url.'?f=json', null)[0];
  }

  /**
   * Get all licenses.
   * 
   * @param void
   * 
   * @return array A list of all the licences generated with this api key.
   */
  public function getAllLicences() : array
  {
    return $this->request('https://panel.spotplayer.ir/license/?p=0', null);
  }

  /**
   * Get All the courses for a license.
   * 
   * @param void
   * 
   * @return array A list of all classes defined in spotplayer with with api key.
   */
  public function getAllCourses() : array
  {
    return $this->request('https://panel.spotplayer.ir/course/?p=0', null);
  }

  /**
   * Get the detail for one course.
   * 
   * @param string $courseId
   * 
   * @return array Get the Detail of a specific course. 
   */
  public function getCourseDetail($courseId) : array
  {
    return $this->request('https://panel.spotplayer.ir/course/edit/'.$courseId, null);
  }

  /**
   * To set up the $device array in a convinient way.
   * 
   * If you wish to set up a specific device set up for a licence you can use this function to create the array in a conviniet way.
   * 
   * @see config('spotplayer.device') Read the doc on package config file for more information. 
   * 
   * @param int $numberOfAllowedActiveDevices 
   * @param int $Windows default value: 0
   * @param int $MacOS default value: 0
   * @param int $Ubuntu default value: 0
   * @param int $Android default value: 0
   * @param int $IOS default value: 0
   * @param int $WebApp default value: 0
   * 
   * @return array The _device_ array to use in licence generation.
   */
  public function setDevice($numberOfAllowedActiveDevices, $Windows=0, $MacOS=0, $Ubuntu=0, $Android=0, $IOS=0, $WebApp=0) : array
  {

    if ($numberOfAllowedActiveDevices < 0 || $numberOfAllowedActiveDevices > 99 ) 
    {
      throw new \Exception('The parameter $numberOfAllowedActiveDevices is out of range (0-99).');
    }
    if ($Windows < 0 || $Windows > 99 ) 
    {
      throw new \Exception('The parameter $Windows is out of range (0-99).');
    }
    if ($MacOS < 0 || $MacOS > 99 ) 
    {
      throw new \Exception('The parameter $MacOS is out of range (0-99).');
    }
    if ($Ubuntu < 0 || $Ubuntu > 99 ) 
    {
      throw new \Exception('The parameter $Ubuntu is out of range (0-99).');
    }
    if ($Android < 0 || $Android > 99 ) 
    {
      throw new \Exception('The parameter $Android is out of range (0-99).');
    }
    if ($IOS < 0 || $IOS > 99 ) 
    {
      throw new \Exception('The parameter $IOS is out of range (0-99).');
    }
    if ($WebApp < 0 || $WebApp > 99 ) 
    {
      throw new \Exception('The parameter $WebApp is out of range (0-99).');
    }
    
    $device = [
      "p0" => $numberOfAllowedActiveDevices, // All Devices 1-99
      "p1" => $Windows, // Windows 0-99
      "p2" => $MacOS, // MacOS 0-99
      "p3" => $Ubuntu, // Ubuntu 0-99
      "p4" => $Android, // Android 0-99
      "p5" => $IOS, // IOS 0-99
      "p6" => $WebApp  // WebApp 0-99
    ];

    return $device;
  }

  /**
   * generate a spotplayer licence for the given values.
   * 
   * @param string $name the name of the person this licence should issued to.
   * @param array $courses the courses that this licence covers.
   * @param string $watermark your watermark text.
   * @param string test
   * 
   * @return array The array consists of these keys:
   * * _id Created License ID,
   * * key License Key,
   * * url downloadable licence speciefic url (extending https://dl.spotplayer.ir/, ends with file type).
   */
  public function licence($name, $courses, $watermarks, $device=null, $payload=null) : array 
  {
    if ($device = null) {
      $device = config('spotplayer.device');
    }

    if(!is_array($watermark)){
      $watermarks = ['texts' => array_map(function ($w) { return ['text' => $w]; }, $watermarks)];
    }
    
    return $this->request('https://panel.spotplayer.ir/license/edit/', [
      'test' => config('spotplayer.mode')=='test'?true:false,
      'name' => $name,
      'course' => $courses,
      'watermark' => $watermarks,
      'device' => $device,
      'payload' => $payload
    ]);
  }

  /**
   * Get a licence description.
   * 
   * @param string $licenseId
   * 
   * @return array Get the detail of a licence.
   */
  public function getLicenseData($licenseId) : array
  {
    return $this->request('https://panel.spotplayer.ir/license/edit/'.$licenseId, null);
  }

  /**
   * Update a spotplayer licence for the given values.
   * 
   * @param string $name the name of the person this licence should issued to.
   * @param array $data the data of the video including licence limits.
   * @param array $device specifies which device is covered with this licence. 
   * 
   * @return string The id of the licence which was affected by the update.
   */
  public function updateLicense($licenseId, $name, $data, $device) : string 
  {
    return $this->request('https://panel.spotplayer.ir/license/edit/'.$licenseId, [
      'name'=>$name,
      'data' => $data,
      'device' => $device,
    ]);
  }

  /**
   * Checking the validity of a licence.
   * 
   * @param string $licenceId the licence to verify
   * 
   * @return bool validity of the licence.
   */
  public function licenceIsValid(string $licenceId) : bool
    {
        $licenceData = $this->getLicenseData($licenceId);
        if(is_array($licenceData)){
            if(array_key_exists("_id",$licenceData)){
                if($licenceData['_id'] === $licenceId){
                    return true;
                }
            }
        }
        return false;
    }

}

