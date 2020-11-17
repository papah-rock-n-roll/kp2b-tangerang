<?php namespace App\Models\Adminpanel\Data;

/**
 * --------------------------------------------------------------------
 *
 * Data Owner
 *
 * --------------------------------------------------------------------
 */

class M_owner extends M_data
{
  const VIEW = 'adminpanel/data/owner/';

  const ACTS = 'administrator/data/owner/';
  const BACK = '/administrator/data/owner';

  const CREATE = 'owner/create';
  const UPDATE = 'owner/update/';
  const DELETE = 'owner/delete/';

  const UPLOAD = 'owner/upload';
  const EXPORT = 'owner/export';

  protected $table = 'mstr_owners';
  protected $primaryKey = 'ownerid';

  protected $allowedFields = ['ownerid','ownernik','ownername','owneraddress'];


  public function list($owner = null, $keyword = null, $data, $paginate)
  {
    $owner = array();
    $like = array();
    $orLike = array();

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 5
    if(empty($paginate)) {
      $paginate = 5;
    }

    // Masukan Value berdarakan Array Assoc
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    // Jika Tidak null maka like ownernik - or like ownername = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['mstr_owners.ownernik' => $keyword];
      $orLike = ['mstr_owners.ownername' => $keyword];
    }

    $data += [
      'list' => $this->getOwnerlist($owner, $like, $orLike, $paginate),
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
      'v' => $this->getOwner($id),
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

    // cek primary key ownerid
    $ownerid = array_column($sheet, 0);
    $query = $db->query("SELECT ownerid
      FROM mstr_owners
      WHERE ownerid IN (".implode(',', $ownerid).")
    ")->getResultArray();

    $inDB = array_column($query, 'ownerid');
    $outDB = array_diff($ownerid, $inDB);

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
  public function getOwnerlist($where = null, $like = null, $orLike = null, $paginate = 5)
  {
    $query = $this->select('ownerid, ownernik, ownername, owneraddress')
    ->where($where)->like($like)->orLike($orLike)
    ->orderBy('ownerid ASC');

    return $query->paginate($paginate, 'default');
  }

  public function getOwners()
  {
    return $this->findAll();
  }

  public function getOwner($id, $nik = null)
  {
    return $this->where('ownerid', $id)->orWhere('ownernik', $nik)->first();
  }


  // Api owners - Remote Select2
  public function getRemoteOwners($selected, $page)
  {
    if(empty($selected)) $selected = '';
    if(empty($page)) $page = 0;

    $offset = $page * 10;

    $like = ['mstr_owners.ownernik' => $selected];
    $orlike = ['mstr_owners.ownername' => $selected];

    $data = $this->like($like, 'match')->orlike($orlike, 'match')->findAll(10, $offset);
    $alldata = $this->like($like, 'match')->orlike($orlike, 'match')->findAll();
    $totaldata = count($alldata);

    $result = array(
      'total_count' => $totaldata,
      'results' => $data
    );

    $result = json_encode($result, JSON_NUMERIC_CHECK);
    $result = json_decode($result, true);

    return $result;
  }


/**
 * --------------------------------------------------------------------
 * Validation
 * --------------------------------------------------------------------
 */
  public function validationRules($id = null)
  {
    return [
      'ownernik' => [
        'label' => 'NIK',
        'rules' => 'required|max_length[30]|is_unique[mstr_owners.ownernik,ownerid,'.$id.']',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'ownername' => [
        'label' => 'Nama',
        'rules' => 'required|max_length[30]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'owneraddress' => [
        'label' => 'Address',
        'rules' => 'required|max_length[255]',
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
      'own_file' => [
        'label' => 'Owner File',
        'rules' => 'uploaded[own_file]|ext_in[own_file,xls,xlsx]|max_size[own_file,1000]',
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

      $db->query("CALL p_importOwner(
        '{$v[0]}','{$v[1]}','{$v[2]}','{$v[3]}'
      )");

    }
    $affectedRows = $db->affectedRows() > 0 ? true : false;

    cache()->delete($filename.'.cache');

    return $affectedRows;
  }


  function export($owner = null, $keyword = null, $data, $paginate)
  {
    $owner = array();
    $like = array();
    $orLike = array();

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 5
    if(empty($paginate)) {
      $paginate = 5;
    }

    // Masukan Value berdarakan Array Assoc
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    // Jika Tidak null maka like ownernik - or like ownername = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['mstr_owners.ownernik' => $keyword];
      $orLike = ['mstr_owners.ownername' => $keyword];
    }

    // get owner berdaskan filter data yang ditampilkan ke list awal
    $data = $this->getOwnerlist($owner, $like, $orLike, $paginate);

    // panggil static function spreadsheet "M_data"
    $spreadsheet = M_data::spreadsheet();

    // set column header dimana data akan mulai pada file excel
    $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Ownerid')
    ->setCellValue('B1', 'Owner Nik')
    ->setCellValue('C1', 'Owner Name')
    ->setCellValue('D1', 'Owner Address');

    // set column value dimana data akan mulai di row 2 pada excel
    $row = 2;
    foreach ($data as $k => $v) {

      $spreadsheet->setActiveSheetIndex(0)
      ->setCellValue('A' . $row, $v['ownerid'])
      ->setCellValue('B' . $row, $v['ownernik'])
      ->setCellValue('C' . $row, $v['ownername'])
      ->setCellValue('D' . $row, $v['owneraddress']);

      $row++;
    }

    // panggil static function writer xlsx "M_data"
    $response = \Config\Services::response();
    $writer = M_data::writer_sheet($spreadsheet);

    $filename = 'pemilik_'.date('y-m-d').'.xlsx';

    $response
    ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
    ->setHeader('Content-Disposition', 'attachment;filename="'.$filename.'"');

    $writer->save('php://output');
  }

}
