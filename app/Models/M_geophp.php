<?php namespace App\Models;

use CodeIgniter\Model;
use geoPHP;

class M_geophp extends Model
{
  protected $table = 'observations_frmobservations';
  protected $primaryKey = 'obscode';
  protected $allowedFields = ['obscode','vlcode','farmcode','ownerid','cultivatorid'];

  protected $db;

  public function __construct()
  {
    // init config database
    $this->db = \Config\Database::connect();
  }

  // get kecamatan
  public function get_kecamatan(){
    $sql = "SELECT `sdcode`, `sdname` FROM `v_observations` GROUP BY `sdcode`, `sdname`;";
    $query = $this->db->query($sql);
    if(!empty($query)){
      $rows = $query->getResultArray();
      return json_decode(json_encode($rows));
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
    $sql = "SELECT obscode,respname,farmname,sdname,vlname,landuse,areantatus,TRUNCATE(broadnrea, 2) AS broadnrea,
      ownernik,ownername,cultivatorname,typeirigation,distancefromriver,
      distancefromIrgPre,wtrtreatnnst,intensitynlan,indxnlant,pattrnnlant,opt,wtr,saprotan,
      other,harvstmax,monthmax,harvstmin,monthmin,harvstsell,username,timestamp
      FROM v_observations WHERE obscode = {$obscode};";
    $query = $this->db->query($sql)->getRowArray();
    return json_encode($query);
  }

  // get data layer
  public function get_data_layer($datalayer){
    if($datalayer == 'desa'){
      $sql = "SELECT `mstr_villages`.`vlcode` AS `FID`, ST_AsText(`mstr_villages`.`vlshape`) AS `GEOM`,
        f_tcase(CONCAT(`mstr_villages`.`vlname`, ' - ', `mstr_subdistricts`.`sdname`)) AS `LABEL`
      FROM `mstr_villages` INNER JOIN `mstr_subdistricts` ON `mstr_subdistricts`.`sdcode` = `mstr_villages`.`sdcode`;";
      $name = "Batas Desa";
    }else if($datalayer == 'kec'){
      $sql = "SELECT `mstr_subdistricts`.`sdcode` AS `FID`, ST_AsText(`mstr_subdistricts`.`sdshape`) AS `GEOM`,
        f_tcase(`mstr_subdistricts`.`sdname`) AS `LABEL`
      FROM `mstr_subdistricts`;";
      $name = "Batas Kecamatan";
    }else if($datalayer == 'kp2b'){
      $sql = "SELECT `kp2b`.`FID`, ST_AsText(`kp2b`.`SHAPE`) AS `GEOM`, `kp2b`.`namobj` AS `LABEL` FROM `kp2b`;";
      $name = "Batas KP2B";
    }

    $query = $this->db->query($sql)->getResultArray();

    if(!empty($query)){

      $crs = array(
        'type' => 'name',
        'properties' => [
          'name' => 'urn:ogc:def:crs:OGC:1.3:CRS84'
        ]
      );

      $geojson = array(
        'type' => 'FeatureCollection',
        'name' => $name,
        'crs' => $crs,
        'features' => array()
      );

      $features = array();

      foreach ($query as $row){

        $geom = geoPHP::load($row['GEOM'],'wkt');
        $json = $geom->out('json');
        $features = json_decode($json);

        $properties['FID'] = $row['FID'];
        $properties['LABEL'] = $row['LABEL'];

        $polygon = array(
          'type' => 'Feature',
          'id' => $row['FID'],
          'properties' => $properties,
          'geometry' => $features
        );

        array_push($geojson['features'], $polygon);

      }

      $result = json_encode($geojson ,JSON_NUMERIC_CHECK);

    } else {

      return false;

    }

    return json_decode($result, true);
  }

  // geojson converter
  public function get_geojson($table, $id_field, $geom_field, $info_fields = null, $sdcode = null, $vlcode = null){

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
          'id' => $row['FID'],
          'properties' => $properties,
          'geometry' => $features
        );

        array_push($geojson['features'], $polygon);

      }

      $result = json_encode($geojson ,JSON_NUMERIC_CHECK);

    } else {
      return false;
    }

    return json_decode($result, true);
  }

  // get information
  public function get_data_info($dataType, $sdcode, $vlcode){
    if(!empty($vlcode)){
      $sql = "SELECT `v_observations`.`{$dataType}` AS `field`,
        COUNT(`v_observations`.`obscode`) AS `petak`,
        SUM(`v_observations`.`broadnrea`) / 10000 AS `luas`,
        MIN(`v_observations`.`harvstmin`) / 10 AS `min`,
        MAX(`v_observations`.`harvstmax`) / 10 AS `max`,
        (AVG(`v_observations`.`harvstmin` + `v_observations`.`harvstmax`) / 2) / 10 AS `avg`
      FROM `v_observations`
      WHERE `v_observations`.`vlcode` = {$vlcode}
      GROUP BY `v_observations`.`{$dataType}`;";
    }else if(!empty($sdcode)){
      $sql = "SELECT `v_observations`.`{$dataType}` AS `field`,
        COUNT(`v_observations`.`obscode`) AS `petak`,
        SUM(`v_observations`.`broadnrea`) / 10000 AS `luas`,
        MIN(`v_observations`.`harvstmin`) / 10 AS `min`,
        MAX(`v_observations`.`harvstmax`) / 10 AS `max`,
        (AVG(`v_observations`.`harvstmin` + `v_observations`.`harvstmax`) / 2) / 10 AS `avg`
      FROM `v_observations`
      WHERE `v_observations`.`sdcode` = {$sdcode}
      GROUP BY `v_observations`.`{$dataType}`;";
    }else{
      $sql = "SELECT `v_observations`.`{$dataType}` AS `field`,
        COUNT(`v_observations`.`obscode`) AS `petak`,
        SUM(`v_observations`.`broadnrea`) / 10000 AS `luas`,
        MIN(`v_observations`.`harvstmin`) / 10 AS `min`,
        MAX(`v_observations`.`harvstmax`) / 10 AS `max`,
        (AVG(`v_observations`.`harvstmin` + `v_observations`.`harvstmax`) / 2) / 10 AS `avg`
      FROM `v_observations`
      GROUP BY `v_observations`.`{$dataType}`;";
    }

    $query = $this->db->query($sql)->getResultArray();
    return json_encode($query);
  }


// --------------------------------------------------------------------------


  public function get_public($conditions = null) : Array
  {
    // data sdcode ambil dari cache
    if (!empty($conditions['sdcode'])) {
      $geoPublic = cache()->get('cache.'.$conditions['sdcode'].'.geojson');
    }

    // data vlcode ambil dari cache
    if (!empty($conditions['vlcode'])) {
      $geoPublic = cache()->get('cache.'.$conditions['vlcode'].'.geojson');
    }

    if ($geoPublic == null) $geoPublic = [];

    return $geoPublic;
  }

}
