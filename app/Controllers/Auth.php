<?php namespace App\Controllers;
  
class Auth extends BaseController
{
  public function index()
  {
    if($this->session->has('id')) {
      return redirect()->route('dashboard');
    }
    else
    {
      $data = [
        'validation' => $this->validation,
        'action' => '/login',
        'register' => '/register',
      ];
      echo view('auth/login', $data);
    }
  }

  public function login()
  {
    if($this->request->getMethod() === 'get') 
    {
      return redirect()->to('/login');
    }
    else
    {
      $rules = $this->M_auth->authlogin();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }
      
      $email = $this->request->getPost('email');
      $password = $this->request->getPost('password');

      $check = $this->M_auth->userLogin($email, $password);

      switch($check) {

        case 1:
          $this->session->setFlashdata('errors', 'Password yang Anda masukan salah');
          return redirect()->back();
          break;

        case 2:
          $this->session->setFlashdata('errors', 'Akun anda belum aktif, Silahkan Contact Administrator');
          return redirect()->to('/login');
          break;

        case 200:

          return redirect()->to('administrator/dashboard');
          break;

        case 404:
          $this->session->setFlashdata('errors', 'Email yang Anda masukan tidak terdaftar');
          return redirect()->to('/login');
          break;
      }
      
    }
  }

  public function register()
  {
    if($this->request->getMethod() === 'get') 
    {
      $data = [
        'validation' => $this->validation,
        'action' => '/register',
        'cancel' => '/login',
      ];
      echo view('auth/register', $data);
    }
    else
    {
      $rules = $this->M_auth->validationRegister();

      if(! $this->validate($rules)) {
        return redirect()->back()->withInput();
      }
      $data = (object) array(
        'usernik' => $this->request->getPost('usernik'),
        'name' => $this->request->getPost('name'),
        'email' => $this->request->getPost('email'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'realpassword' => $this->request->getPost('password'),
        'role' => 0,
        'sts' => 'Inactive',
        'timestamp' => date('y-m-d H:i:s'),
      );
      $simpan = $this->M_auth->register($data);

      if($simpan) {
        $this->session->setFlashdata('success_register', 'Register Successfully');
        return redirect()->to('/login');
      }
    }
  }

  public function logout()
  {
    $this->session->destroy();
    return redirect()->to('/');
  }

}