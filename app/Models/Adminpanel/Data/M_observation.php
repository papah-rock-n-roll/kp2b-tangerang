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

  const PLANTDATE = 'observation/plantdate/';


  protected $table = 'v_observations';
  protected $primaryKey = 'obscode';


  public $irigationbase = ['Sungai','Primer','Sekunder','Tersier'];
  public $optbase = ['Burung','Walang Sangit','Wereng','Sundep'];
  public $saprotanbase = ['Semprotan','Traktor'];


  public function list($farm = null, $keyword = null, $data, $paginate)
  {
    $where = array();
    $like = array();
    $orLike = array();

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 5
    if(empty($paginate)) {
      $paginate = 5;
    }

    // Masukan Value berdarakan Array Assoc
    $data['farm'] = $farm;
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    // Jika Tidak null maka where farmcode = $_['GET'] farm
    if(!empty($farm)) {
      $where = ['v_observations.farmcode' => $farm];
    }

    // Jika Tidak null maka like ownernik - or like ownername = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['v_observations.ownername' => $keyword];
      $orLike = ['v_observations.ownernik' => $keyword];
    }

    $data += [
      'list' => $this->getObservations($where, $like, $orLike, $paginate),
      'pager' => $this->pager,
      'create' => self::CREATE,
      'read' => self::READ,
      'update' => self::UPDATE,
      'delete' => self::DELETE,
      'plantdate' => self::PLANTDATE,
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
    // Ganti key Assoc berdasarkan Base dengan value ''
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
    //return $this->insert($data);
  }

  public function update_new($id, $data)
  {
    // Data Observation By obscode
    $obs = $this->getObservation($id);
    
    // function Observation By base value typeirigation, opt, saprotan
    $observation = $this->recursiveBase($obs);

    $data += [
      'action' => self::ACTS.'update/'.$id,
      'v' => $observation,
      'back' => self::BACK,
    ];

    echo view(self::VIEW.'update', $data);
  }

  public function update_post($id, $data)
  {
    $db = \Config\Database::connect();

    // Pisah Array OTP dan Saprotan menjadi string
    $newData['opt'] = implode(',', $data['opt']);
    $newData['saprotan'] = implode(',', $data['saprotan']);
    $newData['typeirigation'] = implode(',', $data['typeirigation']);

    // Ganti key Assoc pada $data dengan $newData yang sama OPT dan Saprotan
    $v = array_replace($data, $newData);

    $userid = session('privilage')->userid;
    $timestamp = date('y-m-d H:i:s');

    $db->query("UPDATE `lppbmis`.`observations_frmobservations` 
    SET `areantatus` = '{$v['areantatus']}', 
    `broadnrea` = '{$v['broadnrea']}', 
    `typeirigation` = '{$v['typeirigation']}', 
    `distancefromriver` = '{$v['distancefromriver']}', 
    `distancefromIrgPre` = '{$v['distancefromIrgPre']}', 
    `wtrtreatnnst` = '{$v['wtrtreatnnst']}',
    `intensitynlan` = '{$v['intensitynlan']}', 
    `indxnlant` = '{$v['indxnlant']}', 
    `pattrnnlant` = '{$v['pattrnnlant']}', 
    `opt` = '{$v['opt']}', 
    `wtr` = '{$v['wtr']}', 
    `saprotan` = '{$v['saprotan']}', 
    `other` = '{$v['other']}', 
    `harvstmax` = '{$v['harvstmax']}', 
    `monthmax` = '{$v['monthmax']}', 
    `harvstmin` = '{$v['harvstmin']}', 
    `monthmin` = '{$v['monthmin']}', 
    `harvstsell` = '{$v['harvstsell']}', 
    `farmcode` = '{$v['farmcode']}', 
    `ownerid` = '{$v['ownerid']}', 
    `cultivatorid` = '{$v['cultivatorid']}', 
    `respid` = '{$v['respid']}', 
    `userid` = '{$userid}', 
    `timestamp` = '{$timestamp}'
    WHERE `obscode` = {$id}");

    return $db->affectedRows();
  }

  public function delete_post($id)
  {
    //return $this->delete($id);
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
    cultivatorid,	cultivatornik,	cultivatorname,	landuse, respid, respname, userid,	username')
    ->where('obscode', $id)->first();

    return $query;
  }
  
  public function validationRules($id = null)
  {
    return [
      'broadnrea' => [
        'label' => 'Broad Area',
        'rules' => 'required|decimal|is_unique[observations_frmobservations.broadnrea,obscode,'.$id.']',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'distancefromriver' => [
        'label' => 'Distance From River',
        'rules' => 'required|decimal',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'distancefromIrgPre' => [
        'label' => 'Distance From Irrigation',
        'rules' => 'required|decimal',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'indxnlant' => [
        'label' => 'Index Plantation',
        'rules' => 'required|max_length[3]|numeric|is_unique[observations_frmobservations.indxnlant,obscode,'.$id.']',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'pattrnnlant' => [
        'label' => 'Pattern',
        'rules' => 'required|max_length[100]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'other' => [
        'label' => 'Other',
        'rules' => 'required|max_length[100]',
        'errors' => [
          'required' => 'Diperlukan {field}',
          'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      
    ];

  }



/**
 * --------------------------------------------------------------------
 *
 * Function
 *
 * --------------------------------------------------------------------
 */

  function recursiveBase($observation)
  {
    // Pisah String OTP dan Saprotan dengan delimiter (Koma) menjadi Array
    $opt = explode(',', $observation['opt']);
    $saprotan = explode(',', $observation['saprotan']);
    $typeirigation = explode(',', $observation['typeirigation']);

    // Ganti key Assoc berdasarkan Base dengan value ''
    $optbase = array_fill_keys($this->optbase, '');
    $saprotanbase = array_fill_keys($this->saprotanbase, '');
    $irigationbase = array_fill_keys($this->irigationbase, '');

    // Ganti key Assoc irigation berdasarkan Base dengan value Selected
    $selected = array_fill_keys($typeirigation, 'selected');
    $newObs['typeirigation'] = array_replace_recursive($irigationbase, $selected);
    
    // Ganti key Assoc OPT berdasarkan Base dengan value Selected
    $selected = array_fill_keys($opt, 'selected');
    $newObs['opt'] = array_replace_recursive($optbase, $selected);

    // Ganti key Assoc saprotan berdasarkan Base dengan value Selected
    $selected = array_fill_keys($saprotan, 'selected');
    $newObs['saprotan'] = array_replace_recursive($saprotanbase, $selected);

    // Ganti key Assoc yang sama OPT dan Saprotan dengan value Selected
    $observation = array_replace($observation, $newObs);

    return $observation;
  }
  

}