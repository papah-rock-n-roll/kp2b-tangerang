<?php namespace App\Models\Adminpanel;

use CodeIgniter\Model;
  
class M_dashboard extends Model
{

  public function dashboard()
  {
    $count = $this->counting();
    $data = [
      'total_pemilik' => $count->owners,
      'total_penggarap' => $count->cultivators,
      'total_poktan' => $count->farms,
      'total_desa' => $count->villages,
      'list' => $this->getTable(),
      'graph' => $this->getGrafik(),
    ];
    echo view('adminpanel/dashboard', $data);
  }

  public function counting()
  {
    $query = $this->query("SELECT 
    COUNT(DISTINCT ownerid) AS owners,
    COUNT(DISTINCT cultivatorid) AS cultivators,
    COUNT(DISTINCT farmcode) AS farms,
    COUNT(DISTINCT vlcode) AS villages
    FROM observations_frmobservations
    WHERE ownerid OR cultivatorid OR farmcode <> 1");

    return $query->getRow();
  }

  public function getGrafik()
  {
    $data = array();
    $query = $this->db->query("SELECT DISTINCT
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