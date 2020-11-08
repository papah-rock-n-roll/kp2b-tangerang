<?php namespace App\Models;

use CodeIgniter\Model;
  
class M_auth extends Model
{
  protected $table = "mstr_users";
  protected $primaryKey = 'userid';

  public function userLogin($email, $password)
  {
    // check database mstr_users join mstr_role
    $query = $this->query("SELECT
      t_user.userid,
      t_user.name,
      t_user.email,
      t_user.password,
      t_user.role,
      t_role.rolename,
      t_user.image,
      t_user.sts
      FROM
      mstr_users t_user
      JOIN mstr_role t_role ON t_role.roleid = t_user.role
      WHERE email = '{$email}'
    ");
    $data = $query->getRowArray();

    if(!empty($data)) {

      // Akun anda belum aktif
      if($data['sts'] == 'Inactive') {
        return 2;
      }
      
      // Akun access granted
      if(password_verify($password, $data['password'])) 
      {
        // ambil data actions berdasarkan role
        $menus = \App\Libraries\Role::modules($data['role']);
        $role = \App\Libraries\Role::actions($data['role']);        

        // fetch data privilage kedalam session dengan format object stdclass
        $dataSession['privilage'] = (object) [
          'userid' => $data['userid'],
          'rolename' => $data['rolename'],
          'name' => $data['name'],
          'image' => $data['image'],
          'email' => $data['email'],
          'sts' => $data['sts'],
          'menus' => $menus,
          'acts' => $role['acts'],
          'disable' => $role['actions'],
        ];
        session()->set($dataSession);

        return 200;
      }
      // Akun password salah
      else
      {
        return 1;
      }

    }
    // Akun tidak terdaftar
    else 
    {
      return 404;
    }

  }
 
  public function register($data)
  {
    $p = (object) array(
      'usernik' => $data['usernik'],
      'name' => $data['name'],
      'phone' => null,
      'email' => $data['email'],
      'password' => password_hash($data['password'], PASSWORD_DEFAULT),
      'realpassword' => $data['password'],
      'role' => 0,
      'image' => 'default.png',
      'sts' => 'Inactive',
      'timestamp' => date('y-m-d H:i:s'),
    );

    $query = "CALL p_insertUser ('{$p->usernik}','{$p->name}','{$p->phone}','{$p->email}','{$p->password}',
    '{$p->realpassword}',{$p->role},'{$p->image}','{$p->sts}','{$p->timestamp}');";

    return $this->query($query);
  }

  public function authlogin()
  {
    return [
      'email' => [
        'label' => 'email',
        'rules' => 'required|valid_email',
        'errors' => [
          'valid_email' => '{field} tidak valid',
        ]
      ],
      'password' => [
        'label' => 'password',
        'rules' => 'required',
      ],
    ];
  }

  public function validationRegister()
  {
    return [
      'usernik' => [
        'label' => 'usernik',
        'rules' => 'alpha_numeric|is_unique[mstr_users.usernik]|max_length[30]',
        'errors' => [
          'alpha_numeric' => '{field} hanya boleh berisi huruf dan angka',
          'is_unique' => '{field} sudah terdaftar',
          'max_length' => '{field} maksimal 30 karakter'
        ]
      ],
      'email' => [
        'label' => 'email',
        'rules' => 'required|valid_email|is_unique[mstr_users.email]',
        'errors' => [
          'valid_email' => '{field} tidak valid',
          'is_unique' => '{field} sudah terdaftar'
        ]
      ],
      'name' => [
        'label' => 'name',
        'rules' => 'required|alpha_numeric_space|min_length[6]|max_length[30]',
        'errors' => [
          'alpha_numeric' => '{field} hanya boleh berisi huruf dan angka',
          'min_length' => '{field} minimal 6 karakter',
          'max_length' => '{field} maksimal 30 karakter'
        ]
      ],
      'password' => [
        'label' => 'password',
        'rules' => 'required|min_length[6]|max_length[60]',
        'errors' => [
          'min_length' => '{field} minimal 6 karakter',
          'max_length' => '{field} maksimal 30 karakter'
        ]
      ],
      'confirm_password' => [
        'label' => 'confirm password',
        'rules' => 'required|matches[password]|min_length[6]|max_length[60]',
        'errors' => [
          'min_length' => '{field} minimal 6 karakter',
          'max_length' => '{field} maksimal 30 karakter'
        ]
      ],
    ];
  }

}