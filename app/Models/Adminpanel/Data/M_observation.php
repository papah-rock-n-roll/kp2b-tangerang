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
  const READ   = 'observation/read/';
  const UPDATE = 'observation/update/';
  const DELETE = 'observation/delete/';

  const PLANTDATES = 'adminpanel/data/plantdates/';


  protected $table = 'v_observations';
  protected $primaryKey = 'obscode';

  public $optbase = ['BURUNG','SUNDEP','WERENG','WALANG'];
  public $saprotanbase = ['SEMPROTAN','TRAKTOR'];


  public function list($farm = null, $keyword = null, $data, $paginate)
  {
    $where = array();
    $like = array();
    $orLike = array();

    if(empty($paginate)) {
      $paginate = 5;
    }

    $data['farm'] = $farm;
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

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
      'plantdates' => self::PLANTDATES,
    ];
    echo view(self::VIEW.'list', $data);
  }

  public function read($id)
  {
    $data = [
      'v' => $this->getObservation($id),
      'back' => self::BACK,
    ];

    echo view(self::VIEW.'read', $data);
  }

  public function create_new($data)
  {
    $optbase = array_fill_keys($this->optbase, '');
    $saprotanbase = array_fill_keys($this->saprotanbase, '');

    $data += [
      'action' => self::ACTS.'create',
      'opt' => $optbase,
      'saprotan' => $saprotanbase,
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
    
    $opt = explode(',', $observation['opt']);
    $saprotan = explode(',', $observation['saprotan']);

    $optbase = array_fill_keys($this->optbase, '');
    $saprotanbase = array_fill_keys($this->saprotanbase, '');
    
    $selected = array_fill_keys($opt, 'selected');
    $newObs['opt'] = array_replace($optbase, $selected);

    $selected = array_fill_keys($saprotan, 'selected');
    $newObs['saprotan'] = array_replace($saprotanbase, $selected);

    $observation = array_replace($observation, $newObs);

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
    $query = $this->select('obscode,	sdcode,	sdname,	
    vlcode,	vlname,	farmcode,	farmname,	ownerid,	ownernik,	ownername,	
    cultivatorid,	cultivatornik,	cultivatorname')
    ->where($where)->like($like)->orLike($orLike)
    ->orderBy('obscode ASC');

    return $query->paginate($paginate, 'observations');
  }

  public function getObservation($id)
  {
    $query = $this->select('obscode,	areantatus,	broadnrea,	
    typeirigation,	distancefromriver,	distancefromIrgPre,	wtrtreatnnst,	
    intensitynlan,	indxnlant,	pattrnnlant,	opt,	wtr,	saprotan,	other,	
    harvstmax,	monthmax,	harvstmin,	monthmin,	harvstsell,	sdcode,	sdname,	
    vlcode,	vlname,	farmcode,	farmname,	ownerid,	ownernik,	ownername,	
    cultivatorid,	cultivatornik,	cultivatorname,	respname,	username')
    ->where('obscode', $id)->first();

    return $query;
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