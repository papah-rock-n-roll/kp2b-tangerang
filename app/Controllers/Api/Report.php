<?php namespace App\Controllers\Api;

/**
 * --------------------------------------------------------------------
 * Get Jumlah petak
 * https://localhost/kp2b-tangerang/api/report/petaj?sdcode=xxxxxx
 *
 * --------------------------------------------------------------------
 */

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Events\Events;
use Config\Services;

class Report extends ResourceController
{

  protected $modelName = 'App\Models\Adminpanel\Report\M_report';

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

  public function show($segment = null)
  {
    switch ($segment) {

      case 'lj':
        $sdcode = $this->request->getGet('sdcode');
        $group = $this->request->getGet('group');

        $data = $this->model->lj($sdcode, $group);

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

        case 'pp':
          $sdcode = $this->request->getGet('sdcode');
          $group = $this->request->getGet('group');

          $data = $this->model->pp($sdcode, $group);

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
    $code = '403';
    $this->response->setStatusCode($code);
    $message = [
      'status' => $code,
      'message' => $this->response->getReason(),
    ];
    return $this->respond($message, $code);
  }

}
