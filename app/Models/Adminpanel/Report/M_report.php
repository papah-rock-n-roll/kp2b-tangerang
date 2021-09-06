<?php namespace App\Models\Adminpanel\Report;

/**
 * --------------------------------------------------------------------
 *
 * Data report
 *
 * --------------------------------------------------------------------
 */
use CodeIgniter\Model;

class M_report extends Model{

  protected $db;

  public function __construct(){
    $this->db = \Config\Database::connect();
  }

  // Luas dan jumlah petak
  public function lj($sdcode){

    // Level kecamatan
    if(!empty($sdcode)){
      $sql = "SELECT vlcode AS code, f_tcase(vlname) AS label,
        SUM(luas1) AS luas1, SUM(luas2) AS luas2,
        SUM(jmlh1) AS jmlh1, SUM(jmlh2) AS jmlh2
      FROM (
        SELECT sdcode, sdname, vlcode, vlname,
          SUM(broadnrea) / 10000 AS luas1, 0 AS luas2,
          COUNT(obscode) AS jmlh1, 0 AS jmlh2
        FROM v_observations
        GROUP BY sdcode, sdname, vlcode, vlname, landuse
        HAVING landuse = 'Sawah'

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname,
          0 AS luas1, SUM(broadnrea) / 10000 AS luas2,
          0 AS jmlh1, COUNT(obscode) AS jmlh2
        FROM v_observations
        GROUP BY sdcode, sdname, vlcode, vlname, landuse
        HAVING landuse <> 'Sawah') AS petak
      WHERE sdcode = {$sdcode}
      GROUP BY vlcode, vlname
      ORDER BY vlcode;";

    }else{

      $sql = "SELECT sdcode AS code, f_tcase(sdname) AS label,
        SUM(luas1) AS luas1, SUM(luas2) AS luas2,
        SUM(jmlh1) AS jmlh1, SUM(jmlh2) AS jmlh2
      FROM (
        SELECT sdcode, sdname, vlcode, vlname,
          SUM(broadnrea) / 10000 AS luas1, 0 AS luas2,
          COUNT(obscode) AS jmlh1, 0 AS jmlh2
        FROM v_observations
        GROUP BY sdcode, sdname, vlcode, vlname, landuse
        HAVING landuse = 'Sawah'

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname,
          0 AS luas1, SUM(broadnrea) / 10000 AS luas2,
          0 AS jmlh1, COUNT(obscode) AS jmlh2
        FROM v_observations
        GROUP BY sdcode, sdname, vlcode, vlname, landuse
        HAVING landuse <> 'Sawah') AS petak
      GROUP BY sdcode, sdname
      ORDER BY sdcode;";

    }

    $query = $this->db->query($sql)->getResultArray();
    return json_encode($query);

  }

