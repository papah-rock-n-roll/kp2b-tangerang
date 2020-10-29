<?php namespace App\Controllers\Adminpanel;
 
class User extends \App\Controllers\BaseController
{
  public function index()
  {
    echo view('adminpanel/user');
  } 

}