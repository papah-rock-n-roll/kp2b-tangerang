<?php namespace App\Controllers\Adminpanel;

class Data extends \App\Controllers\BaseController
{


/**
 * --------------------------------------------------------------------
 *
 * Data Main
 *
 * --------------------------------------------------------------------
 */
  public function index()
  {
    $this->M_data->dashboard();
  }


/**
 * --------------------------------------------------------------------
 *
 * Data Observation
 *
 * --------------------------------------------------------------------
 */
  public function observation_index()
  {
    // $_['GET'] variabel farm - keyword - paginate
    $farm = $this->request->getGet('farm');
    $keyword = $this->request->getGet('keyword');
    $paginate = $this->request->getGet('paginate');

    // fetch data farmers dengan array column farmname - farmcode
    $farms = $this->M_farmer->getFarmers();
    $data['farms'] = array('' => 'Pilih kelompok tani') + array_column($farms, 'farmname', 'farmcode');

    // fetch data dengan memanggil fungsi model observation
    $this->M_observation->list($farm, $keyword, $data, $paginate);
  }

  public function observation_read($id)
  {
    $this->M_observation->read($id);
  }

  public function observation_create()
  {
    // Jika $_REQUEST = $_GET
    if($this->request->getMethod() === 'get')
    {
      // load service validation = BaseController
      $data['validation'] = $this->validation;
      $this->M_observation->create_new($data);
    }
    else
    {

      // Ambil aturan validasi untuk observation
      $rules = $this->M_observation->validationRules();

      // Jika tidak valid maka kembali dengan mengembalikan nilai input pada session
      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      // Ambil data $_POST
      $data = $this->request->getPost();
      $post = $this->M_observation->create_post($data);

      // Jika bernilai true maka akan di set nilai 'success' pada session flash data
      if($post) {
        $this->session->setFlashdata('success', 'Create Observation Successfully');
        return redirect()->back();
      }

    }
  }

  public function observation_update($id)
  {
    $uri = current_url();
    $get = $this->request->uri->getQuery(['only' => ['post']]);

    $get ?? 'post=1';

    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;
      $this->M_observation->update_new($id, $data, $get);
    }
    else
    {
      $rules = $this->M_observation->validationRules($id);

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $data = $this->request->getVar();
      $post = $this->M_observation->update_post($id, $data);

      if($post) {
        $this->session->setFlashdata('success', 'Update Observation Successfully');

        $num = 1;
        $counter = substr($get, strpos($get, '=') + 1);
        if($counter < 1)
          return redirect()->to($uri.'?post='.$num);
        else return redirect()->to($uri.'?post='.$counter += $num);
      }

    }
  }


/**
 * --------------------------------------------------------------------
 *
 * Data Observations - Upload Import - Export
 *
 * --------------------------------------------------------------------
 */
  public function observation_upload()
  {
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;

      $this->M_observation->upload_new($data);
    }
    else
    {
      $rules = $this->M_observation->validationImport();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $file = $this->request->getFile('obs_file');
      $this->M_observation->upload_post($file);
    }
  }

  public function observation_import()
  {
    $data = $this->request->getPost();
    $import = $this->M_observation->import($data);

    if($import) {
      $this->session->setFlashdata('import', 'Import Petak Berhasil');
      return redirect()->to('/administrator/data/observation');
    }else{
      $this->session->setFlashdata('import', 'Import Petak Berhasil');
      return redirect()->to('/administrator/data/observation');
    }

  }

  public function observation_export()
  {
    // $_['GET'] variabel farm - keyword - paginate
    $farm = $this->request->getGet('farm');
    $keyword = $this->request->getGet('keyword');
    $paginate = $this->request->getGet('paginate');
    $page = $this->request->getGet('page');

    // fetch data dengan memanggil fungsi model observation
    $this->M_observation->export($farm, $keyword, $paginate, $page);
  }


