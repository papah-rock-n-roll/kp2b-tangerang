<?php namespace App\Controllers\Api;

/**
 * --------------------------------------------------------------------
 * Show json farmer for remote select2
 *
 * https://localhost/kp2b-tangerang/api/farmers |page null
 * 
 * https://localhost/kp2b-tangerang/api/farmers?q=abcd&page=1 |page 1 limit 10
 *
 * 
 * --------------------------------------------------------------------
 * Show segment farmcode atau ajax farmcode
 * 
 * https://localhost/kp2b-tangerang/api/farmers/1 | show farmer
 * 
 * https://localhost/kp2b-tangerang/api/farmers/ajax?id=1 show extend farmer
 * --------------------------------------------------------------------
 */

use CodeIgniter\RESTful\ResourceController;

class Farmers extends ResourceController
{
  protected $modelName = 'App\Models\Adminpanel\Data\M_farmer';
  protected $format    = 'json';
  protected $request;

  public function index()
  {
    $selected = $this->request->getGet('q');
    $page = $this->request->getGet('page');

    $data = $this->model->getRemoteFarmer($selected, $page);

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

  public function show($segment = null)
  {
    switch ($segment) {

      case 'ajax':

        $id = $this->request->getGet('id');
        $data = $this->model->getFarmerAjax($id);

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

        $data = $this->model->find($segment);

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

  public function create()
  {
    $rules = $this->model->validationRules();

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
    $post = $this->model->insert($data);

    if($post) {
      $code = '201';
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
    $post = $this->model->update($id, $data);

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

  public function delete($id = null)
  {
    $delete = $this->model->delete($id);

    if($delete) {
      $code = '200';
      $this->response->setStatusCode($code);
      $message = [
        'status' => $code,
        'message' => $this->response->getReason(),
      ];
      return $this->respond($message, $code);
    }
  }

}
