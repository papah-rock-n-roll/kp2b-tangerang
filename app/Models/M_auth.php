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
        $dataSession = [
          'userid' => $data['userid'],
          'role' => $data['role'],
          'name' => $data['name'],
          'email' => $data['email'],
          'sts' => $data['sts'],
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
    $this->insert(array('id' => uniqid()) + $data);
    return true;
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
      'email' => [
        'label' => 'email',
        'rules' => 'required|valid_email|is_unique[users.email]',
        'errors' => [
          'valid_email' => '{field} tidak valid',
          'is_unique' => '{field} sudah terdaftar'
        ]
      ],
      'username' => [
        'label' => 'username',
        'rules' => 'required|alpha_numeric|is_unique[users.username]|min_length[6]|max_length[13]',
        'errors' => [
          'alpha_numeric' => '{field} hanya boleh berisi huruf dan angka',
          'is_unique' => '{field} sudah terdaftar',
          'min_length' => '{field} minimal 6 karakter',
          'max_length' => '{field} maksimal 13 karakter'
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
        'rules' => 'required|min_length[6]|max_length[30]',
        'errors' => [
          'min_length' => '{field} minimal 6 karakter',
          'max_length' => '{field} maksimal 30 karakter'
        ]
      ],
      'confirm_password' => [
        'label' => 'confirm password',
        'rules' => 'required|matches[password]|min_length[6]|max_length[30]',
        'errors' => [
          'min_length' => '{field} minimal 6 karakter',
          'max_length' => '{field} maksimal 30 karakter'
        ]
      ],
    ];
  }

}