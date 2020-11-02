<?php namespace App\Models\Adminpanel;

use CodeIgniter\Model;
  
class M_dashboard extends Model
{
  public function countPemilik()
  {
    $query = $this->query("SELECT COUNT(DISTINCT ownerid) AS count FROM v_observations");
    return $query->getRow();
  }

  public function countPenggarap()
  {
    $query = $this->query("SELECT COUNT(DISTINCT cultivatorid) AS count FROM v_observations");
    return $query->getRow();
  }

  public function countPoktan()
  {
    $query = $this->query("SELECT COUNT(DISTINCT farmname) AS count FROM v_observations");
    return $query->getRow();
  }

  public function countDesa()
  {
    $query = $this->query("SELECT COUNT(DISTINCT vl_code) AS count FROM v_observations");
    return $query->getRow();
  }

  public function getGrafik()
  {
    $data = array();
    $query = $this->query("SELECT DISTINCT
    COUNT(obscode) AS total,
    COALESCE(areantatus,'NO DATA') AS arentatus
    FROM v_observations
    GROUP BY arentatus");

    if(!empty($query)) {
      foreach($query->getResultArray() as $row) {
        $data[] = $row;
      }
      return $data;
    }
  }

  public function getTable()
  {
    $query = $this->query("SELECT
    farmname AS poktan,
    COUNT(DISTINCT ownerid) AS pemilik,
    COUNT(DISTINCT cultivatorid) AS penggarap
    FROM v_observations
    GROUP BY farmname
    HAVING pemilik > 50 AND penggarap > 50");
    return $query->getResultArray();
  }
  
}