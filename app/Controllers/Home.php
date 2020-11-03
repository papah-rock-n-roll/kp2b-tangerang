<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends BaseController
{
	public function index()
	{
		$data = [
      'url' => base_url('api/geo/'),
			'url_kec' => base_url('api/geo/kecamatan'),
      'url_desa' => base_url('api/geo/desa')
		];

		echo view('public/home', $data);
	}



	//--------------------------------------------------------------------

}
