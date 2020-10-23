<?php namespace App\Models;

use CodeIgniter\Model;
use phayes\geoPHP\geoPHP;

class M_geophp extends Model
{
  // geoPHP library
  public function get_geojson() {
    if ( ! function_exists('get_geojson')){
      function get_geojson($table, $id_field, $geom_field, $info_fields){
        $ci =& get_instance();
        $ci->load->database();
        // query untuk mengambil tipe data geometry (ada 3 tipe data geometry yaitu polygon, point dan line)
        $sql = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$table."' AND COLUMN_NAME = '". $geom_field."';";
        $query = $ci->db->query($sql);
        $row = $query->row();

        if (isset($row)){
          $data_type = $row->DATA_TYPE;

          // Break fields array
          $fields = '';
          if (!empty($info_fields)){ $fields = ', '.implode(", ", $info_fields);}

          // Untuk tipe geometry polygon
          if($data_type == 'polygon'){
            // query untuk megambil data
            $sql = "SELECT `".$id_field."` AS `FID`, AsText(`".$geom_field."`) as `GEOM`".$fields." FROM `".$table."`;";
            $query = $ci->db->query($sql);
            if($query->num_rows() > 0){
              // var geojson untuk return
              $geojson = array(
                'type' => 'FeatureCollection',
                'features' => array()
              );
              $features = array();

              foreach ($query->result() as $row){
                $geom = geoPHP::load($row['GEOM'],'wkt');
                $json = $geom->out('json');
                $features = json_decode($json);
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
            }else{
              return false;
            }

          // Untuk tipe geometry point. Belum beres
          }else if($data_type == 'point'){
            return false;

          // Untuk tipe geometry line. Belum beres
          }else if($data_type == 'line'){
            return false;

          // Untuk tipe geometry lain. return false aja
          }else{
            return false;
          }

          return json_encode($geojson,JSON_NUMERIC_CHECK);
        }else{
          return false;
        }
      }
    }
  }

}