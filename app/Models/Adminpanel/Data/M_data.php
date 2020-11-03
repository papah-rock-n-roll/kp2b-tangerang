<?php namespace App\Models\Adminpanel\Data;

/**
 * --------------------------------------------------------------------
 *
 * Access Main
 *
 * --------------------------------------------------------------------
 */

use CodeIgniter\Model;
  
class M_data extends Model
{
  public function dashboard()
  {
    $data = [
      'total_observations' => $this->countObservations()->count,
      'total_owners' => $this->countOwners()->count,
      'total_cultivators' => $this->countCultivators()->count,
      'total_farm' => $this->countFarms()->count,
    ];
    echo view('adminpanel/data/main', $data);
  }

  public function countObservations()
  {
    $query = $this->query("SELECT COUNT(DISTINCT obscode) AS count FROM v_observations");

    return $query->getRow();
  }

  public function countOwners()
  {
    $query = $this->query("SELECT COUNT(DISTINCT ownerid) AS count FROM v_observations");

    return $query->getRow();
  }

  public function countCultivators()
  {
    $query = $this->query("SELECT COUNT(DISTINCT cultivatorid) AS count FROM v_observations");

    return $query->getRow();
  }

  public function countFarms()
  {
    $query = $this->query("SELECT COUNT(DISTINCT farmcode) AS count FROM v_observations");

    return $query->getRow();
  }

  public function getSubdistricts()
  {
    $query = $this->query("SELECT * FROM mstr_subdistricts");

    return $query->getResultArray();
  }

  public function getSubdistrict($id)
  {
    $query = $this->query("SELECT * FROM mstr_subdistricts WHERE sdcode = {$id}");

    return $query->getRowArray();
  }

  public function getVillages()
  {
    $query = $this->query("SELECT * FROM mstr_villages");

    return $query->getResultArray();
  }

  public function getVillage($id)
  {
    $query = $this->query("SELECT * FROM mstr_villages WHERE vlcode = {$id}");

    return $query->getRowArray();
  }

}