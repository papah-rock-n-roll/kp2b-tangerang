<?php namespace App\Controllers\Api;

/**
 * --------------------------------------------------------------------
 * Show geojson
 * 
 * https://localhost/kp2b-tangerang/api/geo
 * 
 * Custom Info Fields
 * 
 * https://localhost/kp2b-tangerang/api/geo/info?fields=a,b,c,d
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
      'Penggarap','Pemilik','POKTAN','Luas_pokta','KODE','Nama_Desa',
      'Status_Lah','Irigasi','IP','Pola','BT_1','BT_2','BT_3',
      'Var_1','Var_2','Produktivi','Hama','Permasalah',
      'Saprotan','Jual','Luas_ha_','Land_use','ADA','luas_new','list'
    );
    $data = $this->model->get_geojson('tgr_petak', 'FID', 'Shape', $info_fields);

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

        $fields = $this->request->getGet('fields');
        $info_fields = explode(',', $fields);
        $data = $this->model->get_geojson('tgr_petak', 'FID', 'Shape', $info_fields);

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