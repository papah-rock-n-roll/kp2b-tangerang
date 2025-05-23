<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use Config\Services;

class Acts implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    // Do something here
    $acts = session('privilage')->acts;
    $nav = array_keys(session('privilage')->menus);
    $segments = service('uri')->getSegments();

    $request = Services::request();
    $response = Services::response();

    if($request->isAJAX())
    {
      switch ($request->getMethod()) {

        case 'get':

          if(in_array('read', $acts)) {
            $code = '403';
            $response->setStatusCode($code);
            $message = [
              'status' => $code,
              'message' => $response->getReason(),
            ];
            return $response->setJSON($message);
          }

        break;

        case 'post':

          if(in_array('create', $acts)) {
            $code = '403';
            $response->setStatusCode($code);
            $message = [
              'status' => $code,
              'message' => $response->getReason(),
            ];
            return $response->setJSON($message);
          }

        break;

        case 'put':

          if(in_array('update', $acts)) {
            $code = '403';
            $response->setStatusCode($code);
            $message = [
              'status' => $code,
              'message' => $response->getReason(),
            ];
            return $response->setJSON($message);
          }

        break;

        case 'delete':

          if(in_array('delete', $acts)) {
            $code = '403';
            $response->setStatusCode($code);
            $message = [
              'status' => $code,
              'message' => $response->getReason(),
            ];
            return $response->setJSON($message);
          }

        break;

      }

    }
    else
    {
      foreach ($acts as $action) {

        switch ($action) {

          case 'create':

            if(in_array('create', $segments)) {
              throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

          break;

          case 'read':

            if(in_array('read', $segments)) {
              throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

          break;

          case 'update':

            if(in_array('update', $segments)) {
              throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

          break;

          case 'delete':

            if(in_array('delete', $segments)) {
              throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

          break;

          case 'import':

            if(in_array('import', $segments)) {
              throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

          break;

          case 'export':

            if(in_array('export', $segments)) {
              throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

          break;

        }

      }

      // nav menu - role module
      if(empty(array_intersect($nav, $segments))) {

        if(in_array('dashboard', $segments)) {
          return true;
        }
        else
        {
          throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
      }
      

      // custom segments
      if(in_array('obs_ajax', $segments)) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      }
      elseif(in_array('plantdate_ajax', $segments)) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      }

    }

  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here

  }
}
