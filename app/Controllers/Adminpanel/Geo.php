<?php namespace App\Controllers\Adminpanel;

class Geo extends \App\Controllers\BaseController
{
  public function index()
  {
    $data = [
      'url' => base_url('api/geo/'),
			'url_kec' => base_url('api/geo/kecamatan'),
      'url_desa' => base_url('api/geo/desa'),
      'url_obs' => base_url('api/geo/obsdetail'),
      'url_edtObs' => base_url('administrator/data/observation/update/'),
      'url_edtPlt' => base_url('administrator/data/observation/plantdate/')
		];
    echo view('adminpanel/geo/main', $data);
  }

  public function observation_index()
  {
    // $_['GET'] variabel keyword - paginate
    $keyword = $this->request->getGet('keyword');
    $paginate = $this->request->getGet('paginate');

    // fetch data dengan memanggil fungsi model obsgeo
    $this->M_obsgeo->list(null, $keyword, null, $paginate);
  }

}
