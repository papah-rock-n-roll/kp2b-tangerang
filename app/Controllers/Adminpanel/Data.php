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
      $data = $this->fetchDropdown();

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
    if($this->request->getMethod() === 'get')
    {
      $data = $this->fetchDropdown();
      $data['validation'] = $this->validation;

      $this->M_observation->update_new($id, $data);
    }
    else
    {
      $rules = $this->M_observation->validationRules($id);

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $data = $this->request->getPost();
      $post = $this->M_observation->update_post($id, $data);

      if($post) {
        $this->session->setFlashdata('success', 'Update Observation Successfully');
        return redirect()->back();
      }

    }
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
        $this->session->setFlashdata('catch', 'Nilai Index Plantation Melebihi 5');
        return redirect()->back();
      }

    }
    else
    {
      $get = $this->request->getPost();

      $data = $this->transposeData($get);
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
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;
      $this->M_owner->update_new($id, $data);
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
        return redirect()->back();
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
      $rules = $this->M_owner->validationRules();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $data = $this->request->getPost();
      $post = $this->M_farmer->create_post($data);

      if($post) {
        $this->session->setFlashdata('success', 'Create Farm Successfully');
        return redirect()->back();
      }

    }
  }

  public function farmer_update($id)
  {
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;
      $this->M_farmer->update_new($id, $data);
    }
    else
    {
      $rules = $this->M_owner->validationRules($id);

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $data = $this->request->getPost();
      $post = $this->M_farmer->update_post($id, $data);

      if($post) {
        $this->session->setFlashdata('success', 'Update Farm Successfully');
        return redirect()->back();
      }

    }
  }

  public function farmer_delete($id)
  {
    $data = $this->M_farmer->getOwner($id);
    $delete = $this->M_farmer->delete_post($id);

    if($delete) {
      $this->session->setFlashdata('warning', 'Delete Name '.$data['farmname'].' Successfully');
      return redirect()->back();
    }
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
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;
      $this->M_responden->update_new($id, $data);
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
        return redirect()->back();
      }

    }
  }

  public function responden_delete($id)
  {
    $data = $this->M_responden->getOwner($id);
    $delete = $this->M_responden->delete_post($id);

    if($delete) {
      $this->session->setFlashdata('warning', 'Delete Name '.$data['respname'].' Successfully');
      return redirect()->back();
    }
  }



/**
 * --------------------------------------------------------------------
 *
 * Function
 *
 * --------------------------------------------------------------------
 */

  function transposeData($data)
  {
    $retData = array();

    foreach ($data as $row => $columns) {
      foreach ($columns as $row2 => $column2) {
        $retData[$row2][$row] = $column2;
      }
    }
    return $retData;
  }

  function fetchDropdown()
  {
    $subdistricts = $this->M_data->getSubdistricts();
    $data['subdistricts'] = array('' => 'Pilih kecamatan') + array_column($subdistricts, 'sdname', 'sdcode');

    $villages = $this->M_data->getVillages();
    $data['villages'] = array('' => 'Pilih desa') + array_column($villages, 'vlname', 'vlcode');

    $respondens = $this->M_responden->getRespondens();
    $data['respondens'] = array('' => 'Pilih responden') + array_column($respondens, 'respname', 'respid');

    $farms = $this->M_farmer->getFarmers();
    $data['farms'] = array('' => 'Pilih kelompok tani') + array_column($farms, 'farmname', 'farmcode');

    $owners = $this->M_owner->getOwners();
    $newowners = array();

    foreach ($owners as $k => $v) {
      foreach ($v as $nk => $nv) {
        if ($nk == 'ownername') {
          $newowners[$k]['newowners'] = $v['ownernik'] . ' - ' . $v['ownername'];
        }
        $newowners[$k][$nk] = $nv;
      }
    }

    $data['owners'] = array('' => 'Pilih pemilik') + array_column($newowners, 'newowners', 'ownerid');
    $data['cultivators'] = array('' => 'Pilih penggarap') + array_column($newowners, 'newowners', 'ownerid');

    return $data;
  }


}
