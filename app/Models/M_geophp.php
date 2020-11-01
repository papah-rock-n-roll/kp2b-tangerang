<?php namespace App\Models;

use CodeIgniter\Model;
//use geoPHP;

class M_geophp extends Model
{
  protected $table = 'observations_frmobservations';
  protected $primaryKey = 'obscode';
  protected $allowedFields = ['vl_code','farmcode','pemilik','penggarap'];

  // geojson converter
  public function get_geojson($table, $id_field, $geom_field, $info_fields)
  {
    // query untuk mengambil tipe data geometry (ada 3 tipe data geometry yaitu polygon, point dan line)
    $sql = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$table."' AND COLUMN_NAME = '". $geom_field."';";
    $query = $this->query($sql);
    $row = $query->getRow();

    if(isset($row)){
      $data_type = $row->DATA_TYPE;

      // Break fields array
      $fields = '';

      if(!empty($info_fields)){ $fields = ', '.implode(", ", $info_fields);}

      // Untuk tipe geometry polygon
      if($data_type == 'polygon'){

        // query untuk megambil data
        $sql = "SELECT {$id_field} AS FID, ST_AsGeoJSON( {$geom_field} ) AS GEOM {$fields} FROM {$table} WHERE {$geom_field} IS NOT NULL;";
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
            'name' => 'kec_sukadiri',
            'crs' => $crs,
            'features' => array()
          );

          $features = array();

          foreach ($query->getResultArray() as $row){
            $features = json_decode($row['GEOM']);
            $polygon = array(
              'type' => 'Feature',
              'id' => $row['FID'],
              'properties' => array(),
              'geometry' => $features
            );

            $properties = array();
            $properties['FID'] = $row['FID'];
            for ($x = 0; $x < count($info_fields); $x++){
              $properties[$info_fields[$x]] = $row[$info_fields[$x]];
            }
            array_push($polygon['properties'], $properties);
            array_push($geojson['features'], $polygon);
          }
        } else {
          return false;
        }

      // Untuk tipe geometry point. Belum beres
      } else if($data_type == 'point'){
        return false;

      // Untuk tipe geometry line. Belum beres
      } else if($data_type == 'line'){
        return false;

      // Untuk tipe geometry lain. return false aja
      } else {
        return false;
      }

      return $geojson;

    } else {
      return false;
    }
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
      'rules' => 'required|max_length[10]',
      'errors' => [
        'required' => 'Diperlukan {field}',
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
