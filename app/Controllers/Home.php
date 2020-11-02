<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends BaseController
{
	public function index()
	{
		$data = [
      'url' => base_url('api/geo/info?table=v_observations&fid=obscode&shape=obsshape&sdcode=360310'),
			'url_kec' => base_url('api/geo/kecamatan')
		];

		echo view('public/home', $data);
	}



	//--------------------------------------------------------------------

}
