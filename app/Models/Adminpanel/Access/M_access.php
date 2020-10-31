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
  protected $table = 'mstr_users';
  protected $primaryKey = 'userid';

  public function dashboard()
  {
    $data = [
      'total_users' => $this->countUsers()->count,
      'total_administrator' => $this->countRole(1)->count,
      'total_user' => $this->countRole(2)->count,
      'total_surveyor' => $this->countRole(3)->count,
    ];
    echo view('adminpanel/access/main', $data);
  }

  public function countUsers()
  {
    $query = $this->query("SELECT COUNT(DISTINCT userid) AS count FROM mstr_users");

    return $query->getRow();
  }

  public function countRole($roleid)
  {
    $query = $this->query("SELECT 
    t_count.count AS count
    FROM 
    (SELECT COUNT(mstr_users.role) AS count,
    mstr_role.roleid,
    mstr_role.rolename
    FROM mstr_users
    JOIN mstr_role ON mstr_users.role = mstr_role.roleid
    GROUP BY mstr_role.rolename) AS t_count
    WHERE t_count.roleid = {$roleid}");

    return $query->getRow();
  }

}