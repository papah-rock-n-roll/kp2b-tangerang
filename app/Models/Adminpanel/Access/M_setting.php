<?php namespace App\Models\Adminpanel\Access;

/**
 * --------------------------------------------------------------------
 *
 * Access Setting
 *
 * --------------------------------------------------------------------
 */

use CodeIgniter\Model;
  
class M_setting extends Model
{
  protected $table = 'mstr_role';
  protected $primaryKey = 'roleid';

  public function getRoleModules()
  {
    $query = $this->select('roleid,rolename');
    return $query->findAll();
  }

}