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

class Geo extends ResourceController
{
  protected $modelName = 'App\Models\M_geophp';
  protected $format    = 'json';
  protected $request;

  protected $validation;

  public function __construct()
  {
    $this->validation = \Config\Services::validation();
  }

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
        $sdcode = $this->request->getGet('sdcode');
        $vlcode = $this->request->getGet('vlcode');

        $info_fields = null;
        if(!empty($fields)) { $info_fields = explode(',', $fields); }
        $data = $this->model->get_geojson($table, $fid, $shape, $info_fields, $sdcode, $vlcode);

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

      case 'kecamatan':
        $data = $this->model->get_kecamatan();
        if(!empty($data)) {
          return $this->respond($data);
        } else {
          $code = '404';
          $this->response->setStatusCode($code);
          $message = [
            'status' => $code,
            'message' => $this->response->getReason(),
          ];
          return $this->respond($message, $code);
        }

      break;

      case 'desa':

        $sdcode = $this->request->getGet('sdcode');
        $data = $this->model->get_desa($sdcode);
        if(!empty($data)) {
          return $this->respond($data);
        } else {
          $code = '404';
          $this->response->setStatusCode($code);
          $message = [
            'status' => $code,
            'message' => $this->response->getReason(),
          ];
          return $this->respond($message, $code);
        }

      break;

      case 'obsdetail':

        $obscode = $this->request->getGet('obscode');
        $data = $this->model->get_obs_detail($obscode);
        if(!empty($data)) {
          return $this->respond($data);
        } else {
          $code = '404';
          $this->response->setStatusCode($code);
          $message = [
            'status' => $code,
            'message' => $this->response->getReason(),
          ];
          return $this->respond($message, $code);
        }

      break;


    // ----------------------------------------------------


/**
 * --------------------------------------------------------------------
 * Show geojson public
 *
 *
 * public kondisi sdcode atau vlcode
 *
 * https://localhost/kp2b-tangerang/api/public?sdcode=xxxx
 *
 * https://localhost/kp2b-tangerang/api/public?vlcode=xxxxxxx
 *
 * --------------------------------------------------------------------
 */

      case 'public':

        $conditions = array(
          'sdcode' => $this->request->getGet('sdcode'),
          'vlcode' => $this->request->getGet('vlcode'),
        );
        $data = $this->model->get_public($conditions);

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

}