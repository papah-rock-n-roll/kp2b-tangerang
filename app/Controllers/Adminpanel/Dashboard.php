<?php namespace App\Controllers\Adminpanel;
 
class Dashboard extends \App\Controllers\BaseController
{
  public function index()
  {
    $data = [
      'total_pemilik' => $this->M_dashboard->countPemilik()->count,
      'total_penggarap' => $this->M_dashboard->countPenggarap()->count,
      'total_poktan' => $this->M_dashboard->countPoktan()->count,
      'total_desa' => $this->M_dashboard->countDesa()->count,
      'list' => $this->M_dashboard->getTable(),
      'graph' => $this->M_dashboard->getGrafik(),
    ];
    echo view('adminpanel/dashboard', $data);
  }

  public function access()
  {
    echo view('adminpanel/access');
  }

  public function user()
  {
    echo view('adminpanel/user');
  } 

  public function data()
  {
    echo view('adminpanel/data');
  } 

  public function geo()
  {
    echo view('adminpanel/geo');
  } 

  public function report()
  {
    echo view('adminpanel/report');
  } 

}