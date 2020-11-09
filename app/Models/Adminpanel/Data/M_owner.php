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
  const VIEW = 'adminpanel/data/owner/';

  const ACTS = 'administrator/data/owner/';
  const BACK = '/administrator/data/owner';

  const CREATE = 'owner/create';
  const UPDATE = 'owner/update/';
  const DELETE = 'owner/delete/';

  protected $table = 'mstr_owners';
  protected $primaryKey = 'ownerid';

  protected $allowedFields = ['ownerid','ownernik','ownername','owneraddress'];


  public function list($owner = null, $keyword = null, $data, $paginate)
  {
    $owner = array();
    $like = array();
    $orLike = array();

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 5
    if(empty($paginate)) {
      $paginate = 5;
    }

    // Masukan Value berdarakan Array Assoc
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    // Jika Tidak null maka like ownernik - or like ownername = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['mstr_owners.ownernik' => $keyword];
      $orLike = ['mstr_owners.ownername' => $keyword];
    }

    $data += [
      'list' => $this->getOwnerlist($owner, $like, $orLike, $paginate),
      'pager' => $this->pager,
      'create' => self::CREATE,
      'update' => self::UPDATE,
      'delete' => self::DELETE,
    ];

    echo view(self::VIEW.'list', $data);
  }

  public function create_new($data)
  {
    $data += [
      'action' => self::ACTS.'create',
      'back' => self::BACK,
    ];

    echo view(self::VIEW.'create', $data);
  }

  public function create_post($data)
  {
    return $this->insert($data);
  }

  public function update_new($id, $data)
  {
    $data += [
      'action' => self::ACTS.'update/'.$id,
      'v' => $this->getOwner($id),
      'back' => self::BACK,
    ];

    echo view(self::VIEW.'update', $data);
  }

  public function update_post($id, $data)
  {
    return $this->update($id, $data);
  }

  public function delete_post($id)
  {
    return $this->delete($id);
  }


  public function getOwnerlist($where = null, $like = null, $orLike = null, $paginate = 5)
  {
    $query = $this->select('ownerid, ownernik, ownername, owneraddress')
    ->where($where)->like($like)->orLike($orLike)
    ->orderBy('ownerid ASC');

    return $query->paginate($paginate, 'owners');
  }

  public function getOwners()
  {
    return $this->findAll();
  }

  public function getOwner($id, $nik = null)
  {
    return $this->where('ownerid', $id)->orWhere('ownernik', $nik)->first();
  }


  // Api owners - Remote Select2
  public function getRemoteOwners($selected, $page)
  {
    if(empty($selected)) $selected = '';
    if(empty($page)) $page = 1;

    $offset = $page * 10;

    $like = ['mstr_owners.ownernik' => $selected];
    $orlike = ['mstr_owners.ownername' => $selected];

    $data = $this->like($like, 'match')->orlike($orlike, 'match')->findAll(10, $offset);
    
    $result = array(
      'results' => $data,
      'page' => $page,
    );

    $result = json_encode($result, JSON_NUMERIC_CHECK);
    $result = json_decode($result, true);

    return $result;
  }

  public function validationRules($id = null)
  {
    return [
      'ownernik' => [
        'label' => 'NIK',
        'rules' => 'required|max_length[30]|is_unique[mstr_owners.ownernik,ownerid,'.$id.']',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'ownername' => [
        'label' => 'Nama',
        'rules' => 'required|max_length[30]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'owneraddress' => [
        'label' => 'Address',
        'rules' => 'required|max_length[255]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
    
    ];

  }

}