<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends BaseController
{
	public function index()
	{
		$data = [
      'url' => base_url('api/geo'),
			'url_kec' => base_url('api/geo/kecamatan')
		];

		echo view('public/home', $data);
	}



	//--------------------------------------------------------------------

}
