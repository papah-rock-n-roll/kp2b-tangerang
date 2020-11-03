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

    $farms = $this->M_farmer->getFarms();
    $data['farms'] = array('' => 'Choose farmer') + array_column($farms, 'farmname', 'farmcode');

    $this->M_observation->list($farm, $keyword, $data, $paginate);
  }

  public function observation_read($id)
  {
    $this->M_observation->read($id);
  }

  public function observation_update($id)
  {
    if($this->request->getMethod() === 'get')
    {
      $subdistricts = $this->M_data->getSubdistricts();
      $data['subdistricts'] = array('' => 'Choose Subdistricts') + array_column($subdistricts, 'sdname', 'sdcode');
      
      $villages = $this->M_data->getVillages();
      $data['villages'] = array('' => 'Choose Villages') + array_column($villages, 'vlname', 'vlcode');

      $farms = $this->M_farmer->getFarmers();
      $data['farm'] = array('' => 'Choose Farm') + array_column($farms, 'farmname', 'farmcode');

      $owners = $this->M_owner->getOwners();
      $data['owners'] = array('' => 'Choose Owner') + array_column($owners, 'ownername', 'ownerid');

      $cultivators = $this->M_owner->getOwners();    
      $data['cultivators'] = array('' => 'Choose Cultivator') + array_column($cultivators, 'ownername', 'ownerid');

      $data['validation'] = $this->validation;

      $this->M_observation->update_new($id, $data);
    }
    else
    {
      $rules = $this->M_observation->validationRules();

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


}