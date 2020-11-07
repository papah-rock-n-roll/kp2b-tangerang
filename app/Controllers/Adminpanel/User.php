<?php namespace App\Controllers\Adminpanel;
 
class User extends \App\Controllers\BaseController
{
  public function index()
  {
    // $_['GET'] variabel role - keyword - paginate
    $role = $this->request->getGet('role');
    $keyword = $this->request->getGet('keyword');
    $paginate = $this->request->getGet('paginate');

    // fetch data role dari model M_setting dengan array column rolename - roleid
    $roles = $this->M_setting->getRoleModules();
    $data['roles'] = array('' => 'Choose Role') + array_column($roles, 'rolename', 'roleid');

    $this->M_user->dashboard($role, $keyword, $data, $paginate);
  } 

  public function user_get()
  {
    $id = $this->session->get('privilage')->userid;
    $data['validation'] = $this->validation;

    $this->M_user->update_new($id, $data);
  }

  public function user_update($id)
  {
    $rules = $this->M_user->validationRules($id);

    if(! $this->validate($rules)) {
      return redirect()->back()->withInput();
    }

    $file = $this->request->getFile('image');
    $data = $this->request->getPost();
    
    $post = $this->M_user->update_post($file, $id, $data);

    if($post) {
      $this->session->setFlashdata('success', 'Update User '.$data['name'].' Successfully');
      return redirect()->back();
    }
  }


}