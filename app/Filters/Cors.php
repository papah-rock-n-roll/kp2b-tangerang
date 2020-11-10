<?php namespace App\Filters;
 
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use function Complex\sec;
use function Complex\sech;

class Cors implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    // Do something here
    $request = \Config\Services::request();
    
    if ($request->isSecure())
    {
        force_https();
    }
  
  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
    $auth = session()->has('privilage');

    $response = \Config\Services::response();

    $response
    ->setHeader('Access-Control-Allow-Origin', $request->uri->getScheme() .'://'. $request->uri->getHost())
    ->setHeader('Access-Control-Allow-Headers','X-API-KP2B, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization')
    ->setHeader('Access-Control-Allow-Methods', 'GET');

    if ($auth) {

      $email = session('privilage')->email;
      $token = \App\Libraries\Crypto::encrypt(uniqid().'#'.$email.'#'.time());
      
      $response
      ->appendHeader('Access-Control-Allow-Methods', 'PUT')
      ->setHeader('access-control-max-age', '3000')
      ->setHeader('X-API-KP2B', $token);

      $options = [
        'max-age'  => DAY,
        's-maxage' => DAY,
      ];
      $response->setCache($options);

    }

  }
}