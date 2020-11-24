<?php namespace App\Models\Adminpanel\Data;

/**
 * --------------------------------------------------------------------
 *
 * Data Observation
 *
 * --------------------------------------------------------------------
 */

class M_observation extends M_data
{
  const VIEW = 'adminpanel/data/observation/';

  const ACTS = 'administrator/data/observation/';
  const BACK = '/administrator/data/observation';

  const CREATE = 'observation/create';
  const READ   = 'observation/read/';
  const UPDATE = 'observation/update/';
  const DELETE = 'observation/delete/';

  const UPLOAD = 'observation/upload';
  const EXPORT = 'observation/export';

  const PLANTDATE = 'observation/plantdate/';


  protected $table = 'v_observations';
  protected $primaryKey = 'obscode';


  public function list($farm = null, $keyword = null, $data, $paginate)
  {
    $where = array();
    $like = array();
    $orLike = array();

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 5
    if(empty($paginate)) {
      $paginate = 5;
    }

    // Masukan Value berdarakan Array Assoc
    $data['farm'] = $farm;
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    // Jika Tidak null maka where farmcode = $_['GET'] farm
    if(!empty($farm)) {
      $where = ['v_observations.farmcode' => $farm];
    }

    // Jika Tidak null maka like obscode - or like ownername = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['v_observations.obscode' => $keyword];
      $orLike = ['v_observations.ownername' => $keyword];
    }

