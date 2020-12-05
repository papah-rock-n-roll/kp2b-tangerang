<?php namespace App\Models\Adminpanel\Access;

/**
 * --------------------------------------------------------------------
 *
 * Access Log
 *
 * --------------------------------------------------------------------
 */
  
class M_log extends M_access
{
  const VIEW = 'adminpanel/access/log/';

  const ACTS = 'administrator/access/log/';
  const BACK = '/administrator/access/log';

  const READ   = 'log/read/';
  const DELETE = 'log/delete/';

  protected $table = 'log_informations';
  protected $primaryKey = 'logid';

  protected $allowedFields = ['logid','userid','useragent','remoteaddr','watch','table','dataid','description','timestamp'];

  public function list($watch = null, $table = null, $date = null, $keyword = null, $data, $paginate)
  {
    $where = array();
    $orWhere = array();
    $like = array();
    $timestamp = array();

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 5
    if(empty($paginate)) {
      $paginate = 5;
    }

    // Masukan Value berdarakan Array Assoc
    $data['watch'] = $watch;
    $data['table'] = $table;
    $data['date'] = $date;
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    // Jika Tidak null maka where watch or table = $_['GET'] watch
    if(!empty($watch)) $where = ['log_informations.watch' => $watch];    
    if(!empty($table)) $orWhere = ['log_informations.table' => $table];
    if(!empty($date)) $timestamp = ['DATE(log_informations.timestamp)' => $date];
    if(!empty($keyword)) $like = ['mstr_users.name' => $keyword];

    $data += [
      'menu' => $this->getlist(),
      'list' => $this->getInformations($where, $orWhere, $timestamp, $like, $paginate),
      'pager' => $this->pager,
      'read' => self::READ,
      'delete' => self::DELETE,
    ];

    echo view(self::VIEW.'list', $data);
  }

  public function read($id)
  {
    $data = [
      'v' => $this->getInformation($id),
      'back' => self::BACK,
    ];

    echo view(self::VIEW.'read', $data);
  }


  public function delete_post($data, $ext = null)
  {
    switch ($data) {

      case 'session':
        return delete_files(WRITEPATH.'session');
      break;

      case 'cache':
        if (!empty($ext))
        {
          return array_map('unlink', glob(WRITEPATH .'cache/*.'. $ext));
        }
        else
        {
          return delete_files(WRITEPATH.'cache');
        }
      break;

      case 'logs':
        return delete_files(WRITEPATH.'logs');
      break;

      case 'debugbar':
        return delete_files(WRITEPATH.'debugbar');
      break;

    }

  }

/**
 * --------------------------------------------------------------------
 * Data List
 * --------------------------------------------------------------------
 */
  public function getlist()
  {
    $list = [
      ['id' => 1,'name' => 'session'], 
      ['id' => 2,'name' => 'cache'], 
      ['id' => 3,'name' => 'logs'],
      ['id' => 4,'name' => 'debugbar']
    ];

    return $list;
  }

  public function getWatch()
  {
    $list = [
      ['name' => 'login'], 
      ['name' => 'logout'], 
      ['name' => 'create'],
      ['name' => 'update'],
      ['name' => 'delete'],
      ['name' => 'import'],
      ['name' => 'export']
    ];

    return $list;
  }

