<?php namespace App\Models\Adminpanel\Geo;

/**
 * --------------------------------------------------------------------
 *
 * Geo Observation
 *
 * --------------------------------------------------------------------
 */
use Shapefile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\Geometry\Polygon;

use ZipArchive;


class M_obsgeo extends M_geo
{
  const VIEW = 'adminpanel/geo/observation/';

  const ACTS = 'administrator/geo/observation/';
  const BACK = '/administrator/geo/observation';

  const UPLOAD = 'observation/upload';
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
    $file->move($pathfile, $randfilename);

    $extract = $this->extract_zip($pathfile, $randfilename, $folderName);

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

        // Print Geometry as an Array
        # print_r($Geometry->getArray());

        // Print Geometry as WKT
        # print_r($Geometry->getWKT());

        // Print Geometry as GeoJSON
        # print_r($Geometry->getGeoJSON());

        // Print DBF data
         print_r($Geometry->getDataArray());
      }

    } catch (ShapefileException $e) {
      // Print detailed error information
      echo "Error Type: " . $e->getErrorType()
      . "\nMessage: " . $e->getMessage()
      . "\nDetails: " . $e->getDetails();
    }

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
 * Import shapefile
 * --------------------------------------------------------------------
 */
  public function import()
  {

  }

  public function export($obscode)
  {
    $filename = 'petak-'.$obscode;
    $pathfile = WRITEPATH .'uploads/shapefile-export/'. $filename;

    $data = parent::get_observasion($obscode);

    dd($data);

    try {
      // Open Shapefile
      $Shapefile = M_geo::writer_shapefile($pathfile);
      
      // Set shape type
      $Shapefile->setShapeType(Shapefile::SHAPE_TYPE_POLYGON);
      
      // Create field structure
      $Shapefile->addNumericField('ID', 10);
      $Shapefile->addCharField('DESC', 25);
      
      // Write some records (let's pretend we have an array of coordinates)
      foreach ($data as $i => $coords) {
          // Create a Point Geometry
          $Point = new Polygon($coords['x'], $coords['m']);
          // Set its data
          $Point->setData('ID', $i);
          $Point->setData('DESC', "Point number $i");
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
  }


/**
 * --------------------------------------------------------------------
 * Function
 * --------------------------------------------------------------------
 */

  function extract_zip($pathfile, $filename, $folderName)
  {
    $zip = new ZipArchive;
    if ($zip->open($pathfile .'/'. $filename) === TRUE)
    {
      $zip->extractTo($pathfile .'/'. $folderName);
      $zip->close();

      return true;
    } 
    else 
    {
      return false;
    }
  }
  

}