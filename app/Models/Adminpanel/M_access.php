<?php namespace App\Models\Adminpanel;

use CodeIgniter\Model;
  
class M_access extends Model
{
  protected $table = 'mstr_users';
  protected $primaryKey = 'userid';

/**
 * --------------------------------------------------------------------
 *
 * Access Main
 *
 * --------------------------------------------------------------------
 */
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
    (SELECT COUNT(DISTINCT mstr_users.role) AS count,
    mstr_role.roleid,
    mstr_role.rolename
    FROM mstr_users
    JOIN mstr_role ON mstr_users.role = mstr_role.roleid
    GROUP BY mstr_role.rolename) AS t_count
    WHERE t_count.roleid = {$roleid}");

    return $query->getRow();
  }


/**
 * --------------------------------------------------------------------
 *
 * Access Management
 *
 * --------------------------------------------------------------------
 */
  public function getUsers($where = null, $like = null, $orLike = null, $paginate = 5)
  {
    $query = $this->select('userid,usernik,name,email,rolename,sts')
    ->join('mstr_role', 'mstr_users.role = mstr_role.roleid')
    ->where($where)->like($like)->orLike($orLike)
    ->orderBy('roleid DESC');

    return $query->paginate($paginate, 'users');
  }

  public function getUser($id = null)
  {
    $query = $this->select('usernik,name,phone,email,rolename,sts')
    ->join('mstr_role', 'mstr_users.role = mstr_role.roleid')
    ->where('mstr_users.userid', $id);

    return $query->first();
  }




/**
 * --------------------------------------------------------------------
 *
 * Access Setting
 *
 * --------------------------------------------------------------------
 */

  public function getRoleModules()
  {
    $query = $this->select('roleid,rolename')->from('mstr_role');
    return $query->findAll();
  }

}