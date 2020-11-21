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

    // set lokasi default scheme host
    if ($server !== SCHEME_HOST) {

      $request->setHeader('Location', SCHEME_HOST);
      exit();

    }

    $auth = session()->has('privilage');

    if ($auth) {
      
      // set header X-API-KP2B di setiap request (setelah login)
      $email = session('privilage')->email;
      $token = Crypto::encrypt(uniqid().'#'.$email.'#'.time());
      
      $request
      ->appendHeader('Access-Control-Allow-Headers','X-API-KP2B')
      ->setHeader('X-API-KP2B', $token);

    }
  
  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
    $response = Services::response();
    $request = Services::request();

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
    ->setHeader('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method')
    ->setHeader('Access-Control-Max-Age', '86400');

    $auth = session()->has('privilage');

    if ($auth || $request->isAJAX()) {

      // set header X-API-KP2B di setiap response (setelah login)
      $email = session('privilage')->email;
      $token = Crypto::encrypt(uniqid().'#'.$email.'#'.time());

      $response
      ->appendHeader('Access-Control-Allow-Headers','X-API-KP2B')
      ->setHeader('Access-Control-Allow-Methods', 'GET')
      ->setHeader('X-API-KP2B', $token);

      // filter actions berdasarkan role (setelah login)
      // append header Access-Control-Allow-Methods di setiap response
      $acts = session('privilage')->acts;
      
      if(empty(in_array('create', $acts))) {
        $response->appendHeader('Access-Control-Allow-Methods', 'POST');
      }
      if(empty(in_array('update', $acts))) {
        $response->appendHeader('Access-Control-Allow-Methods', 'PUT');
      }
      if(empty(in_array('delete', $acts))) {
        $response->appendHeader('Access-Control-Allow-Methods', 'DELETE');
      }

    }
  }

}