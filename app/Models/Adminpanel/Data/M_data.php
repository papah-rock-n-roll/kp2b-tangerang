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

/**
 * --------------------------------------------------------------------
 * Query
 * --------------------------------------------------------------------
 */ 

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

  public function getSubdistVillage()
  {
    $query = $this->query("SELECT * FROM v_subdist");

    return $query->getResultArray();
  }

  // Api subdist - Remote Select2
  public function getRemoteSubdist($selected, $page)
  {
    $db = \Config\Database::connect();

    if(empty($selected)) $selected = '';
    if(empty($page)) $page = 0;

    $offset = $page * 10;

    $like = ['v_subdist.sdname' => $selected];
    $orlike = ['v_subdist.vlname' => $selected];

    $data = $db->table('v_subdist')->like($like, 'match')
    ->orlike($orlike, 'match')
    ->get(10, $offset)->getResultArray();

    $total_count = count($data);
    
    $result = array(
      'total_count' => $total_count,
      'results' => $data,
    );

    $result = json_encode($result, JSON_NUMERIC_CHECK);
    $result = json_decode($result, true);

    return $result;
  }


/**
 * --------------------------------------------------------------------
 * Spreadsheet
 * --------------------------------------------------------------------
 */   

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