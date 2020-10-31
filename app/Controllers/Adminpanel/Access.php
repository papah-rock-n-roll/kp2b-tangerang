<?php namespace App\Controllers\Adminpanel;
 
class Access extends \App\Controllers\BaseController
{

/**
 * --------------------------------------------------------------------
 *
 * Access Main
 *
 * --------------------------------------------------------------------
 */
  public function index()
  {
    $this->M_access->dashboard();
  }


/**
 * --------------------------------------------------------------------
 *
 * Access Management
 *
 * --------------------------------------------------------------------
 */
  public function management_index()
  {
    $role = $this->request->getGet('role');
    $keyword = $this->request->getGet('keyword');

    $module = $this->M_setting->getRoleModules();

    $data['roles'] = array('' => 'Choose Role') + array_column($module, 'rolename', 'roleid');

    $this->M_management->list($role, $keyword, $data);
  }

  public function management_read($id)
  {
    $this->M_management->read($id);
  }

  public function management_create()
  {
    if($this->request->getMethod() === 'get')
    {
      $module = $this->M_setting->getRoleModules();

      $data['roles'] = array('' => 'Choose Role') + array_column($module, 'rolename', 'roleid');
      $data['validation'] = $this->validation;

      $this->M_management->create_new($data);
    }
    else
    {
      $rules = $this->M_management->validationRules();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $file = $this->request->getFile('image');
      $data = $this->request->getPost();

      $post = $this->M_management->create_post($file, $data);

      if($post) {
        $this->session->setFlashdata('success', 'Create User '.$data['name'].' Successfully');
        return redirect()->back();
      }
 
    }
  }

  public function management_update($id)
  {
    if($this->request->getMethod() === 'get')
    {
      $module = $this->M_setting->getRoleModules();

      $data['roles'] = array('' => 'Choose Role') + array_column($module, 'rolename', 'roleid');
      $data['validation'] = $this->validation;

      $this->M_management->update_new($id, $data);
    }
    else
    {
      $rules = $this->M_management->validationRules($id);

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $file = $this->request->getFile('image');
      $data = $this->request->getPost();
      
      $post = $this->M_management->update_post($file, $id, $data);

      if($post) {
        $this->session->setFlashdata('success', 'Update User '.$data['name'].' Successfully');
        return redirect()->back();
      }
 
    }
  }

  public function management_delete($id)
  {
    $data = $this->M_management->getUser($id);
    $delete = $this->M_management->delete_post($id, $data);
    
    if($delete) {
      $this->session->setFlashdata('warning', 'Delete Name '.$data['name'].' Successfully');
      return redirect()->back();
    }
  }


/**
 * --------------------------------------------------------------------
 *
 * Access Setting
 *
 * --------------------------------------------------------------------
 */

  public function setting_index()
  { 
    //$this->M_setting->list();
  }

}