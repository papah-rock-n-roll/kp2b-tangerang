<?php namespace App\Filters;
 
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
 
class Acts implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    // Do something here
    $acts = session('privilage')->acts;
    $segments = service('uri')->getSegments();

    foreach ($acts as $action) {

      switch ($action) {

        case 'create':

          if(in_array('create', $segments)) {
            return redirect()->back();
          }

          break;

        case 'read':

          if(in_array('read', $segments)) {
            return redirect()->back();
          }

          break;

        case 'update':

          if(in_array('update', $segments)) {
            return redirect()->back();
          }

          break;

        case 'delete':

          if(in_array('delete', $segments)) {
            return redirect()->back();
          }

          break;

      }

    }

  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here

  }
}