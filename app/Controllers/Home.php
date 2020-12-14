<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends BaseController
{

	public function index()
	{
		echo view('welcome_message');
	}

	public function maps()
	{
		$data = [
      'url' => base_url('api/geo/'),
			'url_kec' => base_url('api/geo/kecamatan'),
      'url_desa' => base_url('api/geo/desa'),
      'url_obs' => base_url('api/geo/obsdetail')
		];

		echo view('public/maps', $data);
	}

	public function data()
	{
		$data = [
      'kec' => $this->M_geophp->get_kecamatan()
		];
		echo view('public/data', $data);
	}

	public function chart()
	{
		echo view('public/chart');
	}



	//--------------------------------------------------------------------

}