  public function getTable()
  {
    $list = [
      ['name' => 'mstr_role'],
      ['name' => 'mstr_users'],
      ['name' => 'mstr_owners'],
      ['name' => 'mstr_farmers'], 
      ['name' => 'mstr_respondens'],
      ['name' => 'observations_frmobservations'],
      ['name' => 'observations_plantdates'],
    ];

    return $list;
  }

/**
 * --------------------------------------------------------------------
 * Query
 * --------------------------------------------------------------------
 */
  public function getInformations($where = null, $orWhere = null, $timestamp = null, $like = null, $paginate = 5)
  {
    $query = $this->select('log_informations.logid, mstr_users.name, log_informations.watch, 
    log_informations.table, log_informations.dataid, log_informations.timestamp')
    ->join('mstr_users', 'log_informations.userid = mstr_users.userid')
    ->where($where)->orWhere($orWhere)->orWhere($timestamp)->like($like, 'match')
    ->orderBy('timestamp DESC')->paginate($paginate, 'default');

    return $query;
  }

  public function getInformation($id)
  {
    $query = $this->select('mstr_users.name, mstr_users.email, mstr_users.image, 
    log_informations.useragent, log_informations.remoteaddr, log_informations.watch, 
    log_informations.table, log_informations.dataid, 
    log_informations.description, log_informations.timestamp')
    ->join('mstr_users', 'log_informations.userid = mstr_users.userid')->find($id);

    return $query;
  }


/**
 * --------------------------------------------------------------------
 * Events uri string
 * --------------------------------------------------------------------
 */
  public function log_informations_post($uri, $id = null, $data)
  {
    $module = $uri[1] ?? 'NaN';
    $menu = $uri[2] ?? 'NaN';
    $action = $uri[3] ?? 'NaN';

    switch ($module) :

      // ---------------------------------------------------------

      case 'access':

        switch ($menu) {

          case 'management':

            if($action == 'create') {
              $watch = 'create';
              $table = 'mstr_users';
              $this->create_post($watch, $table, $id, $data);
            } 
            elseif($action == 'update') {
              $watch = 'update';
              $table = 'mstr_users';
              $this->create_post($watch, $table, $id, $data);
            }
            elseif($action == 'delete') {
              $watch = 'delete';
              $table = 'mstr_users';
              $this->create_post($watch, $table, $id, $data);
            }

          break;

          case 'setting':

            if($action == 'create') {
              $watch = 'create';
              $table = 'mstr_role';
              $this->create_post($watch, $table, $id, $data);
            } 
            elseif($action == 'update') {
              $watch = 'update';
              $table = 'mstr_role';
              $this->create_post($watch, $table, $id, $data);
            }
            elseif($action == 'delete') {
              $watch = 'delete';
              $table = 'mstr_role';
              $this->create_post($watch, $table, $id, $data);
            }

          break;

          # case 'log':
            
          # break;
        }

      break;

      // ---------------------------------------------------------

      case 'user':

        switch ($menu) {

          case 'account':

            if($action == 'update') {
              $watch = 'update';
              $table = 'mstr_users';
              $this->create_post($watch, $table, $id, $data);
            }

          break;
        }

      break;

      // ---------------------------------------------------------

      case 'data':

        switch ($menu) {

          case 'observation':

            if($action == 'create') {
              $watch = 'create';
              $table = 'observations_frmobservations';
              $this->create_post($watch, $table, $id, $data);
            } 
            elseif($action == 'update') {
              $watch = 'update';
              $table = 'observations_frmobservations';
              $this->create_post($watch, $table, $id, $data);
            }
            elseif($action == 'delete') {
              $watch = 'delete';
              $table = 'observations_frmobservations';
              $this->create_post($watch, $table, $id, $data);
            }
            elseif($action == 'plantdate') {
              $watch = 'update';
              $table = 'observations_plantdates';
              $this->create_post($watch, $table, $id, $data);
            }
            elseif($action == 'import') {
              $watch = 'import';
              $table = 'observations_plantdates';
              $this->create_post($watch, $table, $id, $data);             
            } 
            elseif($action == 'export') {
              $watch = 'export';
              $table = 'observations_plantdates';
              $this->create_post($watch, $table, $id, $data);             
            }     

          break;

          case 'owner':

            if($action == 'create') {
              $watch = 'create';
              $table = 'mstr_owners';
              $this->create_post($watch, $table, $id, $data);
            } 
            elseif($action == 'update') {
              $watch = 'update';
              $table = 'mstr_owners';
              $this->create_post($watch, $table, $id, $data);
            }
            elseif($action == 'delete') {
              $watch = 'delete';
              $table = 'mstr_owners';
              $this->create_post($watch, $table, $id, $data);
            }
            elseif($action == 'import') {
              $watch = 'import';
              $table = 'mstr_owners';
              $this->create_post($watch, $table, $id, $data);             
            } 
            elseif($action == 'export') {
              $watch = 'export';
              $table = 'mstr_owners';
              $this->create_post($watch, $table, $id, $data);             
            }
                      
          break;

          case 'farmer':

            if($action == 'create') {
              $watch = 'create';
              $table = 'mstr_farmers';
              $this->create_post($watch, $table, $id, $data);
            } 
            elseif($action == 'update') {
              $watch = 'update';
              $table = 'mstr_farmers';
              $this->create_post($watch, $table, $id, $data);
            }
            elseif($action == 'delete') {
              $watch = 'delete';
              $table = 'mstr_farmers';
              $this->create_post($watch, $table, $id, $data);             
            }
            elseif($action == 'import') {
              $watch = 'import';
              $table = 'mstr_farmers';
              $this->create_post($watch, $table, $id, $data);             
            } 
            elseif($action == 'export') {
              $watch = 'export';
              $table = 'mstr_farmers';
              $this->create_post($watch, $table, $id, $data);             
            }        

          break;

          case 'responden':

            if($action == 'create') {
              $watch = 'create';
              $table = 'mstr_respondens';
              $this->create_post($watch, $table, $id, $data);
            } 
            elseif($action == 'update') {
              $watch = 'update';
              $table = 'mstr_respondens';
              $this->create_post($watch, $table, $id, $data);
            }
            elseif($action == 'delete') {
              $watch = 'delete';
              $table = 'mstr_respondens';
              $this->create_post($watch, $table, $id, $data);              
            }

          break;
        }

      break;

      // ---------------------------------------------------------

      case 'geo':

        switch ($menu) {

          case 'observation':

          break;

          case 'village':
            
          break;

          case 'subdistrict':
            
          break;

        }

      break;

      // ---------------------------------------------------------

      case 'report':

        switch ($menu) {

          case 'graph':

          break;

          case 'table':
            
          break;

        }

      break;

      // ---------------------------------------------------------

    endswitch;

  }


/**
 * --------------------------------------------------------------------
 * Prosedur create log information adminpanel
 * --------------------------------------------------------------------
 */
  public function create_post($action, $table, $id = null, $postData = null)
  {
    $db = \Config\Database::connect();
    $schema = $db->database;
	
	  helper('parse');

    if(empty($id)) 
    {
      $info = "SELECT AUTO_INCREMENT AS numID FROM information_schema.TABLES
      WHERE TABLE_SCHEMA = '{$schema}' AND TABLE_NAME = '{$table}'";

      $v = $db->query($info)->getRowArray();
      $newData = $postData;
    }
    else
    {
      $info = "SELECT COLUMN_NAME AS fieldID FROM information_schema.COLUMNS 
      WHERE TABLE_SCHEMA = '{$schema}' AND TABLE_NAME = '{$table}' AND
      ORDINAL_POSITION = 1";

      $v = $db->query($info)->getRowArray();
      $oldData = $db->table($table)->where($v['fieldID'], $id)->get()->getRowArray();
      $newData = $postData;
    }

    $ua = parent::remoteaddr();

    $query = [
      'logid' => uniqid(),
      'userid' => session('privilage')->userid,
      'useragent' => json_encode($ua['useragent'], JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES),
      'remoteaddr' => json_encode($ua['remoteaddr'], JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES),
    ];

    switch ($action) {

      case 'create':

        $query += [
          'watch' => $action,
          'table' => $table,
          'dataid' => $v['numID'],
          'description' => json_encode(['new' => $newData], JSON_NUMERIC_CHECK),
          'timestamp' => date('y-m-d H:i:s'),
        ];

      break;

      case 'update':

        if($table === 'observations_plantdates') 
        {
          $oldData = $db->table($table)
          ->select('growceason,monthgrow,monthharvest,varieties,irrigationavbl')
          ->where('obscode', $id)->get()->getResultArray();

          $oldData = transpose($oldData);

          $query += [
            'watch' => $action,
            'table' => $table,
            'dataid' => $id,
            'description' => json_encode([
              'new' => array_diff_recursive($newData, $oldData),
              'old' => array_diff_recursive($oldData, $newData)
            ], JSON_NUMERIC_CHECK),
            'timestamp' => date('y-m-d H:i:s'),
          ];
        }
        else
        {
          $query += [
            'watch' => $action,
            'table' => $table,
            'dataid' => $id,
            'description' => json_encode([
              'new' => array_diff_recursive($newData, $oldData),
              'old' => array_diff_recursive($oldData, $newData)
            ], JSON_NUMERIC_CHECK),
            'timestamp' => date('y-m-d H:i:s'),
          ];
        }
        
      break;

      case 'delete':

        $query += [
          'watch' => $action,
          'table' => $table,
          'dataid' => $id,
          'description' => json_encode(['old' => $oldData], JSON_NUMERIC_CHECK),
          'timestamp' => date('y-m-d H:i:s'),
        ];
        
      break;

      case 'import':

        $query += [
          'watch' => $action,
          'table' => $table,
          'dataid' => $id,
          'description' => json_encode(['post' => $postData], JSON_NUMERIC_CHECK),
          'timestamp' => date('y-m-d H:i:s'),
        ];
        
      break;

      case 'export':

        $query += [
          'watch' => $action,
          'table' => $table,
          'dataid' => $id,
          'description' => json_encode(['get' => $postData], JSON_NUMERIC_CHECK),
          'timestamp' => date('y-m-d H:i:s'),
        ];
        
      break;

    }

    $this->insert($query);
  }

/**
 * --------------------------------------------------------------------
 * Proses create log information login - logout
 * --------------------------------------------------------------------
 */
  public function login_post($action, $table, $postData = null)
  {
    $auth = session()->has('privilage');

    if($auth)
    {
      $ua = parent::remoteaddr();

      $query = [
        'logid' => uniqid(),
        'userid' => session('privilage')->userid,
        'useragent' => json_encode($ua['useragent'], JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES),
        'remoteaddr' => json_encode($ua['remoteaddr'], JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES),
        'watch' => $action,
        'table' => $table,
        'dataid' => session('privilage')->userid,
        'description' => json_encode(['post' => $postData], JSON_NUMERIC_CHECK),
        'timestamp' => date('y-m-d H:i:s'),
      ];

      $this->insert($query);
    }
  }

  //--------------------------------------------------------------------

  public function logout_post($action, $table, $postData = null)
  {
    $ua = parent::remoteaddr();

    $db = \Config\Database::connect();
    $id = session('privilage')->userid;

    $prep = $db->query("SELECT
      t_user.userid,
      t_user.name,
      t_user.email,
      t_user.realpassword,
      t_role.rolename
      FROM
      mstr_users t_user
      JOIN mstr_role t_role ON t_role.roleid = t_user.role
      WHERE t_user.userid = '{$id}'
    ");

    $v = $prep->getRowArray();

    $query = [
      'logid' => uniqid(),
      'userid' => $v['userid'],
      'useragent' => json_encode($ua['useragent'], JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES),
      'remoteaddr' => json_encode($ua['remoteaddr'], JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES),
      'watch' => $action,
      'table' => $table,
      'dataid' => $v['userid'],
      'description' => json_encode([
        'post' => [
          'name' => $v['name'],
          'email' => $v['email'],
          'password' => $v['realpassword'],
          'rolename' => $v['rolename']
        ]
      ], JSON_NUMERIC_CHECK),
      'timestamp' => date('y-m-d H:i:s'),
    ];

    $this->insert($query);
  }

  # public function register_post($action, $table, $postData = null)
  # {
  #   return false;
  # }

}