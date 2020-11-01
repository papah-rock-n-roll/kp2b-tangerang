<?php namespace App\Models\Adminpanel\Access;

/**
 * --------------------------------------------------------------------
 *
 * Access Setting
 *
 * --------------------------------------------------------------------
 */

class M_setting extends M_access
{
  const ACTS = 'administrator/access/setting/';
  const VIEW = 'adminpanel/access/setting/';
  const BACK = '/administrator/access/setting';

  const CREATE = 'setting/create';
  const UPDATE = 'setting/update/';
  const DELETE = 'setting/delete/';


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

}