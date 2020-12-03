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

  public function get_observasion($obscode)
  {
    $table = 'v_observations';
    $id_field = $obscode;
    $geom_field = 'obsshape';
    $fields = 'obscode,respname,farmname,sdname,vlname,landuse,areantatus,broadnrea,
    ownernik,ownername,cultivatorname,typeirigation,distancefromriver,distancefromIrgPre,
    wtrtreatnnst,intensitynlan,indxnlant,pattrnnlant,opt,wtr,saprotan,other,
    harvstmax,monthmax,harvstmin,monthmin,harvstsell';

    $sql = "SELECT {$id_field} AS FID, ST_AsText({$geom_field}) AS GEOM, {$fields}
    FROM {$table} WHERE {$geom_field} IS NOT NULL AND obscode = {$id_field};";

    $row = $this->db->query($sql)->getRowArray();

    $geom = geoPHP::load($row['GEOM'],'wkt');

    $json = $geom->out('json');
    $features = json_decode($json, true);

    $result = json_encode($features, JSON_NUMERIC_CHECK);
    $result = json_decode($result, true);

    return $result;
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
