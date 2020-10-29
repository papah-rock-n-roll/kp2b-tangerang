<?php namespace App\Controllers\Adminpanel;
 
class Data extends \App\Controllers\BaseController
{
  public function index()
  {
    echo view('adminpanel/data');
  }

}