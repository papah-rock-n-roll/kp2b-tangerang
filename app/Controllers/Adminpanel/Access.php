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
    $paginate = $this->request->getGet('paginate');

    $module = $this->M_setting->getRoleModules();

    $data['roles'] = array('' => 'Choose Role') + array_column($module, 'rolename', 'roleid');

    $this->M_management->list($role, $keyword, $data, $paginate);
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
    $uri = current_url();
    $get = $this->request->uri->getQuery(['only' => ['post']]);

    $get ?? 'post=1';

    if($this->request->getMethod() === 'get')
    {
      $module = $this->M_setting->getRoleModules();

      $data['roles'] = array('' => 'Choose Role') + array_column($module, 'rolename', 'roleid');
      $data['validation'] = $this->validation;

      $this->M_management->update_new($id, $data, $get);
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

        $num = 1;
        $counter = substr($get, strpos($get, '=') + 1);
        if($counter < 1)
          return redirect()->to($uri.'?post='.$num);
        else return redirect()->to($uri.'?post='.$counter += $num);
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
    $this->M_setting->list();
  }

  public function setting_create()
  {
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;

      $this->M_setting->create_new($data);
    }
    else
    {
      $rules = $this->M_setting->validationRules();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $data = $this->request->getPost();
      $post = $this->M_setting->create_post($data);

      if($post) {
        $this->session->setFlashdata('success', 'Create Role '.$data['rolename'].' Successfully');
        return redirect()->back();
      }
    }

  }

  public function setting_update($id)
  {
    if($this->request->getMethod() === 'get')
    {
      $data['validation'] = $this->validation;

      $this->M_setting->update_new($id, $data);
    }
    else
    {
      $rules = $this->M_setting->validationRules($id);

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }

      $data = array(
        'rolename' => $this->request->getPost('rolename'),
        'rolemodules' => $this->request->getPost('rolemodules'),
        'create' => $this->request->getVar('create') == null ? 0 : 1,
        'read' => $this->request->getVar('read') == null ? 0 : 1,
        'update' => $this->request->getVar('update') == null ? 0 : 1,
        'delete' => $this->request->getVar('delete') == null ? 0 : 1,
        'import' => $this->request->getVar('import') == null ? 0 : 1,
        'export' => $this->request->getVar('export') == null ? 0 : 1,
      );
      $post = $this->M_setting->update_post($id, $data);

      if($post) {
        $this->session->setFlashdata('success', 'Update Role '.$data['rolename'].' Successfully');
        return redirect()->back();
      }

    }
  }

  public function setting_delete($id)
  {
    $data = $this->M_setting->getRole($id);
    $delete = $this->M_setting->delete_post($id);

    if($delete) {
      $this->session->setFlashdata('warning', 'Delete Name '.$data['rolename'].' Successfully');
      return redirect()->back();
    }
  }

/**
 * --------------------------------------------------------------------
 *
 * Access Setting - Database
 *
 * --------------------------------------------------------------------
 */
  public function database($file = null)
  {
    if(empty($file))
    {
      $data['validation'] = $this->validation;
      $this->M_setting->database_list($data);
    }
    else
    {
      $delete = $this->M_setting->database_unlink($file);

      if($delete) {
        $this->session->setFlashdata('warning', 'Delete Name '.$file.' Successfully');
        return redirect()->to('/administrator/access/setting/database');
      }

    }
  }

  public function database_dump()
  {
    $filename = $this->request->getPost('filename');
    $post = $this->M_setting->database_dump($filename);

    if($post) {
      $this->session->setFlashdata('success', 'Dump Database '.$filename.' Successfully');
      return redirect()->to('/administrator/access/setting/database');
    }
  }

  public function database_load($filename)
  {
    $post = $this->M_setting->database_restore($filename);

    if($post) {
      $this->session->setFlashdata('success', 'Restore Database '.$filename.' Successfully');
      return redirect()->to('/administrator/access/setting/database');
    }
  }

  public function database_import()
  {
    $rules = $this->M_setting->validationImport();

    if(! $this->validate($rules)) {
      return redirect()->back()->withInput();
    }

    $file = $this->request->getFile('zip_file');
    $this->M_setting->database_import($file);

    $this->session->setFlashdata('info', 'Import File Name '.$file->getName().' Successfully');
    return redirect()->back();
  }

  public function database_export($file)
  {
    $path = $this->M_setting->database_export($file);
    return redirect()->to(base_url() .'/uploads/databases' .'/'. basename($path));
    //return $this->response->download($path, null);
  }


/**
 * --------------------------------------------------------------------
 *
 * Access Log
 *
 * --------------------------------------------------------------------
 */

  public function log_index()
  {
    // $_['GET'] variabel watch - table - keyword - paginate
    $watch = $this->request->getGet('watch');
    $table = $this->request->getGet('table');
    $keyword = $this->request->getGet('keyword');
    $date = $this->request->getGet('date');
    $paginate = $this->request->getGet('paginate');

    // fetch data list dengan array column name - id
    $list = $this->M_log->getWatch();
    $data['watchs'] = array('' => 'Pilih watch') + array_column($list, 'name', 'name');

    $list = $this->M_log->getTable();
    $data['tables'] = array('' => 'Pilih tabel') + array_column($list, 'name', 'name');

    $this->M_log->list($watch, $table, $date, $keyword, $data, $paginate);
  }

  public function log_read($id)
  {
    $this->M_log->read($id);
  }

  public function log_delete($name)
  {
    $delete = $this->M_log->delete_post($name);

    if($delete) {
      $this->session->setFlashdata('warning', 'Delete Files '.$name.' Successfully');
      return redirect()->to('/administrator/access/log');
    }
  }


}
