<?php namespace App\Models\Adminpanel\Report;

/**
 * --------------------------------------------------------------------
 *
 * Data report
 *
 * --------------------------------------------------------------------
 */
use CodeIgniter\Model;

class M_report extends Model
{

  protected $db;

  public function __construct()
  {
    $this->db = \Config\Database::connect();
  }

  // Luas dan jumlah petak
  public function lj($sdcode, $group)
  {
    // Level kecamatan
    if(!empty($sdcode)){
      $sql = "SELECT vlcode AS code, CONCAT ('Desa ', f_tcase(vlname)) AS label,
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
    }
    else
    {
      // Level kabupaten
      if(!empty($group)){
        $sql = "SELECT vlcode AS code, CONCAT ('Kec ', f_tcase(sdname), ' - Desa ', f_tcase(vlname)) AS label,
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
        GROUP BY vlcode, vlname, sdname
        ORDER BY sdname;";
      }else{
        $sql = "SELECT sdcode AS code, CONCAT ('Kecamatan ', f_tcase(sdname)) AS label,
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
    }

    $query = $this->db->query($sql)->getResultArray();

    return json_encode($query);
  }

  // Jumlah Petani pemilik dan penggarap
  public function pp($sdcode, $group)
  {
    // Level kecamatan
    if(!empty($sdcode)){
      $sql = "SELECT vlcode AS code, CONCAT ('Desa ', f_tcase(vlname)) AS label, SUM(pemilik) AS pemilik, SUM(penggarap) AS penggarap, SUM(kosong) AS kosong
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
    }
    else
    {
      // Level kabupaten
      if(!empty($group)){
        $sql = "SELECT vlcode AS code, CONCAT ('Kec ', f_tcase(sdname), ' - Desa ', f_tcase(vlname)) AS label, COUNT(obscode) AS jumlah, SUM(broadnrea)/10000 AS luas
        FROM v_observations
        WHERE landuse = 'Sawah'
        GROUP BY vlcode, vlname, sdname
        ORDER BY sdname;";

        $sql = "SELECT vlcode AS code, CONCAT ('Kec ', f_tcase(sdname), ' - Desa ', f_tcase(vlname)) AS label, SUM(pemilik) AS pemilik, SUM(penggarap) AS penggarap, SUM(kosong) AS kosong FROM
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
          GROUP BY vlcode, vlname, sdname
          ORDER BY sdname;";

      }else{

        $sql = "SELECT sdcode AS code, CONCAT ('Kecamatan ', f_tcase(sdname)) AS label, SUM(pemilik) AS pemilik, SUM(penggarap) AS penggarap, SUM(kosong) AS kosong FROM
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
    }

    $query = $this->db->query($sql)->getResultArray();

    return json_encode($query);
  }

  // Jumlah Kelompok Tani
  public function kt($sdcode, $group)
  {
    // Level kecamatan
    if(!empty($sdcode)){
      $sql = "SELECT vlcode AS code, CONCAT ('Desa ', f_tcase(vlname)) AS label, COUNT(obscode) AS jumlah, SUM(broadnrea)/10000 AS luas
      FROM v_observations
      WHERE sdcode = '{$sdcode}' AND landuse = 'Sawah'
      GROUP BY vlcode, vlname
      ORDER BY vlcode;";
    }
    else
    {
      // Level kabupaten
      if(!empty($group)){
        $sql = "SELECT vlcode AS code, CONCAT ('Kec ', f_tcase(sdname), ' - Desa ', f_tcase(vlname)) AS label, COUNT(obscode) AS jumlah, SUM(broadnrea)/10000 AS luas
        FROM v_observations
        WHERE landuse = 'Sawah'
        GROUP BY vlcode, vlname, sdname
        ORDER BY sdname;";
      }else{
        $sql = "SELECT sdcode AS code, CONCAT ('Kecamatan ', f_tcase(sdname)) AS label, COUNT(obscode) AS jumlah, SUM(broadnrea)/10000 AS luas
        FROM v_observations
        WHERE landuse = 'Sawah'
        GROUP BY sdcode, sdname
        ORDER BY sdcode;";
      }
    }
  }

  // Summary administratif
  public function sa($sdcode, $group)
  {
  }

}
