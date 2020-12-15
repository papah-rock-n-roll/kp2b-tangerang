<?php namespace App\Controllers\Adminpanel;

class Report extends \App\Controllers\BaseController
{
  public function index()
  {
		$data = [
      'kec' => $this->M_geophp->get_kecamatan()
		];
    echo view('adminpanel/report/main', $data);
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
