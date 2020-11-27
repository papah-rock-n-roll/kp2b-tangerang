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
  const VIEW = 'adminpanel/data/responden/';

  const ACTS = 'administrator/data/responden/';
  const BACK = '/administrator/data/responden';

  const CREATE = 'responden/create';
  const UPDATE = 'responden/update/';
  const DELETE = 'responden/delete/';


  protected $table = 'mstr_respondens';
  protected $primaryKey = 'respid';

  protected $allowedFields = ['respid','respname','mobileno'];


  public function list($responden = null, $keyword = null, $data, $paginate)
  {
    $responden = array();
    $like = array();
    $orLike = array();

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 5
    if(empty($paginate)) {
      $paginate = 5;
    }

    // Masukan Value berdarakan Array Assoc
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    // Jika Tidak null maka like respname - or like mobileno = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['mstr_respondens.respname' => $keyword];
      $orLike = ['mstr_respondens.mobileno' => $keyword];
    }

    $data += [
      'list' => $this->getRespondenlist($responden, $like, $orLike, $paginate),
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

  public function update_new($id, $data, $get)
  {
    $data += [
      'action' => self::ACTS.'update/'.$id.'?'.$get,
      'v' => $this->getResponden($id),
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

  public function getRespondenlist($where = null, $like = null, $orLike = null, $paginate = 5)
  {
    $query = $this->select('respid, respname, mobileno')
    ->where($where)->like($like)->orLike($orLike)
    ->orderBy('respid ASC');

    return $query->paginate($paginate, 'default');
  }

  public function getRespondens()
  {
    return $this->findAll();
  }

  public function getResponden($id, $mobileno = null)
  {
    return $this->where('respid', $id)->orWhere('mobileno', $mobileno)->first();
  }

  // Api responden - Remote Select2
  public function getRemoteRespondens($selected, $page)
  {
    if(empty($selected)) $selected = '';
    if(empty($page)) $page = 0;

    $offset = $page * 10;
    $like = ['mstr_respondens.respname' => $selected];

    $countAll = $this->like($like, 'match', 'after')->countAllResults();
    $data = $this->like($like, 'match', 'after')->findAll(10, $offset);

    $result = array(
      'total_count' => $countAll,
      'results' => $data
    );

    $result = json_encode($result, JSON_NUMERIC_CHECK);
    $result = json_decode($result, true);

    return $result;
  }

  public function validationRules($id = null)
  {
    return [
      'respname' => [
        'label' => 'Responden Name',
        'rules' => 'required|max_length[50]|is_unique[mstr_respondens.respname,respid,'.$id.']',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'mobileno' => [
        'label' => 'Phone',
        'rules' => 'required|is_natural|max_length[15]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
    
    ];

  }


}