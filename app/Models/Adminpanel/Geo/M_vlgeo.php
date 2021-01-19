<?php namespace App\Models\Adminpanel\Geo;

/**
 * --------------------------------------------------------------------
 *
 * Geo villages
 *
 * --------------------------------------------------------------------
 */

use Shapefile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\Geometry\Polygon;


class M_vlgeo extends M_geo
{
  const VIEW = 'adminpanel/geo/observation/';

  const ACTS = 'administrator/geo/observation/';
  const BACK = '/administrator/geo/observation';

  const UPLOAD = 'observation/upload';
  const IMPORT = 'observation/import';
  const EXPORT = 'observation/export';

  public function list($village = null, $keyword = null, $data, $paginate)
  {
    $where = array();
    $like = array();
    $orLike = array();

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 8
    if(empty($paginate)) {
      $paginate = 8;
    }

    // Masukan Value berdarakan Array Assoc
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    // Jika Tidak null maka like obscode = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['v_observations.obscode' => $keyword];
    }

    $data += [
      'list' => $this->getObservations($where, $like, $orLike, $paginate),
      'pager' => $this->pager,
      'import' => self::UPLOAD,
      'export' => self::EXPORT,
    ];
    echo view(self::VIEW.'list', $data);
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
    $realfilename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getName());
    $randfilename = $file->getRandomName();
    $folderName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $randfilename);

    $pathfile = WRITEPATH .'uploads/shapefile-import';

    if (! file_exists($pathfile .'/'. $folderName))
    {
      mkdir($pathfile .'/'. $folderName, 0777, true);
      $file->move($pathfile, $randfilename);
    }

    $extract = parent::extract_zip($pathfile, $randfilename, $folderName);

    if($extract)
    {
      unlink($pathfile .'/'. $randfilename);
      $newPath = $pathfile .'/'. $folderName .'/';
    }

    $Shapefile = M_geo::reader_shapefile($newPath . $realfilename .'.shp');
    
    try {

      while ($Geometry = $Shapefile->fetchRecord()) {
        // Skip the record if marked as "deleted"
        if ($Geometry->isDeleted()) {
          continue;
        }

        if(! empty($Geometry->getWKT())) {
          $type_shape = $Shapefile->getShapeType(Shapefile::FORMAT_STR);
          $chk_shape = true;
        }

        if(! empty($Geometry->getDataArray())) {
          $chk_dbf = true;
          $dbf = $Geometry->getDataArray();
        }

      }

    } catch (ShapefileException $e) {
      // Print detailed error information
      echo "Error Type: " . $e->getErrorType()
      . "\nMessage: " . $e->getMessage()
      . "\nDetails: " . $e->getDetails();
      
    }

    $fields = array();
    $fields_kv = array();

    // Fill 'null' jika nilai ''
    foreach($dbf as $k => $v) {
      $fields[] = $k;

      if($v == '') $fields_kv[] = $k .' = NULL';
      else $fields_kv[] = $k .' = '. $v;
    }

    $data = [
      'v' => [
        'chk_shape' => $chk_shape, 
        'chk_dbf' => $chk_dbf,
        'type_shape' => $type_shape,
        'str_fields' => implode(",\n", $fields_kv),
        'path' => $newPath . $realfilename .'.shp',
        'filename' => $realfilename .'.shp',
      ],
      'dbf' => $dbf,
      'fields' => $fields,
      'action' => self::ACTS.'import',
      'back' => self::BACK,
    ];

    echo view(self::VIEW.'compare', $data);

  }


/**
 * --------------------------------------------------------------------
 * Query
 * --------------------------------------------------------------------
 */

public function getObservations($where = null, $like = null, $orLike = null, $paginate = 5)
{
  $query = $this->select('obscode, sdname, vlname, farmname, ownername, cultivatorname')
  ->where($where)->like($like)->orLike($orLike)
  ->orderBy('obscode ASC');

  return $query->paginate($paginate, 'default');
}


/**
 * --------------------------------------------------------------------
 * Validation
 * --------------------------------------------------------------------
 */
  
  public function validationImport()
  {
    return [
      'zip_file' => [
        'label' => 'Import File',
        'rules' => 'uploaded[zip_file]|ext_in[zip_file,zip]|max_size[zip_file,1000]',
        'errors' => [
            'ext_in' => '{field} hanya berextensi file .zip',
            'max_size' => '{field} Maksimal {param}',
            'uploaded' => 'File zip Belum dipilih'
          ]
      ],
    ];
  }


