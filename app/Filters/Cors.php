<?php namespace App\Filters;
 
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use Config\Services;
use App\Libraries\Crypto;

class Cors implements FilterInterface
{
  
  public function before(RequestInterface $request, $arguments = null)
  {
    // Do something here
    $request = Services::request();

    $server = $request->uri->getScheme() .'://'. $request->uri->getHost() .'/';

    if ($server !== SCHEME_HOST) {

      $request->setHeader('Location', SCHEME_HOST);
      exit();

    }
  
  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
    $response = Services::response();

    $server = $request->uri->getScheme() .'://'. $request->uri->getHost();

    $options = [
      'max-age' => DAY,
      'public', 
      'no-tranform',
    ];
    $response->setCache($options);

    $response
    ->setHeader('Connection', 'keep-alive')
    ->setHeader('Access-Control-Allow-Origin', $server)
    ->setHeader('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization')
    ->setHeader('Access-Control-Allow-Methods', 'GET')
    ->setHeader('Access-Control-Max-Age', '86400');


    $auth = session()->has('privilage');

    if ($auth) {

      $email = session('privilage')->email;
      $token = Crypto::encrypt(uniqid().'#'.$email.'#'.time());
      
      $response
      ->appendHeader('Access-Control-Allow-Headers','X-API-KP2B')
      ->appendHeader('Access-Control-Allow-Methods', 'PUT')
      ->setHeader('X-API-KP2B', $token);

    }

  }

}