    $data += [
      'list' => $this->getObservations($where, $like, $orLike, $paginate),
      'pager' => $this->pager,
      'create' => self::CREATE,
      'read' => self::READ,
      'update' => self::UPDATE,
      'delete' => self::DELETE,
      'plantdate' => self::PLANTDATE,
      'import' => self::UPLOAD,
      'export' => self::EXPORT,
    ];
    echo view(self::VIEW.'list', $data);
  }

  public function read($id)
  {
    $data = [
      'v' => $this->getObservation($id),
      'back' => self::BACK,
    ];

    echo view(self::VIEW.'read', $data);
  }

  public function create_new($data)
  {
    // Ganti key Assoc berdasarkan Base dengan value ''
    $optbase = array_fill_keys($this->optbase, '');
    $saprotanbase = array_fill_keys($this->saprotanbase, '');
    $irigationbase = array_fill_keys($this->irigationbase, '');

    $data += [
      'action' => self::ACTS.'create',
      'typeirigation' => $irigationbase,
      'opt' => $optbase,
      'saprotan' => $saprotanbase,
      'back' => self::BACK,
    ];

    echo view(self::VIEW.'create', $data);
  }

  public function create_post($data)
  {
    //return $this->insert($data);
    return false;
  }
  
  public function delete_post($id)
  {
    //return $this->delete($id);
    return false;
  }

  public function update_new($id, $data)
  {
    // Data Observation By obscode
    $obs = $this->getObservation($id);

    // function M_data By base value typeirigation, opt, saprotan
    $observation = parent::recursiveBase($obs);

    $data += [
      'action' => self::ACTS.'update/'.$id,
      'v' => $observation,
      'back' => self::BACK,
    ];

    echo view(self::VIEW.'update', $data);
  }

  public function update_post($id, $data)
  {
    // Pisah Array OTP dan Saprotan menjadi string
    if(!empty($data['opt']))
      $newData['opt'] = implode(',', $data['opt']);
    else $newData['opt'] = '';

    if(!empty($data['saprotan']))
      $newData['saprotan'] = implode(',', $data['saprotan']);
    else $newData['saprotan'] = '';

    if(!empty($data['typeirigation']))
      $newData['typeirigation'] = implode(',', $data['typeirigation']);
    else $newData['typeirigation'] = '';

    // Ganti key Assoc pada $data dengan $newData yang sama OPT dan Saprotan
    $data = array_replace($data, $newData);

    // Fill null jika nilai ''
    $v = array();
    foreach ($data as $k => $val) {
      if ($val == '') {
        $val = null;
      }
      $v[$k] = $val;
    }

    $db = \Config\Database::connect();
    $builder = $db->table('observations_frmobservations');

    $query = [
      'areantatus' => $v['areantatus'],
      'broadnrea' => $v['broadnrea'],
      'typeirigation' => $v['typeirigation'],
      'distancefromriver' => $v['distancefromriver'],
      'distancefromIrgPre' => $v['distancefromIrgPre'],
      'wtrtreatnnst' => $v['wtrtreatnnst'],
      'intensitynlan' => $v['intensitynlan'],
      'indxnlant' => $v['indxnlant'],
      'pattrnnlant' => $v['pattrnnlant'],
      'opt' => $v['opt'],
      'wtr' => $v['wtr'],
      'saprotan' => $v['saprotan'],
      'other' => $v['other'],
      'harvstmax' => $v['harvstmax'],
      'monthmax' => $v['monthmax'],
      'harvstmin' => $v['harvstmin'],
      'monthmin' => $v['monthmin'],
      'harvstsell' => $v['harvstsell'],
      'vlcode' => $v['vlcode'],
      'farmcode' => $v['farmcode'],
      'ownerid' => $v['ownerid'],
      'cultivatorid' => $v['cultivatorid'],
      'respid' => $v['respid'],
      'userid' => session('privilage')->userid,
      'timestamp' => date('y-m-d H:i:s')
    ];

    $builder->set($query);
    $builder->where('obscode', $id);

    return $builder->update();
  }

  public function upload_new($data)
  {
    $data += [
      'action' => self::ACTS.'upload',
      'back' => self::BACK,
    ];
    echo view(self::VIEW.'upload', $data);
  }

  public function upload_post($file)
  {
    $db = \Config\Database::connect();

    $filename = $file->getName();
    $extension = $file->getClientExtension();

    // load phpspreadsheet static function M_data
    if($extension == 'xlsx' || 'Xlsx' )
      $reader = M_data::reader_sheet('xlsx');
    else $reader = M_data::reader_sheet('xls');

    $spreadsheet = $reader->load($file);
    $sheet = $spreadsheet->getActiveSheet()->toArray();

    // remove header
    array_shift($sheet);

    // temp filename
    // simpan file dir writable\cache selama 1 hari
    cache()->save($filename.'.cache', $sheet, DAY);

    // cek primary key obscode
    $obscode = array_column($sheet, 0);
    $query = $db->query("SELECT obscode
      FROM observations_frmobservations
      WHERE obscode IN (".implode(',', $obscode).")
    ")->getResultArray();

    $inDB = array_column($query, 'obscode');
    $outDB = array_diff($obscode, $inDB);

    if(!empty($inDB)) {
      session()->setFlashdata(
        'duplicate',
        'Perhatian.. Semua nilai fields dengan Primary Key ini Akan Terganti.'
      );
    }

    if(!empty($outDB)) {
      session()->setFlashdata(
        'newdata',
        'Data Baru.. Kamu akan menjadi penghuni baru di Database'
      );
    }

    $data = [
      'inDB' => implode(', ', $inDB),
      'outDB' => implode(', ', $outDB),
      'filename' => $filename,
      'action' => self::ACTS.'import',
      'back' => 'upload',
    ];

    echo view(self::VIEW.'import', $data);
  }


  // Api observation - Ajax geo update
  public function update_newAjax($id)
  {
    // Data Observation By obscode
    $obs = $this->getObservation($id);

    // function M_data By base value typeirigation, opt, saprotan
    $observation = parent::recursiveBase($obs);

    return $observation;
  }


/**
 * --------------------------------------------------------------------
 * Query
 * --------------------------------------------------------------------
 */
  public function getObservations($where = null, $like = null, $orLike = null, $paginate = 5)
  {
    $query = $this->select('obscode,	sdcode,	sdname,
    vlcode,	vlname,	farmcode,	farmname,	ownerid,	ownernik,	ownername,
    cultivatorid,	cultivatornik,	cultivatorname')
    ->where($where)->like($like)->orLike($orLike)
    ->orderBy('obscode ASC');

    return $query->paginate($paginate, 'default');
  }

  public function getObservation($id)
  {
    $query = $this->select('obscode,	areantatus,	broadnrea,
    typeirigation,	distancefromriver,	distancefromIrgPre,	wtrtreatnnst,
    intensitynlan,	indxnlant,	pattrnnlant,	opt,	wtr,	saprotan,	other,
    harvstmax,	monthmax,	harvstmin,	monthmin,	harvstsell,	sdcode,	sdname,
    vlcode,	vlname,	farmcode,	farmname,	ownerid,	ownernik,	ownername,
    cultivatorid,	cultivatornik,	cultivatorname,	landuse, respid, respname, userid,	username')
    ->where('obscode', $id)->first();

    return $query;
  }

  public function getExport($where = null, $like = null, $orLike = null, $paginate = 5, $page = 1)
  {
    $query = $this->select('obscode,	areantatus,	broadnrea,	typeirigation,	distancefromriver,
    distancefromIrgPre,	wtrtreatnnst,	intensitynlan,	indxnlant,	pattrnnlant,	opt,	wtr,	saprotan,
    other,	harvstmax,	monthmax,	harvstmin,	monthmin,	harvstsell,	sdname, vlcode,	vlname,	farmcode, farmname,
    ownerid, ownernik,	ownername,	cultivatorid, cultivatornik,	cultivatorname,	landuse, respid, respname')
    ->where($where)->like($like)->orLike($orLike)
    ->orderBy('obscode ASC');

    return $query->paginate($paginate, 'default', $page);
  }


/**
 * --------------------------------------------------------------------
 * Validation
 * --------------------------------------------------------------------
 */
  public function validationRules($id = null)
  {
    return [
      'broadnrea' => [
        'label' => 'Broad Area',
        'rules' => 'required|decimal',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'distancefromriver' => [
        'label' => 'Distance From River',
        'rules' => 'decimal',
        'errors' => [
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'distancefromIrgPre' => [
        'label' => 'Distance From Irrigation',
        'rules' => 'decimal',
        'errors' => [
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'indxnlant' => [
        'label' => 'Index Plantation',
        'rules' => 'required|max_length[3]|numeric',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'pattrnnlant' => [
        'label' => 'Pattern',
        'rules' => 'max_length[100]',
        'errors' => [
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'other' => [
        'label' => 'Other',
        'rules' => 'max_length[100]',
        'errors' => [
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],

    ];

  }

  public function validationImport()
  {
    return [
      'obs_file' => [
        'label' => 'Observation File',
        'rules' => 'uploaded[obs_file]|ext_in[obs_file,xls,xlsx]|max_size[obs_file,1000]',
        'errors' => [
            'ext_in' => '{field} hanya berextensi file .xls atau .xlsx',
            'max_size' => '{field} Maksimal {param}',
            'uploaded' => 'File Excel Belum dipilih'
          ]
      ],
    ];
  }


/**
 * --------------------------------------------------------------------
 * Function
 * --------------------------------------------------------------------
 */
  function import($data)
  {
    $db = \Config\Database::connect();
    $filename = $data['filename'];

    $data = cache()->get($filename.'.cache');
    $userid = session('privilage')->userid;
    $timestamp = date('y-m-d H:i:s');

    foreach ($data as $v) {

      $db->query("CALL p_importObservation(
        '{$v[0]}','{$v[1]}','{$v[2]}','{$v[3]}','{$v[4]}','{$v[5]}','{$v[6]}',
        '{$v[7]}','{$v[8]}','{$v[9]}','{$v[10]}','{$v[11]}','{$v[12]}','{$v[13]}',
        '{$v[14]}','{$v[15]}','{$v[16]}','{$v[17]}','{$v[18]}','{$v[19]}','{$v[20]}',
        '{$v[21]}','{$v[22]}','{$v[23]}','{$v[24]}','{$userid}','{$timestamp}'
      )");
    }
    $affectedRows = $db->affectedRows() > 0 ? true : false;

    cache()->delete($filename.'.cache');

    return $affectedRows;
  }


  function export($farm = null, $keyword = null, $paginate, $page)
  {
    $where = array();
    $like = array();
    $orLike = array();

    // Berdasarkan value $_['GET'] page, jika page null maka menjadi 1
    if(empty($page)) {
      $page = 1;
    }

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 5
    if(empty($paginate)) {
      $paginate = 5;
    }

    // Jika Tidak null maka where farmcode = $_['GET'] farm
    if(!empty($farm)) {
      $where = ['v_observations.farmcode' => $farm];
    }

    // Jika Tidak null maka like obscode - or like ownername = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['v_observations.obscode' => $keyword];
      $orLike = ['v_observations.ownername' => $keyword];
    }

    // get observations berdaskan filter data yang ditampilkan ke list awal
    $data = $this->getExport($where, $like, $orLike, $paginate, $page);

    // panggil static function spreadsheet "M_data"
    $spreadsheet = M_data::spreadsheet();

    // set column header dimana data akan mulai pada file excel
    $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Obscode')
    ->setCellValue('B1', 'Owner')
    ->setCellValue('C1', 'Cultivator')
    ->setCellValue('D1', 'Farmer')
    ->setCellValue('E1', 'Area Status')
    ->setCellValue('F1', 'Broad Area')
    ->setCellValue('G1', 'Type Irrigation')
    ->setCellValue('H1', 'Distance From River')
    ->setCellValue('I1', 'Distance From Irigation')
    ->setCellValue('J1', 'Water Installment')
    ->setCellValue('K1', 'Intensity Land')
    ->setCellValue('L1', 'Index Plantations')
    ->setCellValue('M1', 'Pattern Plantations')
    ->setCellValue('N1', 'Responden')
    ->setCellValue('O1', 'Relate Production OPT')
    ->setCellValue('P1', 'Relate Production Air')
    ->setCellValue('Q1', 'Relate Production Saprotan')
    ->setCellValue('R1', 'Other')
    ->setCellValue('S1', 'Harvest Max')
    ->setCellValue('T1', 'Month Max')
    ->setCellValue('U1', 'Harvest Min')
    ->setCellValue('V1', 'Month Min')
    ->setCellValue('W1', 'Harvest Sell')
    ->setCellValue('X1', 'Land Use')
    ->setCellValue('Y1', 'Village')
    ->setCellValue('Z1', 'Subdistrict');

    // set column value dimana data akan mulai di row 2 pada excel
    $row = 2;
    foreach ($data as $k => $v) {

      $spreadsheet->setActiveSheetIndex(0)
      ->setCellValue('A' . $row, $v['obscode'])
      ->setCellValue('B' . $row, $v['ownername'].' # '.$v['ownernik'].' # '.$v['ownerid'])
      ->setCellValue('C' . $row, $v['cultivatorname'].' # '.$v['cultivatornik'].' # '.$v['cultivatorid'])
      ->setCellValue('D' . $row, $v['farmname'].' # '.$v['farmcode'])
      ->setCellValue('E' . $row, $v['areantatus'])
      ->setCellValue('F' . $row, $v['broadnrea'])
      ->setCellValue('G' . $row, $v['typeirigation'])
      ->setCellValue('H' . $row, $v['distancefromriver'])
      ->setCellValue('I' . $row, $v['distancefromIrgPre'])
      ->setCellValue('J' . $row, $v['wtrtreatnnst'])
      ->setCellValue('K' . $row, $v['intensitynlan'])
      ->setCellValue('L' . $row, $v['indxnlant'])
      ->setCellValue('M' . $row, $v['pattrnnlant'])
      ->setCellValue('N' . $row, $v['respname'].' # '.$v['respid'])
      ->setCellValue('O' . $row, $v['opt'])
      ->setCellValue('P' . $row, $v['wtr'])
      ->setCellValue('Q' . $row, $v['saprotan'])
      ->setCellValue('R' . $row, $v['other'])
      ->setCellValue('S' . $row, $v['harvstmax'])
      ->setCellValue('T' . $row, $v['monthmax'])
      ->setCellValue('U' . $row, $v['harvstmin'])
      ->setCellValue('V' . $row, $v['monthmin'])
      ->setCellValue('W' . $row, $v['harvstsell'])
      ->setCellValue('X' . $row, $v['landuse'])
      ->setCellValue('Y' . $row, $v['vlname'].' # '.$v['vlcode'])
      ->setCellValue('Z' . $row, $v['sdname']);

      $row++;
    }

    // panggil static function writer xlsx "M_data"
    $response = \Config\Services::response();
    $writer = M_data::writer_sheet($spreadsheet);

    $filename = 'petak_'.date('y-m-d').'.xlsx';

    $response
    ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
    ->setHeader('Content-Disposition', 'attachment;filename="'.$filename.'"');

    $writer->save('php://output');
  }

}