/**
 * --------------------------------------------------------------------
 * Import - Export shapefile
 * --------------------------------------------------------------------
 */
  public function import($post, $chk_shape, $chk_dbf)
  {
    $Shapefile = M_geo::reader_shapefile($post['path']);

    try {

      while ($Geometry = $Shapefile->fetchRecord()) {
        // Skip the record if marked as "deleted"
        if ($Geometry->isDeleted()) {
          continue;
        }
        
        $shape = $Geometry->getWKT();
        $dbf = $Geometry->getDataArray();

      }

    } catch (ShapefileException $e) {
      // Print detailed error information
      echo "Error Type: " . $e->getErrorType()
      . "\nMessage: " . $e->getMessage()
      . "\nDetails: " . $e->getDetails();
      
    }

    // Fill 'null' jika nilai ''
    $v = array();
    foreach ($dbf as $k => $val) {
      if ($val == '') {
        $val = null;
      }
      $v[$k] = $val;
    }

    // procedure compare field - post
    $dbf = $v;

    $id = $dbf[$post['obscode']];
    $db = \Config\Database::connect();

    // select table field id berdasarkan field nama
    $data['ownerid'] = $db->table('mstr_owners')->select('ownerid')->where('ownername', $dbf[$post['ownername']])->get()->getRow()->ownerid ?? '';
    $data['cultivatorid'] = $db->table('mstr_owners')->select('ownerid')->where('ownername', $dbf[$post['cultivatorname']])->get()->getRow()->ownerid ?? '';
    $data['farmcode'] = $db->table('mstr_farmers')->select('farmcode')->where('farmname', $dbf[$post['farmname']])->get()->getRow()->farmcode ?? '';
    $data['respid'] = $db->table('mstr_respondens')->select('respid')->where('respname', $dbf[$post['respname']])->get()->getRow()->respid ?? '';

    $data['typeirigation'] = parent::import_str_replace($dbf[$post['typeirigation']]) ?? '';
    $data['opt'] = parent::import_str_replace($dbf[$post['opt']]) ?? '';
    $data['saprotan'] = parent::import_str_replace($dbf[$post['saprotan']]) ?? '';
    $data['harvstmax'] = parent::import_str_replace($dbf[$post['harvstmax']]) ?? '';
    $data['harvstmin'] = parent::import_str_replace($dbf[$post['harvstmin']]) ?? '';

    // procedure plantdates
    $index = (int) ceil($dbf[$post['indxnlant']]) / 100;

    $no = 1;
    for ($i = 0; $i < $index; $i++) {
      $data['plantdates'][] = [
        'growceason' => 
        ucfirst($dbf[strstr(array_keys($dbf, $dbf[$post['monthgrow']])[0], '_', true) .'_'. $no])
        .' - '. 
        ucfirst($dbf[strstr(array_keys($dbf, $dbf[$post['monthharvest']])[0], '_', true) .'_'. $no]), 

        'monthgrow' => strtoupper($dbf[strstr(array_keys($dbf, $dbf[$post['monthgrow']])[0], '_', true) .'_'. $no]),
        'monthharvest' => strtoupper($dbf[strstr(array_keys($dbf, $dbf[$post['monthharvest']])[0], '_', true) .'_'. $no]),
        'varieties' => $dbf[strstr(array_keys($dbf, $dbf[$post['varieties']])[0], '_', true) .'_'. $no],
        'irrigationavbl' => strtoupper($dbf[strstr(array_keys($dbf, $dbf[$post['irrigationavbl']])[0], '_', true) .'_'. $no]),
      ];
    
      $no++;
    }

    // Fill '1' jika nilai null = 'NO DATA'
    $v = array();
    foreach ($data as $k => $val) {
      if ($val == '') {
        $val = 1;
      }
      $v[$k] = $val;
    }

    if($chk_shape == 1) {
      $db->query("UPDATE lppbmis.observations_frmshape 
      SET shape = ST_GeomFromText('{$shape}') 
      WHERE obsshape = {$id}");
    }

    if($chk_dbf == 1) {

      $obs = $db->table('observations_frmobservations');

      $query2 = [
        'areantatus' => strtoupper($dbf[$post['areantatus']]),
        'broadnrea' => $dbf[$post['broadnrea']],
        'distancefromriver' => $dbf[$post['distancefromriver']],
        'distancefromIrgPre' => $dbf[$post['distancefromIrgPre']],
        'wtrtreatnnst' => $dbf[$post['wtrtreatnnst']],
        'intensitynlan' => $dbf[$post['intensitynlan']],
        'indxnlant' => $index * 100,
        'typeirigation' => $v['typeirigation'],
        'opt' => $v['opt'],
        'saprotan' => $v['saprotan'],
        'pattrnnlant' => $dbf[$post['pattrnnlant']],
        'wtr' => $dbf[$post['wtr']],
        'other' => $dbf[$post['other']],
        'harvstmax' => $v['harvstmax'],     
        'harvstmin' => $v['harvstmin'],
        'monthmax' => $dbf[$post['monthmax']],
        'monthmin' => $dbf[$post['monthmin']],
        'harvstsell' => $dbf[$post['harvstsell']],
        'vlcode' => $dbf[$post['vlcode']],
        'farmcode' => $v['farmcode'],
        'ownerid' => $v['ownerid'],
        'cultivatorid' => $v['cultivatorid'],
        'respid' => $v['respid'],
        'userid' => session('privilage')->userid,
        'timestamp' => date('y-m-d H:i:s')
      ];

      $obs->set($query2);
      $obs->where('obscode', $id);
      $obs->update();
    
      foreach ($v['plantdates'] as $k => $val) {

        $num = $k;
        $uniq = uniqid() .'#'. session('privilage')->userid .'#'.++$num;

        $this->query("CALL p_insertPlantdates(
          '{$k}',
          '{$uniq}',
          '{$val['growceason']}',
          '{$val['monthgrow']}',
          '{$val['monthharvest']}',
          '{$val['varieties']}',
          '{$val['irrigationavbl']}',
          '{$id}')
        ");
      }
    }

    $path = explode('/', $post['path']);
    $filename = array_pop($path);
    $folder = array_pop($path);
    $dir = (implode('\\', $path)) .'\\'. $folder;

    return delete_files($dir, true);
  }

  // --------------------------------------------------------------------

  public function export($obscode)
  {
    $filename = 'Petak-'.$obscode;
    $dir = WRITEPATH .'uploads/shapefile-export';

    if (! file_exists($dir)) {
      mkdir($dir, 0777, true);
    }

    delete_files($dir);

    $pathfile = $dir .'/'. $filename;

    $data = parent::get_observation($obscode);

    try {
      // Open Shapefile
      $Shapefile = M_geo::writer_shapefile($pathfile);
      
      // Set shape type
      $Shapefile->setShapeType(Shapefile::SHAPE_TYPE_POLYGON);

      // Create field structure
      $Shapefile->addNumericField('OBJECTID', 10, 0);
      $Shapefile->addFloatField('LUAS', 18, 11);
      $Shapefile->addCharField('LANDUSE', 50, 0);
      $Shapefile->addCharField('PEMILIK', 50, 0);
      $Shapefile->addCharField('PENGGARAP', 50, 0);
      $Shapefile->addCharField('POKTAN', 50, 0);
      $Shapefile->addCharField('IRIGASI', 50, 0);
      $Shapefile->addFloatField('IP', 18, 11);
      $Shapefile->addCharField('BT_1', 50, 0);
      $Shapefile->addCharField('BT_2', 50, 0);
      $Shapefile->addCharField('BT_3', 50, 0);
      $Shapefile->addCharField('VAR_1', 50, 0);
      $Shapefile->addCharField('VAR_2', 50, 0);
      $Shapefile->addCharField('VAR_3', 50, 0);
      $Shapefile->addCharField('NM_KEC', 50, 0);
      $Shapefile->addCharField('NM_DESA', 50, 0);
      $Shapefile->addCharField('STS_LHN', 50, 0);
      $Shapefile->addCharField('PP_OPT', 100, 0);
      $Shapefile->addCharField('PP_AIR', 100, 0);
      $Shapefile->addCharField('PP_SPRTN', 100, 0);
      $Shapefile->addCharField('PP_LAIN', 100, 0);
      $Shapefile->addCharField('PL_TNM', 50, 0);
      $Shapefile->addCharField('PJL_PNN', 50, 0);
      $Shapefile->addCharField('PNN_MAX', 50, 0);
      $Shapefile->addCharField('PNN_MIN', 50, 0);
      $Shapefile->addCharField('KD_DESA', 50, 0);
      $Shapefile->addCharField('KD_PTK', 50, 0);
      $Shapefile->addCharField('NM_RESPON', 50, 0);
      $Shapefile->addCharField('HP_RESPON', 50, 0);
      $Shapefile->addCharField('ID_POKTAN', 50, 0);
      $Shapefile->addCharField('NIK_PMK', 50, 0);
      $Shapefile->addCharField('NIK_PGR', 50, 0);
      $Shapefile->addCharField('JRK_SNG', 50, 0);
      $Shapefile->addCharField('JRK_IRG', 50, 0);
      $Shapefile->addCharField('LMBG_AIR', 50, 0);
      $Shapefile->addCharField('IT', 50, 0);
      $Shapefile->addCharField('BP_1', 50, 0);
      $Shapefile->addCharField('BP_2', 50, 0);
      $Shapefile->addCharField('BP_3', 50, 0);
      $Shapefile->addCharField('IRG_1', 50, 0);
      $Shapefile->addCharField('IRG_2', 50, 0);
      $Shapefile->addCharField('IRG_3', 50, 0);
      $Shapefile->addCharField('NM_SRY', 50, 0);
      $Shapefile->addCharField('TGL_SRY', 50, 0);
      $Shapefile->addCharField('BLN_MAX', 50, 0);
      $Shapefile->addCharField('BLN_MIN', 50, 0);
      $Shapefile->addFloatField('SHAPE_AREA', 18, 11);
      $Shapefile->addNumericField('LIST', 5, 0);

      // Write some records (let's pretend we have an array of coordinates)
      foreach ($data['features'] as $i => $k) {

        // Create a Point Geometry
        $Point = new Polygon();
        $Point->initFromWKT($k['wkt']);

        // Set its data
        $Point->setData('OBJECTID', $k['properties']['obscode']);
        $Point->setData('LUAS', $k['properties']['broadnrea']);
        $Point->setData('LANDUSE', $k['properties']['landuse']);
        $Point->setData('PEMILIK', $k['properties']['ownername']);
        $Point->setData('PENGGARAP', $k['properties']['cultivatorname']);
        $Point->setData('POKTAN', $k['properties']['farmname']);
        $Point->setData('IRIGASI', $k['properties']['typeirigation']);
        $Point->setData('IP', $k['properties']['indxnlant']);

        $no = 1;
        $index = (int) ceil($k['properties']['indxnlant']) / 100;

        for($i = 0; $i < $index; $i++) {

          $Point->setData('BT_'. $no, $k['properties']['monthgrow'][$i]);
          $Point->setData('BP_'. $no, $k['properties']['monthharvest'][$i]);
          $Point->setData('VAR_'. $no, $k['properties']['varieties'][$i]);
          $Point->setData('IRG_'. $no, $k['properties']['irrigationavbl'][$i]);

          $no++;
        }
        
        $Point->setData('NM_KEC', $k['properties']['sdname']);
        $Point->setData('NM_DESA', $k['properties']['vlname']);
        $Point->setData('STS_LHN', $k['properties']['areantatus']);
        $Point->setData('PP_OPT', $k['properties']['opt']);
        $Point->setData('PP_AIR', $k['properties']['wtr']);
        $Point->setData('PP_SPRTN', $k['properties']['saprotan']);
        $Point->setData('PP_LAIN', $k['properties']['other']);
        $Point->setData('PL_TNM', $k['properties']['pattrnnlant']);
        $Point->setData('PJL_PNN', $k['properties']['harvstsell']);
        $Point->setData('PNN_MAX', $k['properties']['harvstmax'] .' kwintal/ha');
        $Point->setData('PNN_MIN', $k['properties']['harvstmin'] .' kwintal/ha');
        $Point->setData('KD_DESA', $k['properties']['vlcode']);
        $Point->setData('KD_PTK', $k['properties']['obscode']);
        $Point->setData('NM_RESPON', $k['properties']['respname']);
        $Point->setData('HP_RESPON', '');
        $Point->setData('ID_POKTAN', $k['properties']['farmcode']);
        $Point->setData('NIK_PMK', $k['properties']['ownernik']);
        $Point->setData('NIK_PGR', $k['properties']['cultivatornik']);
        $Point->setData('JRK_SNG', $k['properties']['distancefromriver']);
        $Point->setData('JRK_IRG', $k['properties']['distancefromIrgPre']);
        $Point->setData('LMBG_AIR', $k['properties']['wtrtreatnnst']);
        $Point->setData('IT', $k['properties']['intensitynlan']);
        $Point->setData('NM_SRY', '');
        $Point->setData('TGL_SRY', '');
        $Point->setData('BLN_MAX', $k['properties']['monthmax']);
        $Point->setData('BLN_MIN', $k['properties']['monthmin']);
        $Point->setData('SHAPE_AREA', $k['area']);
        $Point->setData('LIST', 1);

        // Write the record to the Shapefile
        $Shapefile->writeRecord($Point);
      }
      
      // Finalize and close files to use them
      $Shapefile = null;
  
    } catch (ShapefileException $e) {
        // Print detailed error information
        echo "Error Type: " . $e->getErrorType()
            . "\nMessage: " . $e->getMessage()
            . "\nDetails: " . $e->getDetails();
    }

    $file = parent::compress_zip($dir, $filename);

    return $file;
  }
  
}