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
use CodeIgniter\Events\Events;
use Config\Services;

class Respondens extends ResourceController
{
  protected $modelName = 'App\Models\Adminpanel\Data\M_responden';
  protected $format    = 'json';
  protected $request;


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

  public function show($segment = null)
  {
    switch ($segment) {

      case 'check':

        $respname = $this->request->getGet('respname');

        $data = $this->model->getbyName($respname);

        if(!empty($data)) {
          echo "false";
        }
        else
        {
          echo "true";
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
        'errors' => Services::validation()->getErrors(),
      ];
      return $this->respond($message, $code);
    }

    $data = $this->request->getRawInput();

    // Log informations Ajax Events
    Events::trigger('ajax_event','create','mstr_respondens', null, $data);
    // ----------------------------
    $post = $this->model->insert($data);

    if($post) {
      $code = '201';
      $this->response->setStatusCode($code);
      $message = [
        'status' => $code,
        'message' => $this->response->getReason(),
      ];
      return $this->respond($message, $code, 'test');
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
        'errors' => Services::validation()->getErrors(),
      ];
      return $this->respond($message, $code);
    }

    $data = $this->request->getRawInput();

    // Log informations Ajax Events
    Events::trigger('ajax_event','update','mstr_respondens', $id, $data);
    // ----------------------------
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
    // Log informations Ajax Events
    Events::trigger('ajax_event','delete','mstr_respondens', $id, null);
    // ----------------------------
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
