<?php namespace App\Models\Adminpanel;

use CodeIgniter\Model;
  
class M_dashboard extends Model
{
  protected $table = 'v_observations';

  public function countPemilik()
  {
    $query = $this->query("SELECT COUNT(DISTINCT pemilik) AS count FROM {$this->table};");
    return $query->getRow();
  }

  public function countPenggarap()
  {
    $query = $this->query("SELECT COUNT(DISTINCT penggarap) AS count FROM {$this->table};");
    return $query->getRow();
  }

  public function countPoktan()
  {
    $query = $this->query("SELECT COUNT(DISTINCT farmname) AS count FROM {$this->table};");
    return $query->getRow();
  }

  public function countDesa()
  {
    $query = $this->query("SELECT COUNT(DISTINCT vlname) AS count FROM {$this->table};");
    return $query->getRow();
  }

  public function getGrafik()
  {
    $data = array();
    $query = $this->query("SELECT DISTINCT
    COUNT(obscode) AS total,
    COALESCE(areantatus,'NO DATA') AS arentatus
    FROM {$this->table}
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
    farmname as poktan,
    COUNT(DISTINCT pemilik) AS pemilik,
    COUNT(DISTINCT penggarap) AS penggarap
    FROM {$this->table}
    GROUP BY farmname
    HAVING pemilik > 50 AND penggarap > 50");
    return $query->getResultArray();
  }
}