<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\RequestInterface;

class Geo extends ResourceController
{
  protected $modelName = 'App\Models\M_geophp';
  // protected $format    = 'json';
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

  public function show($data = null)
  {
    $data = $this->model
    ->where('category_id', $data)
    ->orWhere('category_name', $data)
    ->first();

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