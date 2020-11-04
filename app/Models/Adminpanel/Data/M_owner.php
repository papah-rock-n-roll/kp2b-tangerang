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

  public function getRemoteOwners($selected, $page)
  {
    $offset = $page * 10;

    $like = ['mstr_owners.ownernik' => $selected];
    $orlike = ['mstr_owners.ownername' => $selected];

    $data = $this->like($like, 'match')->orlike($orlike, 'match')->findAll(10, $offset);
    
    $result = array(
      'results' => $data,
      'page' => $page,
    );

    return $result;
  }


}