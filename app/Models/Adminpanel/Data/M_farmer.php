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
  protected $table = 'mstr_farmers';
  protected $primaryKey = 'farmcode';

  protected $allowedFields = ['farmname','farmmobile','farmhead'];

  public function getFarmers()
  {
    return $this->findAll();
  }

  public function getFarmer($id)
  {
    return $this->where('farmcode', $id)->first();
  }


}