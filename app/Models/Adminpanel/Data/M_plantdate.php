<?php namespace App\Models\Adminpanel\Data;

/**
 * --------------------------------------------------------------------
 *
 * Data Observation - Plantdates
 *
 * --------------------------------------------------------------------
 */
  
class M_plantdate extends M_data
{
  const VIEW = 'adminpanel/data/plantdate/';

  const ACTS = 'administrator/data/observation/plantdate/';
  const BACK = '/administrator/data/observation';

  const CREATE = 'plantdate/create/';

  protected $table = 'observations_plantdates';
  protected $primaryKey = 'plantid';

  public $plantdateFields = ['growceason','monthgrow','monthharvest','varieties','irrigationavbl'];

  public function plantdates_new($id, $data)
  {
    // round up nilai indxnlant
    $indxnlant = $this->getObsIndexPlant($id);
    $index = (int) ceil($indxnlant);
    $plant = $this->getPlantdates($id);

    // return setflashdata catch warning
    if($index > 5) {
      return true;
    }
    else
    {
      if(!empty($plant)) {

        // fetch data kosong ke variable $temp
        $temp = array_fill_keys(array_keys($plant[0]), '');

        // push data kosong ke variable $plan sesuai nilai Index Plant
        for($i = count($plant); $i < $index; ++$i) {
          array_push($plant, $temp);
        }

      }
      else
      {
        // Ganti key Assoc berdasarkan Base fields dengan value ''
        $base = array_fill_keys($this->plantdateFields, '');
        
        // fetch data kosong ke variable $temp
        $temp = array_fill_keys(array_keys($base), '');

        // push data kosong ke variable $plan sesuai nilai Index Plant
        for($i = count($plant); $i < $index; ++$i) {
          array_push($plant, $temp);
        }
      }

    }

    $data += [
      'action' => self::ACTS.'/'.$id,
      'indxnlant' => $indxnlant,
      'oldlist' => $this->getPlantdates($id),
      'newlist' => $plant,
      'back' => self::BACK,
    ];

    echo view(self::VIEW.'create', $data);
  }

  public function plantdates_post($id, $data)
  {
    $this->query("DELETE FROM observations_plantdates WHERE obscode = {$id}");
    
    foreach ($data as $v) {

      $uniq = uniqid();

      $query = $this->query("CALL p_insertPlantdates(
        '{$uniq}',
        '{$v['growceason']}',
        '{$v['monthgrow']}',
        '{$v['monthharvest']}',
        '{$v['varieties']}',
        '{$v['irrigationavbl']}',
        '{$id}')
      ");

    }

    return $query;
  }

  public function getObsIndexPlant($id)
  {
    $db = \Config\Database::connect();

    $query = $db->query("SELECT indxnlant FROM observations_frmobservations WHERE obscode = {$id}");

    return $query->getRow()->indxnlant;
  }

  public function getPlantdates($id)
  {
    $query = $this->select('plantid,	growceason,	monthgrow,	monthharvest,	
    varieties,	irrigationavbl,	obscode');

    return $query->where('obscode', $id)->findAll();
  }


}