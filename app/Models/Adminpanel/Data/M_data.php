<?php namespace App\Models\Adminpanel\Data;

/**
 * --------------------------------------------------------------------
 *
 * Data Main
 *
 * --------------------------------------------------------------------
 */

use CodeIgniter\Model;
use PhpOffice\PhpSpreadsheet;
  
class M_data extends Model
{

  public function dashboard()
  {
    $count = $this->counting();
    $data = [
      'total_observations' => $count->observations,
      'total_owners' => $count->owners,
      'total_cultivators' => $count->cultivators,
      'total_farm' => $count->farms,
    ];

    if (! $view = cache('adminpanel-data'))
    {
      // simpan view adminpanel/data/main ke variable
      $view = view('adminpanel/data/main', $data);

      // simpan file dir writable\cache selama 1 menit
      cache()->save('adminpanel-data', $view, MINUTE);
    }
    else
    {
      // jika ada cache, maka ambil dari cache
      $view = cache()->get('adminpanel-data');
    }

    echo $view;

  }

  public function counting()
  {
    $query = $this->db->query("SELECT 
    COUNT(DISTINCT obscode) AS observations,
    COUNT(DISTINCT ownerid) AS owners,
    COUNT(DISTINCT cultivatorid) AS cultivators,
    COUNT(DISTINCT farmcode) AS farms
    FROM observations_frmobservations
    WHERE ownerid OR cultivatorid OR farmcode <> 1");

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

  public static function spreadsheet()
  {
    return new PhpSpreadsheet\Spreadsheet;
  }

  public static function writer_sheet($spreadsheet)
  {
    return new PhpSpreadsheet\Writer\Xlsx($spreadsheet);
  }

  public static function reader_sheet(string $extension)
  {
    if ($extension == 'xlsx') return new PhpSpreadsheet\Reader\Xlsx();
    if ($extension == 'xls') return new PhpSpreadsheet\Reader\Xls();
  }

}