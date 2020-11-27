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
      'url_edtPlt' => base_url('administrator/data/observation/plantdate/'),
      'url_obsDet' => base_url('administrator/geo/observation/obs_ajax')
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

  public function observation_detail($id)
  {
    $this->M_observation->getObsdetail($id);
  }


/**
 * --------------------------------------------------------------------
 *
 * Geo Observations - Upload Import - Export
 *
 * --------------------------------------------------------------------
 */
  public function observation_upload()
  {
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;

      $this->M_obsgeo->upload_new($data);
    }
    else
    {
      $rules = $this->M_obsgeo->validationImport();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $file = $this->request->getFile('zip_file');
      $this->M_obsgeo->upload_post($file);
    }
  }

  public function observation_export($obscode)
  {
    $this->M_obsgeo->export($obscode);
  }

}
