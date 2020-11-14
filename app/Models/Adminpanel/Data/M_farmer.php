<?php namespace App\Models\Adminpanel\Data;

/**
 * --------------------------------------------------------------------
 *
 * Data Farmer
 *
 * --------------------------------------------------------------------
 */
  
class M_farmer extends M_data
{ 
  const VIEW = 'adminpanel/data/farmer/';

  const ACTS = 'administrator/data/farmer/';
  const BACK = '/administrator/data/farmer';

  const CREATE = 'farmer/create';
  const UPDATE = 'farmer/update/';
  const DELETE = 'farmer/delete/';

  const UPLOAD = 'farmer/upload';
  const EXPORT = 'farmer/export';

  protected $table = 'mstr_farmers';
  protected $primaryKey = 'farmcode';

  protected $allowedFields = ['farmcode','farmname','farmmobile','farmhead'];


  public function list($farmer = null, $keyword = null, $data, $paginate)
  {
    $farmer = array();
    $like = array();
    $orLike = array();

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 5
    if(empty($paginate)) {
      $paginate = 5;
    }

    // Masukan Value berdarakan Array Assoc
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    // Jika Tidak null maka like farmname - or like farmhead = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['mstr_farmers.farmname' => $keyword];
      $orLike = ['mstr_farmers.farmhead' => $keyword];
    }

    $data += [
      'list' => $this->getFarmlist($farmer, $like, $orLike, $paginate),
      'pager' => $this->pager,
      'create' => self::CREATE,
      'update' => self::UPDATE,
      'delete' => self::DELETE,
      'import' => self::UPLOAD,
      'export' => self::EXPORT,
    ];

    echo view(self::VIEW.'list', $data);
  }

  public function create_new($data)
  {
    $data += [
      'action' => self::ACTS.'create',
      'back' => self::BACK,
    ];

    echo view(self::VIEW.'create', $data);
  }

  public function create_post($data)
  {
    return $this->insert($data);
  }

  public function update_new($id, $data)
  {
    $data += [
      'action' => self::ACTS.'update/'.$id,
      'v' => $this->getFarmer($id),
      'back' => self::BACK,
    ];

    echo view(self::VIEW.'update', $data);
  }

  public function update_post($id, $data)
  {
    return $this->update($id, $data);
  }

  public function delete_post($id)
  {
    return $this->delete($id);
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

    // cek primary key farmcode
    $farmcode = array_column($sheet, 0);
    $query = $db->query("SELECT farmcode 
      FROM mstr_farmers
      WHERE farmcode IN (".implode(',', $farmcode).")
    ")->getResultArray();

    $inDB = array_column($query, 'farmcode');
    $outDB = array_diff($farmcode, $inDB);

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


/**
 * --------------------------------------------------------------------
 * Query
 * --------------------------------------------------------------------
 */  
  public function getFarmlist($where = null, $like = null, $orLike = null, $paginate = 5)
  {
    $query = $this->select('farmcode, farmname, farmmobile, farmhead')
    ->where($where)->like($like)->orLike($orLike)
    ->orderBy('farmcode ASC');

    return $query->paginate($paginate, 'farmers');
  }
 
  public function getFarmers()
  {
    return $this->findAll();
  }

  public function getFarmer($id)
  {
    return $this->where('farmcode', $id)->first();
  }


/**
 * --------------------------------------------------------------------
 * Validation
 * --------------------------------------------------------------------
 */
  public function validationRules($id = null)
  {
    return [
      'farmname' => [
        'label' => 'Farm Name',
        'rules' => 'required|max_length[50]|is_unique[mstr_farmers.farmname,farmcode,'.$id.']',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'farmmobile' => [
        'label' => 'Phone',
        'rules' => 'required|is_natural|max_length[15]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'farmhead' => [
        'label' => 'Chief',
        'rules' => 'required|max_length[25]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
    
    ];

  }

  public function validationImport()
  {
    return [
      'farm_file' => [
        'label' => 'Farmer File',
        'rules' => 'uploaded[farm_file]|ext_in[farm_file,xls,xlsx]|max_size[farm_file,1000]',
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

    foreach ($data as $v) {

      $db->query("CALL p_importFarmer(
        '{$v[0]}','{$v[1]}','{$v[2]}','{$v[3]}'
      )");

    }
    $affectedRows = $db->affectedRows() > 0 ? true : false;
    
    cache()->delete($filename.'.cache');

    return $affectedRows;
  }


  function export($farmer = null, $keyword = null, $data, $paginate)
  {
    $farmer = array();
    $like = array();
    $orLike = array();

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 5
    if(empty($paginate)) {
      $paginate = 5;
    }

    // Masukan Value berdarakan Array Assoc
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    // Jika Tidak null maka like farmname - or like farmhead = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['mstr_farmers.farmname' => $keyword];
      $orLike = ['mstr_farmers.farmhead' => $keyword];
    }

    // get farmer berdaskan filter data yang ditampilkan ke list awal
    $data = $this->getFarmlist($farmer, $like, $orLike, $paginate);

    // panggil static function spreadsheet "M_data"
    $spreadsheet = M_data::spreadsheet();

    // set column header dimana data akan mulai pada file excel
    $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Farmcode')
    ->setCellValue('B1', 'Farm Name')
    ->setCellValue('C1', 'Farm Mobile')
    ->setCellValue('D1', 'Farm Head');

    // set column value dimana data akan mulai di row 2 pada excel
    $row = 2;
    foreach ($data as $k => $v) {

      $spreadsheet->setActiveSheetIndex(0)
      ->setCellValue('A' . $row, $v['farmcode'])
      ->setCellValue('B' . $row, $v['farmname'])
      ->setCellValue('C' . $row, $v['farmmobile'])
      ->setCellValue('D' . $row, $v['farmhead']);

      $row++;
    }

    // panggil static function writer xlsx "M_data"
    $response = \Config\Services::response();
    $writer = M_data::writer_sheet($spreadsheet);

    $filename = 'farm_'.date('y-m-d').'.xlsx';

    $response
    ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
    ->setHeader('Content-Disposition', 'attachment;filename="'.$filename.'"');

    $writer->save('php://output');
  }

}