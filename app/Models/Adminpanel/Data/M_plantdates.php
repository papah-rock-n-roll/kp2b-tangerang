<?php namespace App\Models\Adminpanel\Data;

/**
 * --------------------------------------------------------------------
 *
 * Data Observation - Plantdates
 *
 * --------------------------------------------------------------------
 */
  
class M_plantdates extends M_observation
{
  const VIEW = 'adminpanel/data/plantdates/';

  const ACTS = 'administrator/data/plantdates/';
  const BACK = '/administrator/data/plantdates';

  const CREATE = 'plantdates/create';
  const READ   = 'plantdates/read/';
  const UPDATE = 'plantdates/update/';
  const DELETE = 'plantdates/delete/';

  protected $table = 'observations_plantdates';
  protected $primaryKey = 'plantid';

  protected $allowedFields = ['plantid,	growceason,	monthgrow,	monthharvest,	varieties,	irrigationavbl,	obscode'];


  public function update_new($id, $data)
  {
    $plantdates = $this->getPlantdates($id);

    $data += [
      'action' => self::ACTS.'update/'.$id,
      'v' => $plantdates,
      'back' => self::BACK,
    ];
    dd($data);
    echo view(self::VIEW.'update', $data);
  }

  public function update_post($id, $data)
  {
    return $this->update($id, $data);
  }

  public function getPlantdates($id)
  {
    $query = $this->select('plantid,	growceason,	monthgrow,	monthharvest,	
    varieties,	irrigationavbl,	obscode');

    dd($query->where('obscode', $id)->get());
    return $query->where('obscode', $id)->get();
  }



}