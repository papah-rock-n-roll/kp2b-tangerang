<?php namespace App\Models\Adminpanel;

use CodeIgniter\Model;
  
class M_Dashboard extends Model
{
  protected $table = 'tgr_petak';

  public function countPemilik()
  {
    $query = $this->query("SELECT COUNT(DISTINCT Pemilik) AS count FROM tgr_petak;");
    return $query->getRow();
  }

  public function countPenggarap()
  {
    $query = $this->query("SELECT COUNT(DISTINCT Penggarap) AS count FROM tgr_petak;");
    return $query->getRow();
  }

  public function countPoktan()
  {
    $query = $this->query("SELECT COUNT(DISTINCT POKTAN) AS count FROM tgr_petak;");
    return $query->getRow();
  }

  public function countDesa()
  {
    $query = $this->query("SELECT COUNT(DISTINCT Nama_Desa) AS count FROM tgr_petak;");
    return $query->getRow();
  }

  public function getGrafik()
  {
    $data = array();
    $query = $this->query("SELECT
      COUNT(FID) as total,
      LCASE(BT_1) as bulan
      FROM tgr_petak WHERE BT_1 <> '' 
      GROUP BY bulan ORDER BY bulan ASC");

    if(!empty($query)){
      foreach($query->getResultArray() as $row) {
        $data[] = $row;
      }
      return $data;
    }
  }

  public function getTable()
  {
    $query = $this->query("SELECT
      Pemilik, 
      Penggarap, 
      LCASE(POKTAN) as Poktan
      FROM tgr_petak 
      WHERE 
      Pemilik <> '' AND
      Penggarap <> '' AND
      Penggarap <> Pemilik AND
      BT_1 <> ''
      GROUP BY Poktan
      ORDER BY Poktan ASC");
    return $query->getResultArray();
  }
}