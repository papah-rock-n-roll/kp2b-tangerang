<?php namespace App\Models\Adminpanel\Geo;

/**
 * --------------------------------------------------------------------
 *
 * Geo Main
 *
 * --------------------------------------------------------------------
 */

use CodeIgniter\Model;
use geoPHP;
use ZipArchive;

use Shapefile\ShapefileReader;
use Shapefile\ShapefileWriter;

class M_geo extends Model
{
  public $table = 'v_observations';
  public $primaryKey = 'obscode';

  // get kecamatan
  public function get_kecamatan(){
    $sql = "SELECT `v_observations`.`sdcode`, `v_observations`.`sdname` FROM `v_observations` GROUP BY `v_observations`.`sdcode`, `v_observations`.`sdname`;";
    $query = $this->db->query($sql);
    if(!empty($query)){
      $rows = $query->getResultArray();
      return json_encode($rows);
    }
  }

  // get desa
  public function get_desa($sdcode){
    if(!empty($sdcode)){
      $cond = "WHERE `v_observations`.`sdcode` = '{$sdcode}'";
    }
    else
    {
      $cond = '';
    }
    $sql = "SELECT `v_observations`.`vlcode`, `v_observations`.`vlname`
    FROM `v_observations`
    {$cond}
    GROUP BY `v_observations`.`vlcode`, `v_observations`.`vlname`
    ORDER BY `v_observations`.`vlname`;";

    $query = $this->db->query($sql);

    if(!empty($query)){
      $rows = $query->getResultArray();
      return json_encode($rows);
    }
  }

  // get desa
  public function get_obs_detail($obscode){
    $sql = "SELECT obscode,respname,farmname,sdname,vlname,landuse,areantatus,broadnrea,
      ownernik,ownername,cultivatorname,typeirigation,distancefromriver,
      distancefromIrgPre,wtrtreatnnst,intensitynlan,indxnlant,pattrnnlant,opt,wtr,saprotan,
      other,harvstmax,monthmax,harvstmin,monthmin,harvstsell,username,timestamp
      FROM v_observations WHERE obscode = {$obscode};";
    $query = $this->db->query($sql)->getRowArray();
    return json_encode($query);
  }

  // geojson converter
  public function get_geojson($table, $id_field, $geom_field, $info_fields, $sdcode = null, $vlcode = null){

    // Break fields array
    $fields = '';
    if(!empty($info_fields)){ $fields = ', '.implode(", ", $info_fields);}

    $condSd = '';
    if(!empty($sdcode)){ $condSd = " AND sdcode = '".$sdcode."'"; }

    $condVl = '';
    if(!empty($vlcode)){ $condVl = " AND vlcode = '".$vlcode."'"; }

    // query untuk megambil data
    $sql = "SELECT {$id_field} AS FID, ST_AsText({$geom_field}) AS GEOM {$fields} FROM {$table} WHERE {$geom_field} IS NOT NULL {$condSd}{$condVl};";
    $query = $this->db->query($sql)->getResultArray();

    if(!empty($query)){
      // var geojson untuk return
      $crs = array(
        'type' => 'name',
        'properties' => [
          'name' => 'urn:ogc:def:crs:OGC:1.3:CRS84'
        ]
      );

      $geojson = array(
        'type' => 'FeatureCollection',
        'name' => 'Layer Petak',
        'crs' => $crs,
        'features' => array()
      );

      $features = array();

      foreach ($query as $row){

        $geom = geoPHP::load($row['GEOM'],'wkt');
        $json = $geom->out('json');
        $features = json_decode($json);
        //$features = json_decode($row['GEOM'], true);

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

    } else {
      return false;
    }

    return json_decode($result, true);
  }


/**
 * --------------------------------------------------------------------
 *
 * function
 *
 * --------------------------------------------------------------------
 */

  public function get_observation($obscode)
  {
    $table_1 = 'v_observations';
    $table_2 = 'observations_plantdates';

    $geom_field = 'obsshape';

    $fields_1 = 'obscode,respname,farmcode,farmname,sdcode,sdname,vlcode,vlname,landuse,
    areantatus,broadnrea,ownernik,ownername,cultivatornik,cultivatorname,typeirigation,
    distancefromriver,distancefromIrgPre,wtrtreatnnst,intensitynlan,indxnlant,pattrnnlant,
    opt,wtr,saprotan,other,harvstmax,monthmax,harvstmin,monthmin,harvstsell';

    $fields_2 = 'growceason,monthgrow,monthharvest,varieties,irrigationavbl';

    $query1 = "SELECT {$obscode} AS FID, ST_AsText({$geom_field}) AS GEOM, {$fields_1}
    FROM {$table_1} WHERE {$geom_field} IS NOT NULL AND obscode = {$obscode};";

    $query2 = "SELECT {$fields_2} FROM {$table_2} WHERE obscode = {$obscode};";

    $obs = $this->db->query($query1)->getResultArray();
    $plant = transpose($this->db->query($query2)->getResultArray());

    $info_fields = explode(',', preg_replace('/\s+/', '', ($fields_1 .','. $fields_2)));

    $geojson = array(
      'name' => 'Layer Petak '. $obscode,
      'features' => array()
    );

    if(!empty($query2))
    {
      $data[] = $obs[0] + $plant;
    }
    else
    {
      $plant = [];
      $data[] = $obs[0] + $plant;
    }

    foreach ($data as $row) {

      $geom = geoPHP::load($row['GEOM'],'wkt');

      $properties['FID'] = $row['FID'];
      for ($x = 0; $x < count($info_fields); $x++){
        $properties[$info_fields[$x]] = $row[$info_fields[$x]];
      }

      $polygon = array(
        'type' => 'Feature',
        'bbox' => $geom->getBBox(),
        'properties' => $properties,
        'wkt' => $geom->asText(),
        'area' => $geom->getArea(),
        'id' => $row['FID']
      );

      array_push($geojson['features'], $polygon);
    }

    $result = json_encode($geojson ,JSON_NUMERIC_CHECK);

    return json_decode($result, true);
  }

  public function import_str_replace($string)
  {
    // Hilangkan value 'dan' menjadi koma
    $search = array('/, dan /', '/ dan /',  '/, /', '| kwintal/ha|');
    $replace = array(',', ',', ',', '');
    return preg_replace($search, $replace, $string);
  }

  function extract_zip($pathfile, $filename, $folderName)
  {
    $zip = new ZipArchive;

    if ($zip->open($pathfile .'/'. $filename) === TRUE)
    {
      $zip->extractTo($pathfile .'/'. $folderName);
      $zip->close();

      return true;
    } 
    else 
    {
      return false;
    }
  }

  function compress_zip($pathfile, $filename)
  {
    $zip = new ZipArchive;
    $realfilename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
    $file = fopen($pathfile .'/'. $realfilename .'.zip', 'a+');
    fclose($file);

    if ($zip->open($pathfile .'/'. $realfilename .'.zip') === TRUE)
    {
      $files = directory_map($pathfile);

      foreach($files as $file) {

        if($file == $realfilename .'.zip') continue;
        else $zip->addFile($pathfile .'/'. $file, $file);
        
      }

      $zip->close();

      return $pathfile .'/'. $realfilename .'.zip';
    } 
    else 
    {
      return false;
    }
  }


/**
 * --------------------------------------------------------------------
 *
 * Shapefile
 *
 * --------------------------------------------------------------------
 */

  public static function writer_shapefile(string $pathfile)
  {
    return new ShapefileWriter($pathfile);
  }

  public static function reader_shapefile(string $pathfile)
  {
    return new ShapefileReader($pathfile);
  }

}
