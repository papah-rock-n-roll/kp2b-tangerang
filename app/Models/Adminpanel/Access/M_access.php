<?php namespace App\Models\Adminpanel\Access;

/**
 * --------------------------------------------------------------------
 *
 * Access Main
 *
 * --------------------------------------------------------------------
 */

use CodeIgniter\Model;
  
class M_access extends Model
{

  public function dashboard()
  {
    $data = [
      'total_users' => $this->countUsers()->count,
      'total_roles' => $this->countRoles()->count,
      'total_register' => $this->countRegister()->count,
      'list' => $this->countRole(),
      'moreinfo' => 'access/management',
    ];
    echo view('adminpanel/access/main', $data);
  }

  public function countUsers()
  {
    $query = $this->query("SELECT COUNT(DISTINCT userid) AS count FROM mstr_users");

    return $query->getRow();
  }

  public function countRoles()
  {
    $query = $this->query("SELECT COUNT(DISTINCT roleid) AS count FROM mstr_role");

    return $query->getRow();
  }

  public function countRegister()
  {
    $query = $this->query("SELECT COUNT(DISTINCT userid) AS count FROM mstr_users WHERE `role` = 0");

    return $query->getRow();
  }

  public function countRole()
  {
    $query = $this->db->query("SELECT 
    mstr_role.roleid,
    mstr_role.rolename,
    COUNT(mstr_users.role) AS count
    FROM mstr_users
    RIGHT JOIN mstr_role ON mstr_users.role = mstr_role.roleid
    GROUP BY mstr_role.rolename");

    return $query->getResultArray();
  }

}