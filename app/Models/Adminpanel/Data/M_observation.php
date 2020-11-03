<?php namespace App\Models\Adminpanel\Data;

/**
 * --------------------------------------------------------------------
 *
 * Data Observation
 *
 * --------------------------------------------------------------------
 */
  
class M_observation extends M_data
{
  const VIEW = 'adminpanel/data/observation/';

  const ACTS = 'administrator/data/observation/';
  const BACK = '/administrator/data/observation';

  const CREATE = 'observation/create';
  const READ   = 'observation/read';
  const UPDATE = 'observation/update/';
  const DELETE = 'observation/delete/';


  protected $table = 'observations_frmobservations';
  protected $primaryKey = 'obscode';

  protected $allowedFields = ['obsshape','areantatus','broadnrea','broadnrea','typeirigation',
  'distancefromriver','distancefromIrgPre','wtrtreatnnst','intensitynlan','indxnlant','pattrnnlant',
  'opt','wtr','saprotan','other','harvstmax','monthmax','harvstmin','monthmin','harvstsell',
  'timestamp','vl_code','farmcode','pemilik','penggrap','respId'];


  public function list($farm = null, $keyword = null, $data, $paginate = 5)
  {
    $where = array();
    $like = array();
    $orLike = array();

    $data['farm'] = $farm;
    $data['keyword'] = $keyword;
    $data['paginate'] = ($paginate == 0 ? 5 : $paginate);

    if(!empty($farm)) {
      $where = ['v_observations.farmcode' => $farm];
    }

    if(!empty($keyword)) {
      $like = [
        'v_observations.ownername' => $keyword,
        'v_observations.cultivatorname' => $keyword
      ];
      $orLike = [
        'v_observations.ownernik' => $keyword,
        'v_observations.cultivatornik' => $keyword
      ];
    }

    $data += [
      'list' => $this->getObservations($where, $like, $orLike, $paginate),
      'pager' => $this->pager,
      'create' => self::CREATE,
      'read' => self::READ,
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
    $observation = $this->getObservation($id);

    $data += [
      'action' => self::ACTS.'update/'.$id,
      'v' => $observation,
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

  public function getObservations($where = null, $like = null, $orLike = null, $paginate = 5)
  {
    $query = $this->from('v_observations')->where($where)->like($like)->orLike($orLike);
    dd($this);
    return $query->paginate($paginate, 'observations');
  }

  public function getObservation($id)
  {
    return $this->where('obscode', $id)->first();
  }

  
  public function validationRules($id = null)
  {
    return [
      'vl_code' => [
      'label' => 'Kode Desa',
      'rules' => 'required|max_length[10]|is_unique[observations_frmobservations.obscode,obscode,'.$id.']',
      'errors' => [
        'required' => 'Diperlukan {field}',
        'is_unique' => 'Data {field} {value} Sudah Ada',
        'max_length' => '{field} Maximum {param} Character',
        ]
      ],
      'farmcode' => [
        'label' => 'Kode Desa',
        'rules' => 'required|max_length[10]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'pemilik' => [
        'label' => 'ID Pemilik',
        'rules' => 'required|max_length[10]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'penggarap' => [
        'label' => 'ID Penggarap',
        'rules' => 'required|max_length[10]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
    ];

  }

}