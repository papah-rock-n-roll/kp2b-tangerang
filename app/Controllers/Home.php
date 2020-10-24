<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends BaseController
{
	public function index()
	{
		$info_fields = array('Penggarap', 'Pemilik');
		$t = $this->M_geophp->get_geojson('tgr_petak', 'FID', 'Shape', $info_fields);
		echo $t;
		//return view('welcome_message');
	}

	//--------------------------------------------------------------------

}
