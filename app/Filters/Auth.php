<?php namespace App\Filters;
 
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use Config\Services;
use App\Libraries\Crypto;

class Auth implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    $request = Services::request();
    $response = Services::response();

    // Session privilage
    $auth = session()->has('privilage');

    if (! $auth) {

      // X-Requested-With: XMLHttpRequest
      if ($request->isAJAX()) 
      {
        $response = Services::response();
        $code = '401';
        $response->setStatusCode($code);
        $message = [
          'status' => $code,
          'message' => $response->getReason(),
        ];
        return $response->setJSON($message);
      }

      // content-type: text/html
      return redirect('login');

    }
    else
    {
      // X-API-KP2B: crypto-decrypt-email
      $x_api = $request->getHeaderLine('X-API-KP2B');
      $token = explode('#', Crypto::decrypt($x_api));
      $email = session('privilage')->email;
      $api = in_array($email, $token) != null ? true : false;
        
      // header X-API-KP2B di setiap request (setelah login)
      if (! $api)
      { 
        $code = '401';
        $response->setStatusCode($code);
        $message = [
          'status' => $code,
          'message' => $response->getReason(),
        ];
        return $response->setJSON($message);
      }
      
    }
  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here

  }
}