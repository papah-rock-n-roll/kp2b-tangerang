<?php namespace App\Models\Adminpanel\Data;

/**
 * --------------------------------------------------------------------
 *
 * Data Owner
 *
 * --------------------------------------------------------------------
 */
  
class M_responden extends M_data
{ 
  protected $table = 'mstr_respondens';
  protected $primaryKey = 'respid';

  protected $allowedFields = ['respid','resname','mobileno'];


  public function getRespondens()
  {
    return $this->findAll();
  }

  public function getResponden($id, $mobileno = null)
  {
    return $this->where('respid', $id)->orWhere('mobileno', $mobileno)->first();
  }

}