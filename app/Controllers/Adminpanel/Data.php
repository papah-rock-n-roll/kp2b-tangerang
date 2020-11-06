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
    $farm = $this->request->getGet('farm');
    $keyword = $this->request->getGet('keyword');
    $paginate = $this->request->getGet('paginate');

    $farms = $this->M_farmer->getFarmers();
    $data['farms'] = array('' => 'Choose Farmer') + array_column($farms, 'farmname', 'farmcode');
    
    $this->M_observation->list($farm, $keyword, $data, $paginate);
  }

  public function observation_read($id)
  {
    $this->M_observation->read($id);
  }

  public function observation_create()
  {
    if($this->request->getMethod() === 'get')
    {
      $data = $this->fetchDropdown();
      $data['validation'] = $this->validation;

      $this->M_observation->create_new($data);
    }
    else
    {
      $rules = $this->M_observation->validationRules();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $data = $this->request->getPost();
      $post = $this->M_observation->create_post($data);

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
      $this->M_plantdate->plantdates_new($id, $data);

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




/**
 * --------------------------------------------------------------------
 *
 * Data farmer
 *
 * --------------------------------------------------------------------
 */




/**
 * --------------------------------------------------------------------
 *
 * Data Responden
 *
 * --------------------------------------------------------------------
 */




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
    $data['subdistricts'] = array('' => 'Choose Subdistrict') + array_column($subdistricts, 'sdname', 'sdcode');
    
    $villages = $this->M_data->getVillages();
    $data['villages'] = array('' => 'Choose Village') + array_column($villages, 'vlname', 'vlcode');

    $respondens = $this->M_responden->getRespondens();
    $data['respondens'] = array('' => 'Choose Responden') + array_column($respondens, 'respname', 'respid');
    
    $farms = $this->M_farmer->getFarmers();
    $data['farms'] = array('' => 'Choose Farmer') + array_column($farms, 'farmname', 'farmcode');

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

    $data['owners'] = array('' => 'Choose Owner') + array_column($newowners, 'newowners', 'ownerid');   
    $data['cultivators'] = array('' => 'Choose Cultivator') + array_column($newowners, 'newowners', 'ownerid');

    return $data;
  }


}