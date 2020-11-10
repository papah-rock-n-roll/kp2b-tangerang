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

    if (! $view = cache('adminpanel-access'))
    {
      // simpan view adminpanel/access/main ke variable
      $view = view('adminpanel/access/main', $data);

      // simpan file dir writable\cache selama 1 hari
      cache()->save('adminpanel-access', $view, DAY);
    }
    else
    {
      // jika ada cache, maka ambil dari cache
      $view = cache()->get('adminpanel-access');
    }

    echo $view;

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