/**
 * --------------------------------------------------------------------
 *
 * Data Observations - Plantdates
 *
 * --------------------------------------------------------------------
 */
  public function observation_plantdates($id)
  {
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;
      $catch = $this->M_plantdate->plantdates_new($id, $data);

      if($catch) {
        $this->session->setFlashdata('catch', 'Nilai Index Plantation Melebihi 9');
        return redirect()->back();
      }

    }
    else
    {
      $get = $this->request->getPost();

      $data = transpose($get);
      $post = $this->M_plantdate->plantdates_post($id, $data);

      if($post) {
        $this->session->setFlashdata('success', 'Create Observation Plantdates Successfully');
        return redirect()->back();
      }

    }

  }


/**
 * --------------------------------------------------------------------
 *
 * Data Owner
 *
 * --------------------------------------------------------------------
 */
  public function owner_index()
  {
    $keyword = $this->request->getGet('keyword');
    $paginate = $this->request->getGet('paginate');

    $this->M_owner->list(null, $keyword, null, $paginate);
  }

  public function owner_create()
  {
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;
      $this->M_owner->create_new($data);
    }
    else
    {
      $rules = $this->M_owner->validationRules();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $data = $this->request->getPost();
      $post = $this->M_owner->create_post($data);

      if($post) {
        $this->session->setFlashdata('success', 'Create Owner Successfully');
        return redirect()->back();
      }

    }
  }

  public function owner_update($id)
  {
    $uri = current_url();
    $get = $this->request->uri->getQuery(['only' => ['post']]);

    $get ?? 'post=1';

    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;
      $this->M_owner->update_new($id, $data, $get);
    }
    else
    {
      $rules = $this->M_owner->validationRules($id);

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $data = $this->request->getPost();
      $post = $this->M_owner->update_post($id, $data);

      if($post) {
        $this->session->setFlashdata('success', 'Update Owner Successfully');

        $num = 1;
        $counter = substr($get, strpos($get, '=') + 1);
        if($counter < 1)
          return redirect()->to($uri.'?post='.$num);
        else return redirect()->to($uri.'?post='.$counter += $num);
      }

    }
  }

  public function owner_delete($id)
  {
    $data = $this->M_owner->getOwner($id);
    $delete = $this->M_owner->delete_post($id);

    if($delete) {
      $this->session->setFlashdata('warning', 'Delete Name '.$data['ownername'].' Successfully');
      return redirect()->back();
    }
  }


/**
 * --------------------------------------------------------------------
 *
 * Data Owner - Upload Import - Export
 *
 * --------------------------------------------------------------------
 */
  public function owner_upload()
  {
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;

      $this->M_owner->upload_new($data);
    }
    else
    {
      $rules = $this->M_owner->validationImport();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $file = $this->request->getFile('own_file');
      $this->M_owner->upload_post($file);
    }
  }

  public function owner_import()
  {
    $data = $this->request->getPost();
    $import = $this->M_owner->import($data);

    if($import) {
      $this->session->setFlashdata('import', 'Import Pemilik Berhasil');
      return redirect()->to('/administrator/data/owner');
    }else{
      $this->session->setFlashdata('import', 'Import Pemilik Berhasil');
      return redirect()->to('/administrator/data/owner');
    }

  }

  public function owner_export()
  {
    // $_['GET'] variabel owner - keyword - paginate
    $keyword = $this->request->getGet('keyword');
    $paginate = $this->request->getGet('paginate');
    $page = $this->request->getGet('page');

    // fetch data dengan memanggil fungsi model observation
    $this->M_owner->export(null, $keyword, $paginate, $page);
  }



