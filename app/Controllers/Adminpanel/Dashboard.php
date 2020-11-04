<?php namespace App\Controllers\Adminpanel;
 
class Dashboard extends \App\Controllers\BaseController
{
  public function index()
  {
    $this->M_dashboard->dashboard();
  }

}