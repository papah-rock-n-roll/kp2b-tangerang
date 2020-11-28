<?php namespace App\Libraries;
 
use Config\Services;
use Exception;

class Agent
{
  public static function ua()
  { 
    $request = Services::request();
    $response = Services::response();
    $client = Services::curlrequest();
    
    $ip = $request->getIPAddress();
    $agent = $request->getUserAgent();
    $uastr = $agent->getAgentString();

    $NaN = '-';

    if (! $request->isValidIP($ip))
    {
      $valid = ' Not Valid';
    }
    else
    {
      $valid = 'Valid';
    }

    if ($agent->isBrowser())
    {
      $currentBrowser = $agent->getBrowser().' '.$agent->getVersion();
    }
    elseif ($agent->isRobot())
    {
      $currentRobot = $agent->robot();
    }
    elseif ($agent->isMobile())
    {
      $currentMobile = $agent->getMobile();
    }
    else
    {
      $NaN = 'Unidentified User Agent';
    }

    // Curl get user agent whatsmyua - ip geolocation ipwhois
    $curl1 = 'https://whatsmyua.info/api/v1/ua?ua=';
    $curl2 = 'https://ipwhois.app/json/';

    $err = null;

    try {

      $response = $client->get($curl1 . urlencode($uastr));
      $curl1 = $response->getBody();
          
      // ------------------------------------------------

      $response = $client->get($curl2 . $ip);
      $curl2 = $response->getBody();

    } 
    
    catch (Exception $e) { 
      
      $err = $e->getMessage(); } 
    
    finally {

      if ($err !== null) 
      {
        $whatsmyua = null;
        $ipwhois = null;
      }
      else
      {
        $whatsmyua = json_decode($curl1, true);
        $ipwhois = json_decode($curl2, true);
      }
    }

    $result = (object) [
      'ua' => [
        'ip' => $ip,
        'st' => $valid,
        'pf' => $agent->getPlatform(),
        'bw' => $currentBrowser ?? $NaN,
        'rb' => $currentRobot ?? $NaN,
        'mb' => $currentMobile ?? $NaN,
      ],
      'whatsmyua' => $whatsmyua,
      'ipwhois' => $ipwhois,
    ];

    return $result;

  }

}