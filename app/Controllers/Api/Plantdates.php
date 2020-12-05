<?php namespace App\Controllers\Api;

/**
 * --------------------------------------------------------------------
 * Show plantdates
 *
 * https://localhost/kp2b-tangerang/api/plantdates/x
 *
 * --------------------------------------------------------------------
 */

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Events\Events;

class Plantdates extends ResourceController
{
  protected $modelName = 'App\Models\Adminpanel\Data\M_plantdate';
  protected $format    = 'json';
  protected $request;


  public function index()
  {
    $code = '403';
    $this->response->setStatusCode($code);
    $message = [
      'status' => $code,
      'message' => $this->response->getReason(),
    ];
    return $this->respond($message, $code);
  }

  public function create()
  {
    $code = '403';
    $this->response->setStatusCode($code);
    $message = [
      'status' => $code,
      'message' => $this->response->getReason(),
    ];
    return $this->respond($message, $code);
  }

  public function delete($id = null)
  {
    $code = '403';
    $this->response->setStatusCode($code);
    $message = [
      'status' => $code,
      'message' => $this->response->getReason(),
    ];
    return $this->respond($message, $code);
  }

  public function show($id = null)
  {
    $data = $this->model->getPlantdates($id);

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

  public function update($id = null)
  {
    $data = $this->request->getRawInput();

    // Log informations Ajax Events
    Events::trigger('ajax_event','update','observations_plantdates', $id, $data);

    // transpose 
    helper('parse');
    $data = transpose($data);
    // ----------------------------  
    $post = $this->model->plantdates_post($id, $data);

    if($post) {
      $code = '202';
      $this->response->setStatusCode($code);
      $message = [
        'status' => $code,
        'message' => $this->response->getReason(),
      ];
      return $this->respond($message, $code);
    }
  }

}