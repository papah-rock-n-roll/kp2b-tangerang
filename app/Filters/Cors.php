<?php namespace App\Filters;
 
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use Config\Services;

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
    ->setHeader('Content-Security-Policy', "default-src * blob: data: 'unsafe-eval' 'unsafe-inline' ; worker-src blob: ")
    ->setHeader('Connection', 'Keep-Alive')
    ->setHeader('Access-Control-Allow-Origin', $server)
    ->setHeader('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method')
    ->setHeader('Access-Control-Allow-Methods', 'GET')
    ->setHeader('Access-Control-Max-Age', '86400');

  }

}