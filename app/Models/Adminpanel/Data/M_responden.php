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
  protected $primaryKey = 'respId';

  protected $allowedFields = ['respId','resName','mobileNo'];


  public function getRespondens()
  {
    return $this->findAll();
  }

  public function getResponden($id, $mobileno = null)
  {
    return $this->where('ownerid', $id)->orWhere('mobileNo', $mobileno)->first();
  }

}