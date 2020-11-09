<?php namespace App\Filters;
 
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
 
class Cors implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    // Do something here
    $request = \Config\Services::request();

    if (! $request->isSecure())
    {
        force_https();
    }

  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
    $response = \Config\Services::response();
    $response
    ->setHeader('Access-Control-Allow-Origin', '*')
    ->setHeader('Access-Control-Allow-Headers', 'X-API-KP2B, X-CSRF-KP2B, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization')
    ->setHeader('Access-Control-Allow-Methods', 'GET, PUT');

    $options = [
      'max-age'  => DAY,
      's-maxage' => DAY,
    ];
    $response->setCache($options);

  }
}