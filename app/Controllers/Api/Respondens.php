<?php namespace App\Controllers\Api;

/**
 * --------------------------------------------------------------------
 * Show json respondens for remote select2
 *
 * https://localhost/kp2b-tangerang/api/respondens |page null
 * 
 * 
 * https://localhost/kp2b-tangerang/api/respondens?q=abcd&page=1 |page 1 limit 10
 *
 *
 * --------------------------------------------------------------------
 */

use CodeIgniter\RESTful\ResourceController;
use Config\Services;

class Respondens extends ResourceController
{
  protected $modelName = 'App\Models\Adminpanel\Data\M_responden';
  protected $format    = 'json';
  protected $request;

  protected $validation;

  public function __construct()
  {
    $this->validation = Services::validation();
  }

  public function index()
  {
    $selected = $this->request->getGet('q');
    $page = $this->request->getGet('page');

    $data = $this->model->getRemoteRespondens($selected, $page);

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

  public function show($id = null)
  {
    $data = $this->model->find($id);

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
