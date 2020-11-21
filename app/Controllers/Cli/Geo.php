<?php namespace App\Controllers\Cli;

/**
 * --------------------------------------------------------------------
 * Command Line Geo
 *
 *
 * - Cache geoJSON dengan kondisi 'sdcode'.'code' atau 'vlcode'.'code'
 *
 *  :\> php public\index.php cli geo cache sdcode 360308
 *  :\> php public\index.php cli geo cache vlcode 3603082003
 * 
 *  :\> php public\index.php cli geo cache kecamatan
 *  :\> php public\index.php cli geo cache kelurahan
 * --------------------------------------------------------------------
 */

class Geo extends \App\Controllers\BaseController
{ 
  
  public function cache_geojson($condition, $code)
  {
    $table = 'v_observations';
    $id_field = 'obscode';
    $geom_field = 'obsshape';

    $info_fields = array(
      'areantatus', 'broadnrea', 'typeirigation',	'distancefromriver',	'distancefromIrgPre',	
      'wtrtreatnnst',	'intensitynlan',	'indxnlant',	'pattrnnlant',	'opt',	'wtr',	
      'saprotan',	'other',	'harvstmax',	'monthmax',	'harvstmin',	'monthmin',	
      'harvstsell',	'farmname',	'landuse'
    );

    $condition == 'sdcode' ? $sdcode = $code : $sdcode = null; // 360308
    $condition == 'vlcode' ? $vlcode = $code : $vlcode = null; // 3603082003

    $result = $this->M_geo->get_geojson($table, $id_field, $geom_field, $info_fields, $sdcode, $vlcode);

    // simpan file dir writable\cache selama lamanya
    cache()->save('cache.'.$code.'.geojson', $result, 0);

  }

  public function kecamatan_geojson()
  {
    $db = \Config\Database::connect();
    $data = $db->query('SELECT DISTINCT sdcode FROM v_observations')->getResultArray();
    $data = array_column($data, 'sdcode');

    foreach ($data as $v) {
      $this->cache_geojson('sdcode', $v);
      sleep(3);
    }
  }

  public function kelurahan_geojson()
  {
    $db = \Config\Database::connect();
    $data = $db->query('SELECT DISTINCT vlcode FROM v_observations')->getResultArray();
    $data = array_column($data, 'vlcode');

    foreach ($data as $v) {
      $this->cache_geojson('vlcode', $v);
      sleep(3);
    }
  }

  public function setGeojson_cache(Array $fields = null)
  {
    foreach ($fields as $k => $v) {
      $this->cache_geojson($k, $v);
      sleep(3);
    }
  }

}