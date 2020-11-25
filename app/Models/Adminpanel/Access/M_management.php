<?php namespace App\Models\Adminpanel\Access;

/**
 * --------------------------------------------------------------------
 *
 * Access Management
 *
 * --------------------------------------------------------------------
 */
  
class M_management extends M_access
{
  const VIEW = 'adminpanel/access/management/';

  const ACTS = 'administrator/access/management/';
  const BACK = '/administrator/access/management';

  const CREATE = 'management/create';
  const READ   = 'management/read/';
  const UPDATE = 'management/update/';
  const DELETE = 'management/delete/';


  protected $table = 'mstr_users';
  protected $primaryKey = 'userid';

  protected $allowedFields = ['usernik','name','phone','email','password','realpassword','role','image','sts','timestamp'];

  protected $getFile;
  protected $getName;

  public function list($role = null, $keyword = null, $data, $paginate)
  {
    $where = array();
    $like = array();
    $orLike = array();

    if(empty($paginate)) {
      $paginate = 5;
    }

    $data['role'] = $role;
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    if(!empty($role)) {
      $where = ['mstr_users.role' => $role];
    }

    if(!empty($keyword)) {
      $like = ['mstr_users.name' => $keyword];
      $orLike = ['mstr_users.usernik' => $keyword, 'mstr_users.email' => $keyword];
    }

    $data += [
      'list' => $this->getUsers($where, $like, $orLike, $paginate),
      'pager' => $this->pager,
      'create' => self::CREATE,
      'read' => self::READ,
      'update' => self::UPDATE,
      'delete' => self::DELETE,
    ];
    echo view(self::VIEW.'list', $data);
  }

  public function read($id)
  {
    $data = [
      'v' => $this->getUser($id),
      'back' => self::BACK,
    ];
    echo view(self::VIEW.'read', $data);
  }

  public function create_new($data)
  {
    $data += [
      'action' => self::ACTS.'create',
      'back' => self::BACK,
    ];
    echo view(self::VIEW.'create', $data);
  }

  public function create_post($file, $data)
  {
    $upload = $this->uploadfile($file, 'create');

    if($upload) {
      $this->getFile->move('uploads/users', $this->getName);
    } 

    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $image =  $this->getName;
    $timestamp =  date('y-m-d H:i:s');

    $query = $this->query("CALL p_insertUser(
      '{$data['usernik']}',
      '{$data['name']}',
      '{$data['phone']}',
      '{$data['email']}',
      '{$password}',
      '{$data['password']}',
      '{$data['roleid']}',
      '{$image}',
      '{$data['sts']}',
      '{$timestamp}')
      ");

    return $query;
  }

  public function update_new($id, $data, $get)
  {
    $data += [
      'action' => self::ACTS.'update/'.$id.'?'.$get,
      'v' => $this->getUser($id),
      'back' => self::BACK,
    ];
    echo view(self::VIEW.'update', $data);
  }

  public function update_post($file, $id, $data)
  {
    $upload = $this->uploadfile($file, 'update', $data['oldimage']);

    if($upload) {
      $this->getFile->move('uploads/users', $this->getName);
    } 

    $p = array(
      'usernik' => $data['usernik'],
      'name' => $data['name'],
      'phone' => $data['phone'],
      'email' => $data['email'],
      'password' => password_hash($data['password'], PASSWORD_DEFAULT),
      'realpassword' => $data['password'],
      'role' => $data['roleid'],
      'image' => $this->getName,
      'sts' => $data['sts'],
      'timestamp' => date('y-m-d H:i:s'),
    );

    return $this->update($id, $p);
  }

  public function delete_post($id, $data)
  {
    if($data['image'] != 'default.png')
    {
      unlink('uploads/users/'. $data['image']);
    }

    return $this->delete($id);
  }

  public function getUsers($where = null, $like = null, $orLike = null, int $paginate = 5)
  {
    $query = $this->select('userid,usernik,name,email,rolename,sts')
    ->join('mstr_role', 'mstr_users.role = mstr_role.roleid', 'left')
    ->where($where)->like($like)->orLike($orLike)
    ->orderBy('userid DESC');

    return $query->paginate($paginate, 'default');
  }

  public function getUser($id = null)
  {
    $query = $this->select('usernik,name,phone,email,password,realpassword,roleid,rolename,image,sts')
    ->join('mstr_role', 'mstr_users.role = mstr_role.roleid', 'left')
    ->where('mstr_users.userid', $id);

    return $query->first();
  }

  public function validationRules($id = null)
  {
    return [
      'usernik' => [
        'label' => 'NIK',
        'rules' => 'required|max_length[30]|is_unique[mstr_users.usernik,userid,'.$id.']',
        'errors' => [
            'is_unique' => '{field} {value} Sudah Ada',
            'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'name' => [
        'label' => 'Name',
        'rules' => 'required|max_length[30]',
        'errors' => [
            'is_unique' => '{field} {value} Sudah Ada',
            'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'phone' => [
        'label' => 'Phone',
        'rules' => 'required|is_natural|numeric|max_length[15]',
        'errors' => [
            'numeric' => '{field} Harus Numeric',
            'is_natural' => '{field} Tidak Bisa Bernilai Negatif',
            'max_length' => '{field} Maximum 15 Digit'
          ]
      ],
      'email' => [
        'label' => 'Email',
        'rules' => 'required|max_length[30]|is_unique[mstr_users.email,userid,'.$id.']',
        'errors' => [
            'is_unique' => '{field} {value} Sudah Ada',
            'max_length' => '{field} Maximum {param} Character',
          ]
      ],
      'password' => [
        'label' => 'Password',
        'rules' => 'required|max_length[30]',
        'errors' => [
            'max_length' => '{field} Maximum 30 Digit',
          ]
      ],
      'image' => [
        'label' => 'Image',
        'rules' => 'is_image[image]|mime_in[image,image/jpeg,image/jpg,image/bmp,image/png,image/gif]|max_size[image,1024]',
        'errors' => [
            'mime_in' => '{field} Dierekomendasikan File Berekstensi .jpg, .bmp, .png, .gif',
            'max_size' => '{field} Maksimal {param}',
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

  function uploadfile($file, $segment, $filename = null)
  {

    switch($segment)
    {
      case 'create':

        if($file->getErrorString() == "No file was uploaded.")
        {
          $this->getName = 'default.png';
          return false;
        }
        else
        {
          $this->getName = $file->getRandomName();
          $this->getFile = $file;
          return true;
        }

        break;

      case 'update':

        $oldName = $filename;

        if($file->getErrorString() == "No file was uploaded.")
        {
          $this->getName = $oldName;
          return false;
        }
        else
        {
          $this->getName = $file->getRandomName();
          $this->getFile = $file;

          if($oldName != 'default.png')
          {
            unlink('uploads/users/'. $oldName);
          }
          return true;
        }

        break;
    }
  }

}