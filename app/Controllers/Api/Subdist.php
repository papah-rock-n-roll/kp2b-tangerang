<?php namespace App\Controllers\Api;

/**
 * --------------------------------------------------------------------
 * Show json subdist for remote select2
 *
 * https://localhost/kp2b-tangerang/api/subdist |page null
 * 
 * 
 * https://localhost/kp2b-tangerang/api/subdist?q=abcd&page=1 |page 1 limit 10
 *
 *
 * --------------------------------------------------------------------
 */

use CodeIgniter\RESTful\ResourceController;

class Subdist extends ResourceController
{
  protected $modelName = 'App\Models\Adminpanel\Data\M_data';
  protected $format    = 'json';
  protected $request;

  public function index()
  {
    $selected = $this->request->getGet('q');
    $page = $this->request->getGet('page');

    $data = $this->model->getRemoteSubdist($selected, $page);

    if(!empty($data)) {
      return $this->respond($data);
    }
    else
    {
      $code = '404';
      $this->response->setStatusCode($code);
      $message = [
        'status' => $code,
        'message' => $this->response->getReason(),
      ];
      return $this->respond($message, $code);
    }
  }

}
