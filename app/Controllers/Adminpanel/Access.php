<?php namespace App\Controllers\Adminpanel;
 
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
    $data = [
      'list' => $this->M_access->getUsers(),
      'create' => '/adminpanel/access/create',
      'update' => '/adminpanel/access/update/',
      'delete' => '/adminpanel/access/delete/',
    ];
    echo view('adminpanel/access/management/list', $data);
  }

}