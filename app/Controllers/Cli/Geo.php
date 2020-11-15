<?php namespace App\Controllers\Cli;

/**
 * --------------------------------------------------------------------
 * Command Line Geo
 *
 *
 * - Cache geoJSON dengan kondisi 'sdcode'.'code' atau 'vlcode'.'code'
 *
 *  :\> php public\index.php cli geo public cache sdcode 360308
 *
 *  :\> php public\index.php cli geo public cache vlcode 3603082003
 *
 * --------------------------------------------------------------------
 */
 
 class Geo extends \App\Controllers\BaseController
 { 
  
  public function cache_geojson($condition, $code)
  {
    $db = \Config\Database::connect();

    $table = 'v_observations';
    $id_field = 'obscode';
    $geom_field = 'obsshape';

    $info_fields = array(
      'areantatus', 'broadnrea', 'typeirigation',	'distancefromriver',	'distancefromIrgPre',	
      'wtrtreatnnst',	'intensitynlan',	'indxnlant',	'pattrnnlant',	'opt',	'wtr',	
      'saprotan',	'other',	'harvstmax',	'monthmax',	'harvstmin',	'monthmin',	
      'harvstsell',	'farmname',	'landuse'
    );
    
    // Break fields array
    $fields = '';
    if(!empty($info_fields)){ 
      $fields = ', '.implode(", ", $info_fields);
    }

    // query untuk megambil data
    $prepQuery = "SELECT {$id_field} AS FID, ST_AsGeoJSON({$geom_field}) AS GEOM {$fields} 
                  FROM {$table} 
                  WHERE {$geom_field} IS NOT NULL ";

    // query kondisi
    if ($condition == 'sdcode') $prepQuery .= " AND sdcode = {$code} "; // 360308
    if ($condition == 'vlcode') $prepQuery .= " AND vlcode = {$code} "; // 3603082003

    $query = $db->query($prepQuery)->getResultArray();

    if(!empty($query)) {

      // var geojson untuk return
      $crs = array(
        'type' => 'name',
        'properties' => [
          'name' => 'urn:ogc:def:crs:OGC:1.3:CRS84'
        ]
      );

      $geojson = array(
        'type' => 'FeatureCollection',
        'name' => 'Public Layer Petak',
        'crs' => $crs,
        'features' => array()
      );

      $features = array();
      foreach ($query as $row) {
        
        $features = json_decode($row['GEOM'], true);

        $properties['FID'] = $row['FID'];
        if(!empty($info_fields)){
          for ($x = 0; $x < count($info_fields); $x++){
            $properties[$info_fields[$x]] = $row[$info_fields[$x]];
          }
        }

        $polygon = array(
          'type' => 'Feature',
          'properties' => $properties,
          'geometry' => $features,
          'id' => $row['FID']
        );

        array_push($geojson['features'], $polygon);
      }

      $result = json_encode($geojson ,JSON_NUMERIC_CHECK);
      $result = json_decode($result, true);

    } else {
      return false;
    }

    // simpan file dir writable\cache selama 1 minggu
    cache()->save('geojson.'.$code.'.cache', $result, WEEK);

  }

}