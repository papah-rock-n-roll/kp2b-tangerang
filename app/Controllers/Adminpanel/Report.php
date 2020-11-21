<?php namespace App\Controllers\Adminpanel;
 
class Report extends \App\Controllers\BaseController
{
  public function index()
  {
    echo view('adminpanel/report/main');
  }

  public function graph_index()
  {
    echo view('adminpanel/report/graph');
  }

  public function table_index()
  {
    echo view('adminpanel/report/table');
  }

}
