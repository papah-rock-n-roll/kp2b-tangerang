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
  protected $table = 'mstr_owners';
  protected $primaryKey = 'ownerid';

  protected $allowedFields = ['ownernik','ownername','owneraddress'];


  public function getOwners()
  {
    return $this->findAll();
  }

  public function getOwner($id, $nik = null)
  {
    return $this->where('ownerid', $id)->orWhere('ownernik', $nik)->first();
  }


}