/**
 * --------------------------------------------------------------------
 *
 * Data farmer
 *
 * --------------------------------------------------------------------
 */
  public function farmer_index()
  {
    $keyword = $this->request->getGet('keyword');
    $paginate = $this->request->getGet('paginate');

    $this->M_farmer->list(null, $keyword, null, $paginate);
  }

  public function farmer_create()
  {
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;
      $this->M_farmer->create_new($data);
    }
    else
    {
      $rules = $this->M_farmer->validationRules();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $data = $this->request->getVar();
      $post = $this->M_farmer->create_post($data);

      if($post) {
        $this->session->setFlashdata('success', 'Create Farm Successfully');
        return redirect()->back();
      }

    }
  }

  public function farmer_update($id)
  {
    $uri = current_url();
    $get = $this->request->uri->getQuery(['only' => ['post']]);

    $get ?? 'post=1';

    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;
      $this->M_farmer->update_new($id, $data, $get);
    }
    else
    {
      $rules = $this->M_farmer->validationRules($id);

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $data = $this->request->getVar();
      $post = $this->M_farmer->update_post($id, $data);

      if($post) {
        $this->session->setFlashdata('success', 'Update Farm Successfully');

        $num = 1;
        $counter = substr($get, strpos($get, '=') + 1);
        if($counter < 1)
          return redirect()->to($uri.'?post='.$num);
        else return redirect()->to($uri.'?post='.$counter += $num);
      }

    }
  }

  public function farmer_delete($id)
  {
    $data = $this->M_farmer->getFarmer($id);
    $delete = $this->M_farmer->delete_post($id);

    if($delete) {
      $this->session->setFlashdata('warning', 'Delete Name '.$data['farmname'].' Successfully');
      return redirect()->back();
    }
  }


/**
 * --------------------------------------------------------------------
 *
 * Data Farmer - Upload Import - Export
 *
 * --------------------------------------------------------------------
 */
  public function farmer_upload()
  {
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;

      $this->M_farmer->upload_new($data);
    }
    else
    {
      $rules = $this->M_farmer->validationImport();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $file = $this->request->getFile('farm_file');
      $this->M_farmer->upload_post($file);
    }
  }

  public function farmer_import()
  {
    $data = $this->request->getPost();
    $import = $this->M_farmer->import($data);

    if($import) {
      $this->session->setFlashdata('import', 'Import Kelompok Tani Berhasil');
      return redirect()->to('/administrator/data/farmer');
    }else{
      $this->session->setFlashdata('import', 'Import Kelompok Tani Berhasil');
      return redirect()->to('/administrator/data/farmer');
    }

  }

  public function farmer_export()
  {
    // $_['GET'] variabel farmer - keyword - paginate
    $keyword = $this->request->getGet('keyword');
    $paginate = $this->request->getGet('paginate');
    $page = $this->request->getGet('page');

    // fetch data dengan memanggil fungsi model observation
    $this->M_farmer->export(null, $keyword, $paginate, $page);
  }


/**
 * --------------------------------------------------------------------
 *
 * Data Responden
 *
 * --------------------------------------------------------------------
 */
  public function responden_index()
  {
    $keyword = $this->request->getGet('keyword');
    $paginate = $this->request->getGet('paginate');

    $this->M_responden->list(null, $keyword, null, $paginate);
  }

  public function responden_create()
  {
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;
      $this->M_responden->create_new($data);
    }
    else
    {
      $rules = $this->M_responden->validationRules();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $data = $this->request->getPost();
      $post = $this->M_responden->create_post($data);

      if($post) {
        $this->session->setFlashdata('success', 'Create Responden Successfully');
        return redirect()->back();
      }

    }
  }

  public function responden_update($id)
  {
    $uri = current_url();
    $get = $this->request->uri->getQuery(['only' => ['post']]);

    $get ?? 'post=1';

    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;
      $this->M_responden->update_new($id, $data, $get);
    }
    else
    {
      $rules = $this->M_responden->validationRules($id);

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $data = $this->request->getPost();
      $post = $this->M_responden->update_post($id, $data);

      if($post) {
        $this->session->setFlashdata('success', 'Update Responden Successfully');

        $num = 1;
        $counter = substr($get, strpos($get, '=') + 1);
        if($counter < 1)
          return redirect()->to($uri.'?post='.$num);
        else return redirect()->to($uri.'?post='.$counter += $num);
      }

    }
  }

  public function responden_delete($id)
  {
    $data = $this->M_responden->getResponden($id);
    $delete = $this->M_responden->delete_post($id);

    if($delete) {
      $this->session->setFlashdata('warning', 'Delete Name '.$data['respname'].' Successfully');
      return redirect()->back();
    }
  }

}