  // Jumlah Petani pemilik dan penggarap
  public function pp($sdcode){

    if(!empty($sdcode)){

      // Level kecamatan
      $sql = "SELECT vlcode AS code, f_tcase(vlname) AS label, SUM(pemilik) AS pemilik, SUM(penggarap) AS penggarap, SUM(kosong) AS kosong
      FROM (SELECT sdcode, sdname, vlcode, vlname, COUNT(DISTINCT ownernik) AS pemilik, 0 AS penggarap, 0 AS kosong
        FROM v_observations
        WHERE ownernik <> 1 AND ownernik = cultivatornik AND landuse = 'Sawah'
        GROUP BY sdcode, sdname, vlcode, vlname

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname, 0 AS pemilik, COUNT(DISTINCT cultivatornik) AS 'penggarap', 0 AS kosong
        FROM v_observations
        WHERE ownernik <> 1 AND cultivatornik <> 1 AND ownernik <> cultivatornik AND landuse = 'Sawah'
        GROUP BY sdcode, sdname, vlcode, vlname

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname, 0 AS pemilik, COUNT(cultivatornik) AS 'penggarap', 0 AS kosong
        FROM v_observations
        WHERE ownernik <> 1 AND cultivatornik = 1 AND ownernik <> cultivatornik AND landuse = 'Sawah'
        GROUP BY sdcode, sdname, vlcode, vlname

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname, 0 AS pemilik, COUNT(DISTINCT cultivatornik) AS 'penggarap', 0 AS kosong
        FROM v_observations
        WHERE ownernik = 1 AND ownernik <> cultivatornik AND landuse = 'Sawah'
        GROUP BY sdcode, sdname, vlcode, vlname

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname, 0 AS pemilik, 0 AS penggarap, COUNT(cultivatornik) AS kosong
        FROM v_observations
        WHERE ownernik = 1 AND cultivatornik = 1 AND landuse = 'Sawah'
        GROUP BY sdcode, sdname, vlcode, vlname
        ) AS v_petani

      WHERE sdcode = '{$sdcode}'
      GROUP BY vlcode, vlname
      ORDER BY vlcode;";

    }else{

      // Level kabupaten
      $sql = "SELECT sdcode AS code, f_tcase(sdname) AS label, SUM(pemilik) AS pemilik, SUM(penggarap) AS penggarap, SUM(kosong) AS kosong FROM
        (SELECT sdcode, sdname, vlcode, vlname, COUNT(DISTINCT ownernik) AS pemilik, 0 AS penggarap, 0 AS kosong
        FROM v_observations
        WHERE ownernik <> 1 AND ownernik = cultivatornik AND landuse = 'Sawah'
        GROUP BY sdcode, sdname, vlcode, vlname

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname, 0 AS pemilik, COUNT(DISTINCT cultivatornik) AS 'penggarap', 0 AS kosong
        FROM v_observations
        WHERE ownernik <> 1 AND cultivatornik <> 1 AND ownernik <> cultivatornik AND landuse = 'Sawah'
        GROUP BY sdcode, sdname, vlcode, vlname

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname, 0 AS pemilik, COUNT(cultivatornik) AS 'penggarap', 0 AS kosong
        FROM v_observations
        WHERE ownernik <> 1 AND cultivatornik = 1 AND ownernik <> cultivatornik AND landuse = 'Sawah'
        GROUP BY sdcode, sdname, vlcode, vlname

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname, 0 AS pemilik, COUNT(DISTINCT cultivatornik) AS 'penggarap', 0 AS kosong
        FROM v_observations
        WHERE ownernik = 1 AND ownernik <> cultivatornik AND landuse = 'Sawah'
        GROUP BY sdcode, sdname, vlcode, vlname

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname, 0 AS pemilik, 0 AS penggarap, COUNT(cultivatornik) AS kosong
        FROM v_observations
        WHERE ownernik = 1 AND cultivatornik = 1 AND landuse = 'Sawah'
        GROUP BY sdcode, sdname, vlcode, vlname
        ) AS v_petani
      GROUP BY sdcode, sdname
      ORDER BY sdcode;";

    }

    $query = $this->db->query($sql)->getResultArray();
    return json_encode($query);

  }

