<?php namespace App\Controllers\Api;

/**
 * --------------------------------------------------------------------
 * Show observation
 *
 * https://localhost/kp2b-tangerang/api/observation/x
 *
 * Custom Info Fields
 *
 * https://localhost/kp2b-tangerang/api/observation/ajax?id=x
 *
 * --------------------------------------------------------------------
 */

use CodeIgniter\RESTful\ResourceController;
use Config\Services;

class Observation extends ResourceController
{
  protected $modelName = 'App\Models\Adminpanel\Data\M_observation';
  protected $format    = 'json';
  protected $request;

  protected $validation;

  public function __construct()
  {
    $this->validation = Services::validation();
  }


  public function index()
  {
    $code = '404';
    $this->response->setStatusCode($code);
    $message = [
      'status' => $code,
      'message' => $this->response->getReason(),
    ];
    return $this->respond($message, $code);
  }

  public function show($segment = null)
  {
    switch ($segment) {

      case 'ajax':

        $id = $this->request->getGet('id');
        $data = $this->model->update_newAjax($id);

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
      break;

      default:

        $data = $this->model->getObservation($segment);

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

      break;

    }
    
  }

  public function update($id = null)
  {
    $rules = $this->model->validationRules($id);

    if(! $this->validate($rules)) {
      $code = '406';
      $this->response->setStatusCode($code);
      $message = [
        'status' => $code,
        'message' => $this->response->getReason(),
        'errors' => $this->validation->getErrors(),
      ];
      return $this->respond($message, $code);
    }

    $data = $this->request->getRawInput();
    $post = $this->model->update_post($id, $data);

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