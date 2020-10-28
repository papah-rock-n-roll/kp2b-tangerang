<?php namespace App\Models;

use CodeIgniter\Model;
  
class M_auth extends Model
{
  protected $table = "mstr_users";
  protected $primaryKey = 'userid';

  public function userLogin($email, $password)
  {
    $query = $this->query("SELECT
      userid,name,email,password,role,sts
      FROM
      mstr_users
      WHERE email = '{$email}'
    ");
    $data = $query->getRowArray();

    if(!empty($data)) {

      //Akun anda belum aktif
      if($data['sts'] == 'Inactive') {
        return 2;
      }
      
      //Akun access granted
      if(password_verify($password, $data['password'])) 
      {
        $query = $this->query("SELECT rolename FROM mstr_role WHERE roleid = {$data['role']}");
        $rolename = $query->getRow()->rolename;

        $dataSession = [
          'userid' => $data['userid'],
          'rolename' => $rolename,
          'name' => $data['name'],
          'email' => $data['email'],
          'sts' => $data['sts'],
          'menus' => \App\Libraries\Role::modules($data['role']),
        ];
        session()->set($dataSession);

        return 200;
      }
      //Akun password salah
      else
      {
        return 1;
      }

    }
    //Akun tidak terdaftar
    else 
    {
      return 404;
    }

  }
 
  public function register($data)
  {
    $query = "CALL p_insertUser ('{$data->usernik}','{$data->name}','{$data->email}','{$data->password}',
    '{$data->realpassword}',{$data->role},'{$data->sts}','{$data->timestamp}');";

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