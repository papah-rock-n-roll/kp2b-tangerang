<?php namespace App\Controllers\Adminpanel;
 
class Report extends \App\Controllers\BaseController
{
  public function index()
  {
    echo view('adminpanel/report');
  }

}
