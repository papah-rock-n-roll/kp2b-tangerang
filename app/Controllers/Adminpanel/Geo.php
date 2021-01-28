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
      'url_obsDet' => base_url('administrator/geo/observation/obs_ajax'),
      'url_pldDet' => base_url('administrator/geo/observation/plantdate_ajax'),
      'url_nik' => base_url('api/owners/check'),
      'url_farmname' => base_url('api/farmers/check'),
      'url_respname' => base_url('api/respondens/check')
		];
    echo view('adminpanel/geo/main', $data);
  }

  public function observation_detail($id)
  {
    $this->M_observation->getObsdetail($id);
  }

  public function plantdate_detail($id)
  {
    $this->M_plantdate->getPlantdateDetail($id);
  }


/**
 * --------------------------------------------------------------------
 *
 * Geo Observations - Upload Import - Export
 *
 * --------------------------------------------------------------------
 */
  public function observation_index()
  {
    // $_['GET'] variabel keyword - paginate
    $keyword = $this->request->getGet('keyword');
    $paginate = $this->request->getGet('paginate');

    // fetch data dengan memanggil fungsi model obsgeo
    $this->M_obsgeo->list(null, $keyword, null, $paginate);
  }

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

  public function observation_import()
  {
    $post = $this->request->getPost();
    $shape = $this->request->getVar('chk_shape') == null ? 0 : 1;
    $dbf = $this->request->getVar('chk_dbf') == null ? 0 : 1;
    
    $import = $this->M_obsgeo->import($post, $shape, $dbf);

    if($import) {
      $this->session->setFlashdata('import', 'Import Observation Successfully');
      return redirect()->to('/administrator/geo/observation');
    }
  }

  public function observation_export($obscode)
  {
    $path = $this->M_obsgeo->export($obscode);

    return $this->response->download($path, null);
  }


/**
 * --------------------------------------------------------------------
 *
 * Geo Observations Village - Upload Import - Export
 *
 * --------------------------------------------------------------------
 */
  public function observation_village_index()
  {
    // $_['GET'] variabel keyword - paginate
    $keyword = $this->request->getGet('keyword');
    $paginate = $this->request->getGet('paginate');

    // fetch data dengan memanggil fungsi model obsgeo
    $this->M_vlgeo->list(null, $keyword, null, $paginate);
  }

  public function observation_village_upload()
  {
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;

      $this->M_vlgeo->upload_new($data);
    }
    else
    {
      $rules = $this->M_vlgeo->validationImport();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $file = $this->request->getFile('zip_file');
      $this->M_vlgeo->upload_post($file);
    }
  }

  public function observation_village_import()
  {
    $post = $this->request->getPost();
    $shape = $this->request->getVar('chk_shape') == null ? 0 : 1;
    $dbf = $this->request->getVar('chk_dbf') == null ? 0 : 1;
    
    $import = $this->M_vlgeo->import($post, $shape, $dbf);

    if($import) {
      $this->session->setFlashdata('import', 'Import Village Successfully');
      return redirect()->to('/administrator/geo/village');
    }
  }

  public function observation_village_export($vlcode)
  {
    $path = $this->M_vlgeo->export($vlcode);

    return $this->response->download($path, null);
  }


/**
 * --------------------------------------------------------------------
 *
 * Geo Observations subdistrict - Upload Import - Export
 *
 * --------------------------------------------------------------------
 */
  public function observation_subdistrict_index()
  {
    // $_['GET'] variabel keyword - paginate
    $keyword = $this->request->getGet('keyword');
    $paginate = $this->request->getGet('paginate');

    // fetch data dengan memanggil fungsi model obsgeo
    $this->M_sdgeo->list(null, $keyword, null, $paginate);
  }

  public function observation_subdistrict_upload()
  {
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;

      $this->M_sdgeo->upload_new($data);
    }
    else
    {
      $rules = $this->M_sdgeo->validationImport();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $file = $this->request->getFile('zip_file');
      $this->M_sdgeo->upload_post($file);
    }
  }

  public function observation_subdistrict_import()
  {
    $post = $this->request->getPost();
    $shape = $this->request->getVar('chk_shape') == null ? 0 : 1;
    $dbf = $this->request->getVar('chk_dbf') == null ? 0 : 1;
    
    $import = $this->M_sdgeo->import($post, $shape, $dbf);

    if($import) {
      $this->session->setFlashdata('import', 'Import Subdistrict Successfully');
      return redirect()->to('/administrator/geo/subdistrict');
    }
  }

  public function observation_subdistrict_export($sdcode)
  {
    $path = $this->M_sdgeo->export($sdcode);

    return $this->response->download($path, null);
  }

}