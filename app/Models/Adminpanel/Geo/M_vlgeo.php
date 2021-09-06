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
  const VIEW = 'adminpanel/geo/village/';

  const ACTS = 'administrator/geo/village/';
  const BACK = '/administrator/geo/village';

  const UPLOAD = 'village/upload';
  const IMPORT = 'village/import';
  const EXPORT = 'village/export';

  public function list($param = null, $keyword = null, $data, $paginate)
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

    // Jika Tidak null maka like vlname = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['v_observations.vlname' => $keyword];
      $orLike = ['v_observations.vlcode' => $keyword];
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
  $query = $this->select('vlcode, sdname, vlname')->distinct()
  ->where($where)->like($like)->orLike($orLike)
  ->orderBy('vlcode ASC');

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

  public function export($vlcode)
  {
    $filename = 'Kode Desa-'.$vlcode;
    $dir = WRITEPATH .'uploads/shapefile-export';

    if (! file_exists($dir)) {
      mkdir($dir, 0777, true);
    }

    delete_files($dir);

    $pathfile = $dir .'/'. $filename;

    $data = parent::get_observation_village($vlcode);

    try {
      // Open Shapefile
      $Shapefile = M_geo::writer_shapefile($pathfile);

      // Set shape type
      $Shapefile->setShapeType(Shapefile::SHAPE_TYPE_POLYGON);
      $Shapefile->setPRJ('GEOGCS["GCS_WGS_1984",DATUM["D_WGS_1984",SPHEROID["WGS_1984",6378137.0,298.257223563]],PRIMEM["Greenwich",0.0],UNIT["Degree",0.0174532925199433]]');
      $Shapefile->setCharset('UTF-8');

      // Create field structure
      $Shapefile->addNumericField('KD_PETAK', 15, 0);
      $Shapefile->addFloatField('LUAS', 18, 11);
      $Shapefile->addCharField('STS_LHN', 30, 0);
      $Shapefile->addCharField('PEMILIK', 50, 0);
      $Shapefile->addCharField('PENGGARAP', 50, 0);
      $Shapefile->addCharField('NIK_PMK', 50, 0);
      $Shapefile->addCharField('NIK_PGR', 50, 0);
      $Shapefile->addCharField('IRIGASI', 50, 0);
      $Shapefile->addFloatField('JRK_SNG', 7, 2);
      $Shapefile->addFloatField('JRK_IRG', 7, 2);
      $Shapefile->addFloatField('IT', 3, 1);
      $Shapefile->addCharField('LMBG_AIR', 50, 0);
      $Shapefile->addCharField('POKTAN', 50, 0);
      $Shapefile->addCharField('ID_POKTAN', 50, 0);
      $Shapefile->addNumericField('IP', 5, 0);
      $Shapefile->addCharField('NM_KEC', 50, 0);
      $Shapefile->addCharField('NM_DESA', 50, 0);
      $Shapefile->addCharField('KD_DESA', 50, 0);
      $Shapefile->addCharField('PP_OPT', 100, 0);
      $Shapefile->addCharField('PP_AIR', 200, 0);
      $Shapefile->addCharField('PP_SPRTN', 100, 0);
      $Shapefile->addCharField('PP_LAIN', 200, 0);
      $Shapefile->addCharField('PL_TNM', 50, 0);
      $Shapefile->addCharField('PJL_PNN', 50, 0);
      $Shapefile->addCharField('PNN_MAX', 50, 0);
      $Shapefile->addCharField('PNN_MIN', 50, 0);
      $Shapefile->addCharField('BLN_MAX', 50, 0);
      $Shapefile->addCharField('BLN_MIN', 50, 0);
      $Shapefile->addCharField('LANDUSE', 50, 0);
      $Shapefile->addCharField('DSC_LAND', 50, 0);
      $Shapefile->addCharField('BT_1', 50, 0);
      $Shapefile->addCharField('BT_2', 50, 0);
      $Shapefile->addCharField('BT_3', 50, 0);
      $Shapefile->addCharField('VAR_1', 50, 0);
      $Shapefile->addCharField('VAR_2', 50, 0);
      $Shapefile->addCharField('VAR_3', 50, 0);
      $Shapefile->addCharField('BP_1', 50, 0);
      $Shapefile->addCharField('BP_2', 50, 0);
      $Shapefile->addCharField('BP_3', 50, 0);
      $Shapefile->addCharField('IRG_1', 50, 0);
      $Shapefile->addCharField('IRG_2', 50, 0);
      $Shapefile->addCharField('IRG_3', 50, 0);
      $Shapefile->addCharField('NM_RESPON', 50, 0);
      $Shapefile->addCharField('HP_RESPON', 50, 0);
      $Shapefile->addCharField('NM_SRY', 50, 0);
      $Shapefile->addDateField('TGL_SRY');

      // Write some records (let's pretend we have an array of coordinates)
      foreach ($data['features'] as $i => $k) {

        // Create a Point Geometry
        $Polygon = new Polygon();
        $featurex = json_encode($k['geometry'] ,JSON_NUMERIC_CHECK);
        $Polygon->initFromGeoJSON($featurex);

        // Set its data
        $Polygon->setData('KD_PETAK', $k['properties']['obscode']);
        $Polygon->setData('LUAS', $k['properties']['broadnrea']);
        $Polygon->setData('STS_LHN', $k['properties']['areantatus']);
        $Polygon->setData('PEMILIK', $k['properties']['ownername']);
        $Polygon->setData('PENGGARAP', $k['properties']['cultivatorname']);
        $Polygon->setData('NIK_PMK', $k['properties']['ownernik']);
        $Polygon->setData('NIK_PGR', $k['properties']['cultivatornik']);
        $Polygon->setData('IRIGASI', $k['properties']['typeirigation']);
        $Polygon->setData('JRK_SNG', $k['properties']['distancefromriver']);
        $Polygon->setData('JRK_IRG', $k['properties']['distancefromIrgPre']);
        $Polygon->setData('IT', $k['properties']['intensitynlan']);
        $Polygon->setData('LMBG_AIR', $k['properties']['wtrtreatnnst']);
        $Polygon->setData('POKTAN', $k['properties']['farmname']);
        $Polygon->setData('ID_POKTAN', $k['properties']['farmcode']);
        $Polygon->setData('IP', $k['properties']['indxnlant']);
        $Polygon->setData('NM_KEC', $k['properties']['sdname']);
        $Polygon->setData('NM_DESA', $k['properties']['vlname']);
        $Polygon->setData('KD_DESA', $k['properties']['vlcode']);
        $Polygon->setData('PP_OPT', $k['properties']['opt']);
        $Polygon->setData('PP_AIR', $k['properties']['wtr']);
        $Polygon->setData('PP_SPRTN', $k['properties']['saprotan']);
        $Polygon->setData('PP_LAIN', $k['properties']['other']);
        $Polygon->setData('PL_TNM', $k['properties']['pattrnnlant']);
        $Polygon->setData('PJL_PNN', $k['properties']['harvstsell']);
        $Polygon->setData('PNN_MAX', $k['properties']['harvstmax']);
        $Polygon->setData('PNN_MIN', $k['properties']['harvstmin']);
        $Polygon->setData('BLN_MAX', $k['properties']['monthmax']);
        $Polygon->setData('BLN_MIN', $k['properties']['monthmin']);
        $Polygon->setData('LANDUSE', $k['properties']['landuse']);
        $Polygon->setData('DSC_LAND', '');

        $index = count($k['properties']['monthgrow']);
        for($x = 1; $x <= 3; $x++) {

          if ($x < $index) {
            $BT_X = $k['properties']['monthgrow'][$x];
            $BP_X = $k['properties']['monthharvest'][$x];
            $VAR_X = $k['properties']['varieties'][$x];
            $IRG_X = $k['properties']['irrigationavbl'][$x];
          }else{
            $BT_X = "";
            $BP_X = "";
            $VAR_X = "";
            $IRG_X = "";
          }

          $Polygon->setData('BT_'. $x, $BT_X);
          $Polygon->setData('BP_'. $x, $BP_X);
          $Polygon->setData('VAR_'. $x, $VAR_X);
          $Polygon->setData('IRG_'. $x, $IRG_X);
        }

        $Polygon->setData('NM_RESPON', $k['properties']['respname']);
        $Polygon->setData('HP_RESPON', '');
        $Polygon->setData('NM_SRY', $k['properties']['username']);
        $Polygon->setData('TGL_SRY', $k['properties']['timestamp']);

        // Write the record to the Shapefile
        $Shapefile->writeRecord($Polygon);
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
