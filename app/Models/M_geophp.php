<?php namespace App\Models;

use CodeIgniter\Model;
//use geoPHP;

class M_geophp extends Model
{
  protected $table = 'observations_frmobservations';
  protected $primaryKey = 'obscode';
  protected $allowedFields = ['obscode','vl_code','farmcode','pemilik','penggarap'];

  // get kecamatan
  public function get_kecamatan(){
    $sql = "SELECT `v_observations`.`sdcode`, `v_observations`.`sdname` FROM `v_observations` GROUP BY `v_observations`.`sdcode`, `v_observations`.`sdname`;";
    $query = $this->query($sql);
    if(!empty($query)){
      $rows = $query->getResultArray();
      return json_encode($rows);
    }
  }

  // get desa
  public function get_desa($sdcode){
    if($sdcode != ''){
      $cond = "WHERE `v_observations`.`sdcode` = '{$sdcode}'";
    }
    $sql = "SELECT `v_observations`.`vl_code`, `v_observations`.`vlname`
      FROM `v_observations`
      {$cond}
      GROUP BY `v_observations`.`vl_code`, `v_observations`.`vlname`
      ORDER BY `v_observations`.`vlname`;";
    $query = $this->query($sql);
    if(!empty($query)){
      $rows = $query->getResultArray();
      return json_encode($rows);
    }
  }

  // geojson converter
  public function get_geojson($table, $id_field, $geom_field, $info_fields, $sdcode = null, $vlcode = null){

      // Break fields array
      $fields = '';
      if(!empty($info_fields)){ $fields = ', '.implode(", ", $info_fields);}

      $condSd = '';
      if(!empty($sdcode)){ $condSd = " AND sdcode = '".$sdcode."'"; }

      $condVl = '';
      if(!empty($vlcode)){ $condVl = " AND vl_code = '".$vlcode."'"; }

        // query untuk megambil data
        $sql = "SELECT {$id_field} AS FID, ST_AsGeoJSON( {$geom_field} ) AS GEOM {$fields} FROM {$table} WHERE {$geom_field} IS NOT NULL {$condSd}{$condVl};";
        $query = $this->query($sql);

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

          foreach ($query->getResultArray() as $row){
            $features = json_decode($row['GEOM']);

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
        } else {
          return false;
        }

      return json_encode($geojson,JSON_NUMERIC_CHECK);
  }

/*

  public function postGeo($data)
  {
    return $this->insert($data);
  }

*/

  public function putGeo($id, $data)
  {
    return $this->update($id, $data);
  }

  public function validationRules($id = null)
  {
    return [
      'vl_code' => [
      'label' => 'Kode Desa',
      'rules' => 'required|max_length[10]|is_unique[observations_frmobservations.obscode,obscode,'.$id.']',
      'errors' => [
        'required' => 'Diperlukan {field}',
        'is_unique' => 'Data {field} {value} Sudah Ada',
        'max_length' => '{field} Maximum {param} Character',
        ]
      ],
      'farmcode' => [
        'label' => 'Kode Desa',
        'rules' => 'required|max_length[10]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'pemilik' => [
        'label' => 'ID Pemilik',
        'rules' => 'required|max_length[10]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'penggarap' => [
        'label' => 'ID Penggarap',
        'rules' => 'required|max_length[10]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],

    ];
  }
}
