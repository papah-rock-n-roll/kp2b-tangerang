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
    $data = $this->model->get_geojson('observations_frmobservations', 'obscode', 'obsshape', $info_fields);

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

}
