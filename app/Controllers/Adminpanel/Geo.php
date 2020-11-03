<?php namespace App\Controllers\Adminpanel;

class Geo extends \App\Controllers\BaseController
{
  public function index()
  {
    $data = [
      'url' => base_url('api/geo/info?table=v_observations&fid=obscode&shape=obsshape&sdcode=360310'),
			'url_kec' => base_url('api/geo/kecamatan')
		];
    echo view('adminpanel/geo/main', $data);
  }

}
