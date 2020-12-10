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
    
  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
    $response = Services::response();

    $auth = session()->has('privilage');

    if ($auth) {

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