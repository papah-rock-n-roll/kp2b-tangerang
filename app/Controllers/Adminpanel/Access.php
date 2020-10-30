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
    $data = [
      'total_users' => $this->M_access->countUsers()->count,
      'total_administrator' => $this->M_access->countRole(1)->count,
      'total_user' => $this->M_access->countRole(2)->count,
      'total_surveyor' => $this->M_access->countRole(3)->count,
    ];
    echo view('adminpanel/access/main', $data);
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
    $where = [];
    $like = [];
    $orLike = [];

    $data['roles'] = array('' => 'Choose Role') + array_column($this->M_access->getRoleModules(), 'rolename', 'roleid');

    $role = $this->request->getGet('role');
    $keyword = $this->request->getGet('keyword');

    $data['role'] = $role;
    $data['keyword'] = $keyword;

    if(!empty($role)) {
      $where = ['mstr_users.role' => $role];
    }

    if(!empty($keyword)) {
      $like = ['mstr_users.name' => $keyword];
      $orLike = ['mstr_users.usernik' => $keyword, 'mstr_users.email' => $keyword];
    }

    $data += [
      'list' => $this->M_access->getUsers($where, $like, $orLike),
      'pager' => $this->M_access->pager,
      'create' => '/administrator/access/management/create',
      'read' => '/administrator/access/management/read/',
      'update' => '/administrator/access/management/update/',
      'delete' => '/administrator/access/management/delete/',
    ];
    echo view('adminpanel/access/management/list', $data);
  }

  public function management_create($id)
  {
    $data = [
      'v' => $this->M_access->getUser($id),
      'back' => '/administrator/access/management',
    ];
    echo view('adminpanel/access/management/read', $data);
  }

  public function management_read($id)
  {
    $data = [
      'v' => $this->M_access->getUser($id),
      'back' => '/administrator/access/management',
    ];
    echo view('adminpanel/access/management/read', $data);
  }

}