  // Jumlah Kelompok Tani
  public function pt($sdcode){

    if(!empty($sdcode)){

      // Level kecamatan
      $sql = "SELECT vlcode AS code, f_tcase(vlname) AS label, COUNT(DISTINCT farmcode) AS poktan, SUM(pemilik) AS pemilik, SUM(penggarap) AS penggarap
      FROM (SELECT sdcode, sdname, vlcode, vlname, farmcode, 0 AS pemilik, 0 AS penggarap
        FROM v_observations
        WHERE farmcode <> 1 AND farmname <> 'NI' AND farmname <> 'NO DATA' AND farmname <> 'NON POKTAN'

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname, farmcode, COUNT(DISTINCT ownerid) AS pemilik, 0 AS penggarap
        FROM v_observations
        WHERE ownerid <> 1 AND farmname <> 'NI' AND farmname <> 'NO DATA' AND farmname <> 'NON POKTAN'
        GROUP BY sdcode, sdname, vlcode, vlname, farmcode

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname, farmcode, 0 AS pemilik, COUNT(DISTINCT cultivatorid) AS penggarap
        FROM v_observations
        WHERE cultivatorid <> 1 AND farmname <> 'NI' AND farmname <> 'NO DATA' AND farmname <> 'NON POKTAN'
        GROUP BY sdcode, sdname, vlcode, vlname, farmcode) AS v
      WHERE sdcode = '{$sdcode}'
      GROUP BY vlcode, vlname;";

    }else{

      // Level kabupaten
      $sql = "SELECT sdcode AS code, f_tcase(sdname) AS label, COUNT(DISTINCT farmcode) AS poktan, SUM(pemilik) AS pemilik, SUM(penggarap) AS penggarap
      FROM (SELECT sdcode, sdname, vlcode, vlname, farmcode, 0 AS pemilik, 0 AS penggarap
        FROM v_observations
        WHERE farmcode <> 1 AND farmname <> 'NI' AND farmname <> 'NO DATA' AND farmname <> 'NON POKTAN'

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname, farmcode, COUNT(DISTINCT ownerid) AS pemilik, 0 AS penggarap
        FROM v_observations
        WHERE ownerid <> 1 AND farmname <> 'NI' AND farmname <> 'NO DATA' AND farmname <> 'NON POKTAN'
        GROUP BY sdcode, sdname, vlcode, vlname, farmcode

        UNION ALL

        SELECT sdcode, sdname, vlcode, vlname, farmcode, 0 AS pemilik, COUNT(DISTINCT cultivatorid) AS penggarap
        FROM v_observations
        WHERE cultivatorid <> 1 AND farmname <> 'NI' AND farmname <> 'NO DATA' AND farmname <> 'NON POKTAN' 
        GROUP BY sdcode, sdname, vlcode, vlname, farmcode) AS v
      GROUP BY sdcode, sdname";

    }

    $query = $this->db->query($sql)->getResultArray();
    return json_encode($query);

  }

  // Kalender Tanam
  public function kt($sdcode){

    if(!empty($sdcode)){

      // Level kecamatan
      $sql = "SELECT vlcode AS code, f_tcase(vlname) AS label,
        `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`
      FROM v_g_plantdates
      WHERE sdcode = '{$sdcode}'";

    }else{

      // Level kabupaten
      $sql = "SELECT sdcode AS code, f_tcase(sdname) AS label,
        SUM(`1`) AS `1`, SUM(`2`) AS `2`, SUM(`3`) AS `3`, SUM(`4`) AS `4`, SUM(`5`) AS `5`, SUM(`6`) AS `6`,
        SUM(`7`) AS `7`, SUM(`8`) AS `8`, SUM(`9`) AS `9`, SUM(`10`) AS `10`, SUM(`11`) AS `11`, SUM(`12`) AS `12`
      FROM v_g_plantdates
      GROUP BY sdcode, sdname;";

    }

    $query = $this->db->query($sql)->getResultArray();
    return json_encode($query,JSON_NUMERIC_CHECK);

  }

  // Kalender Panen
  public function kp($sdcode){

    if(!empty($sdcode)){

      // Level kecamatan
      $sql = "SELECT vlcode AS code, f_tcase(vlname) AS label,
        `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`
      FROM v_h_plantdates
      WHERE sdcode = '{$sdcode}'";

    }else{

      // Level kabupaten
      $sql = "SELECT sdcode AS code, f_tcase(sdname) AS label,
        SUM(`1`) AS `1`, SUM(`2`) AS `2`, SUM(`3`) AS `3`, SUM(`4`) AS `4`, SUM(`5`) AS `5`, SUM(`6`) AS `6`,
        SUM(`7`) AS `7`, SUM(`8`) AS `8`, SUM(`9`) AS `9`, SUM(`10`) AS `10`, SUM(`11`) AS `11`, SUM(`12`) AS `12`
      FROM v_h_plantdates
      GROUP BY sdcode, sdname;";

    }

    $query = $this->db->query($sql)->getResultArray();
    return json_encode($query,JSON_NUMERIC_CHECK);

  }

}
