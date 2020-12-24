<?php namespace App\Models\Adminpanel\Access;

/**
 * --------------------------------------------------------------------
 *
 * Access Setting
 *
 * --------------------------------------------------------------------
 */

use ZipArchive;
use CodeIgniter\Events\Events;

class M_setting extends M_access
{
  const VIEW = 'adminpanel/access/setting/';

  const ACTS = 'administrator/access/setting/';
  const BACK = '/administrator/access/setting';

  const CREATE = 'setting/create';
  const UPDATE = 'setting/update/';
  const DELETE = 'setting/delete/';

  const DATABASE = 'setting/database';
  const UNLINK = '/administrator/access/setting/database/';
  const DUMP = '/administrator/access/setting/database-dump';
  const LOAD = '/administrator/access/setting/database-load/';
  const IMPORT = '/administrator/access/setting/database-import';
  const EXPORT = '/administrator/access/setting/database-export/';


  protected $table = 'mstr_role';
  protected $primaryKey = 'roleid';

  protected $allowedFields = ['rolename','rolemodules','create','read','update','delete'];

  protected $rolebase = ['access','user','data','geo','report'];

  public function list()
  {
    $data = [
      'list' => $this->getRoles(),
      'create' => self::CREATE,
      'update' => self::UPDATE,
      'delete' => self::DELETE,
      'database' => self::DATABASE,
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
    $modules['rolemodules'] = implode(',', $data['rolemodules']);
    $rolemodules = array_replace($data, $modules);

    return $this->insert($rolemodules);
  }

  public function update_new($id, $data)
  {
    $role = $this->getRole($id);
    $rolebase = array_fill_keys($this->rolebase, '');

    $modules = explode(',', $role['rolemodules']);
    $selected = array_fill_keys($modules, 'selected');

    $newRole['rolemodules'] = array_replace($rolebase, $selected);
    $rolemodules = array_replace($role, $newRole);

    $data += [
      'action' => self::ACTS.'update/'.$id,
      'v' => $rolemodules,
      'back' => self::BACK,
    ];

    echo view(self::VIEW.'update', $data);
  }

  public function update_post($id, $data)
  {
    $modules['rolemodules'] = implode(',', $data['rolemodules']);
    $rolemodules = array_replace($data, $modules);

    return $this->update($id, $rolemodules);
  }

  public function delete_post($id)
  {
    return $this->delete($id);
  }

  public function database_list($data)
  {
    $data += [
      'list' => $this->database_file_dir(),
      'dump' => self::DUMP,
      'load' => self::LOAD,
      'import' => self::IMPORT,
      'export' => self::EXPORT,
      'delete' => self::UNLINK,
      'back' => self::BACK,
    ];
    echo view(self::VIEW.'database', $data);
  }

  public function database_dump($filename)
  {
    $db = \Config\Database::connect();
    $folder = WRITEPATH .'uploads\databases';
    $file = $folder .'\\'. $filename;
    exec("mysqldump -h {$db->hostname} --port={$db->port} -u {$db->username} --password={$db->password} {$db->database} > {$file}");

    // Log informations Watch Events
    Events::trigger('watch_event','create','mstr_role', null, ['db_filename' => $filename]);

    return true;
  }

  public function database_restore($filename)
  {
    $db = \Config\Database::connect();
    $folder = WRITEPATH .'uploads\databases';
    $file = $folder .'\\'. $filename;

    exec("mysql -h {$db->hostname} --port={$db->port} -u {$db->username} --password={$db->password} {$db->database} < {$file}");

    // Log informations Watch Events
    Events::trigger('watch_event','read','mstr_role', null, ['db_filename' => $filename]);

    return true;
  }

  public function database_import($file)
  {
    $pathfile = WRITEPATH .'uploads/databases';
    $filename = $file->getName();
    $file->move($pathfile, $filename);

    $extract = $this->extract_zip($pathfile, $filename);

    if($extract)
    {
      unlink($pathfile .'/'. $filename);

      // Log informations Watch Events
      Events::trigger('watch_event','import','mstr_role', null, ['db_filename' => $filename]);

      return true;
    }

  }

  public function database_export($filename)
  {
    $folder = WRITEPATH .'uploads/databases';
    $file = $folder .'/'. $filename;

    // Log informations Watch Events
    Events::trigger('watch_event','export','mstr_role', null, ['db_filename' => $filename]);

    return $file;
  }

  public function database_unlink($filename)
  {
    // Log informations Watch Events
    Events::trigger('watch_event','delete','mstr_role', null, ['db_filename' => $filename]);

    return unlink(WRITEPATH .'uploads/databases/'. $filename);
  }

  public function database_file_dir()
  {
    $folder = WRITEPATH .'uploads/databases';

    if (! file_exists($folder)) {
      mkdir($folder, 0777, true);
    }

    return get_dir_file_info($folder);
  }


  public function getRoles()
  {
    return $this->findAll();
  }

  public function getRole($id)
  {
    return $this->where('roleid', $id)->first();
  }

  public function getRoleModules()
  {
    $query = $this->select('roleid,rolename');
    return $query->findAll();
  }

  
/**
 * --------------------------------------------------------------------
 * Validation
 * --------------------------------------------------------------------
 */

  public function validationRules($id = null)
  {
    return [
      'rolename' => [
        'label' => 'Role Name',
        'rules' => 'required|max_length[30]|is_unique[mstr_role.rolename,roleid,'.$id.']',
        'errors' => [
            'is_unique' => '{field} {value} Sudah Ada',
            'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'rolemodules' => [
        'label' => 'Role Module',
        'rules' => 'required',
      ],
    ];
  }

  public function validationImport()
  {
    return [
      'zip_file' => [
        'label' => 'Import File',
        'rules' => 'uploaded[zip_file]|ext_in[zip_file,zip]|max_size[zip_file,40000]',
        'errors' => [
            'ext_in' => '{field} hanya berextensi file .zip',
            'max_size' => '{field} Maksimal {param}',
            'uploaded' => 'File zip Belum dipilih'
          ]
      ],
    ];
  }

  
/**
 * --------------------------------------------------------------------
 * Function
 * --------------------------------------------------------------------
 */

  function extract_zip($pathfile, $filename)
  {
    $zip = new ZipArchive;
    if ($zip->open($pathfile .'/'. $filename) === TRUE)
    {
      $zip->extractTo($pathfile);
      $zip->close();

      return true;
    } 
    else 
    {
      return false;
    }
  }

}