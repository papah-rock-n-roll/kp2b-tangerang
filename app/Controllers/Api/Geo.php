<?php namespace App\Controllers\Api;

/**
 * --------------------------------------------------------------------
 * Show geojson
 *
 * https://localhost/kp2b-tangerang/api/geo
 *
 * Custom Info Fields
 *
 * https://localhost/kp2b-tangerang/api/geo/info?table=a&fid=a&shape=a&fields=a,b,c,d
 *
 * --------------------------------------------------------------------
 */

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\RequestInterface;

class Geo extends ResourceController
{
  protected $modelName = 'App\Models\M_geophp';
  protected $format    = 'json';
  protected $request;

  public function index()
  {
    $info_fields = array(
      'areantatus', 'broadnrea'
    );
    $data = $this->model->get_geojson('v_observations', 'obscode', 'obsshape', $info_fields);

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

      case 'info':

        $table = $this->request->getGet('table');
        $fid = $this->request->getGet('fid');
        $shape = $this->request->getGet('shape');
        $fields = $this->request->getGet('fields');

        $info_fields = explode(',', $fields);
        $data = $this->model->get_geojson($table, $fid, $shape, $info_fields);

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

  public function getHeader()
  {
    $password = 123;
    $token = \App\Libraries\Crypto::encrypt($password);

    $this->request->getHeaderLine('KP2B-TOKEN') == $token ? $sts = true : $sts = false;
    return $sts;
  }

  public function update($id = null)
  {
    if($this->getHeader()) 
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
      $post = $this->model->putGeo($id, $data);

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
    else
    {
      $code = '401';
      $this->response->setStatusCode($code);
      $message = [
        'status' => $code,
        'message' => $this->response->getReason(),
      ];
      return $this->respond($message, $code);
    }
  }

}
