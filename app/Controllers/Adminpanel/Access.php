<?php namespace App\Controllers\Adminpanel;

const VIEW_ACCESS_MANAGEMENT = 'adminpanel/access/management/';
 
class Access extends \App\Controllers\BaseController
{
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

  public function management()
  {
    $pager = \Config\Services::pager();
    
    $where = [];
    $like = [];
    $orLike = [];

    $categories = array('' => 'Choose Category') + array_column($this->M_access->getRoleModules(), 'rolename', 'roleid');
    $data['categories'] = $categories;

    $category = $this->request->getGet('category');
    $keyword = $this->request->getGet('keyword');

    $data['category'] = $category;
    $data['keyword'] = $keyword;

    if(! empty($category)) {
      $where = ['mstr_users.role' => $category];
    }

    if(! empty($keyword)) {
      $like = ['mstr_users.name' => $keyword];
      $orLike = ['mstr_users.nik' => $keyword, 'mstr_users.email' => $keyword];
    }

    $data += [
      'list' => $this->M_access->getUsers($where, $like, $orLike),
      'pager' => $this->M_access->pager,
      'create' => '/product/create',
      'read' => '/product/read/',
      'update' => '/product/update/',
      'delete' => '/product/delete/',
    ];
    echo view(VIEW_ACCESS_MANAGEMENT.'list', $data);
  }

}