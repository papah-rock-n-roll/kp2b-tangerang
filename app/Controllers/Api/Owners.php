<?php namespace App\Controllers\Api;

/**
 * --------------------------------------------------------------------
 * Show json owners for remote select2
 *
 * https://localhost/kp2b-tangerang/api/owners |page null
 * 
 * 
 * https://localhost/kp2b-tangerang/api/owners?q=abcd&page=1 |page 1 limit 10
 *
 *
 * --------------------------------------------------------------------
 */

use CodeIgniter\RESTful\ResourceController;

class Owners extends ResourceController
{
  protected $modelName = 'App\Models\Adminpanel\Data\M_owner';
  protected $format    = 'json';
  protected $request;

  public function index()
  {
    $selected = $this->request->getGet('q');
    $page = $this->request->getGet('page');

    $data = $this->model->getRemoteOwners($selected, $page);

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
