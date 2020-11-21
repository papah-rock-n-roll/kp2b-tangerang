<?php namespace App\Controllers;
  
class Auth extends BaseController
{

  public function index()
  {
    if($this->session->has('privilage')) {
      return redirect()->to('administrator/dashboard');
    }
    elseif($this->session->has('try'))
    {
      if(session('try') < 1 )
      {
        return redirect()->to('/block');
      }
      else
      {
        goto login;
      }
    }
    else
    {
      login:
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

          if(session('try') < 1) 
          {
            return redirect()->to('/block');
          }
          else
          {
            $this->session->setFlashdata(
              'errors', 
              'Password <br> Yang anda masukan salah <br>
              <small>Masa Percobaan login - ' . session('try') .'</small>'
              );

            return redirect()->back();
          }
          
          break;

        case 2:
          $this->session->setFlashdata('errors', 'Akun Belum Aktif, <br> Silahkan Contact Administrator');
          return redirect()->to('/login');
          break;

        case 200:
          return redirect()->to('administrator/dashboard');
          break;

        case 404:
          $this->session->setFlashdata('errors', 'Akun - Email <br> Tidak Terdaftar');
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
      $data = $this->request->getPost();
      $simpan = $this->M_auth->register($data);

      if($simpan) {
        $this->session->setFlashdata('success_register', 'Register Successfully');
        return redirect()->to('/login');
      }
    }
  }

  public function logout()
  {
    session()->destroy();
    delete_cookie('kp2b_session');
    delete_cookie('csrf_cookie_kp2b');
    return redirect()->to('/login');
  }

  
  public function block()
  {
    if($this->session->has('try'))
    {
      echo view('auth/block');
    }
    else
    {
      return redirect()->to('/login');
    }

  }

}