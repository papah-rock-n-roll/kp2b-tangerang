<?php namespace App\Controllers\Adminpanel;
 
class Access extends \App\Controllers\BaseController
{
  public function index()
  {
      echo view('adminpanel/access');
  }

}