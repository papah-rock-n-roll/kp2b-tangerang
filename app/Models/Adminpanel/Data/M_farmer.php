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
  const VIEW = 'adminpanel/data/farmer/';

  const ACTS = 'administrator/data/farmer/';
  const BACK = '/administrator/data/farmer';

  const CREATE = 'farmer/create';
  const UPDATE = 'farmer/update/';
  const DELETE = 'farmer/delete/';

  protected $table = 'mstr_farmers';
  protected $primaryKey = 'farmcode';

  protected $allowedFields = ['farmcode','farmname','farmmobile','farmhead'];


  public function list($farmer = null, $keyword = null, $data, $paginate)
  {
    $farmer = array();
    $like = array();
    $orLike = array();

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 5
    if(empty($paginate)) {
      $paginate = 5;
    }

    // Masukan Value berdarakan Array Assoc
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    // Jika Tidak null maka like farmname - or like farmhead = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['mstr_farmers.farmname' => $keyword];
      $orLike = ['mstr_farmers.farmhead' => $keyword];
    }

    $data += [
      'list' => $this->getFarmlist($farmer, $like, $orLike, $paginate),
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
      'v' => $this->getFarmer($id),
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

  public function getFarmlist($where = null, $like = null, $orLike = null, $paginate = 5)
  {
    $query = $this->select('farmcode, farmname, farmmobile, farmhead')
    ->where($where)->like($like)->orLike($orLike)
    ->orderBy('farmcode ASC');

    return $query->paginate($paginate, 'farmers');
  }

  public function getFarmers()
  {
    return $this->findAll();
  }

  public function getFarmer($id)
  {
    return $this->where('farmcode', $id)->first();
  }

  public function validationRules($id = null)
  {
    return [
      'farmname' => [
        'label' => 'Farmer Name',
        'rules' => 'required|max_length[50]|is_unique[mstr_farmers.farmname,farmcode,'.$id.']',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'farmmobile' => [
        'label' => 'Phone',
        'rules' => 'required|is_natural|max_length[15]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'farmhead' => [
        'label' => 'Chief',
        'rules' => 'required|max_length[25]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
    
    ];

  }


}