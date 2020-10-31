<?php namespace App\Models\Adminpanel\Access;

/**
 * --------------------------------------------------------------------
 *
 * Access Setting
 *
 * --------------------------------------------------------------------
 */

class M_setting extends \App\Models\Adminpanel\Access\M_access
{
  const ACTS = 'administrator/access/setting/';
  const VIEW = 'adminpanel/access/setting/';
  const BACK = '/administrator/access/setting';

  const CREATE = 'setting/create';
  const UPDATE = 'setting/update/';
  const DELETE = 'setting/delete/';


  protected $table = 'mstr_role';
  protected $primaryKey = 'roleid';

  protected $allowedFields = ['rolename','rolemodules','create','read','update','delete'];

  public function list()
  {
    $data = [
      'list' => $this->getRoles(),
      'create' => self::CREATE,
      'update' => self::UPDATE,
      'delete' => self::DELETE,
    ];
    echo view(self::VIEW.'list', $data);
  }

  public function getRoles()
  {
    return $this->findAll();
  }

  public function getRole($id)
  {
    return $this->where('roleid', $id)->first();
  }

  public function getRoleModules()
  {
    $query = $this->select('roleid,rolename');
    return $query->findAll();
  }

}