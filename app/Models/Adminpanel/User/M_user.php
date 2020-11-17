<?php namespace App\Models\Adminpanel\User;

/**
 * --------------------------------------------------------------------
 *
 * User Main
 *
 * --------------------------------------------------------------------
 */

use CodeIgniter\Model;
  
class M_user extends Model
{
  const VIEW = 'adminpanel/user/account/';

  const ACTS = 'administrator/user/account/';
  const BACK = '/administrator/user';

  const UPDATE = 'account/';


  protected $table = 'mstr_users';
  protected $primaryKey = 'userid';

  protected $allowedFields = ['usernik','name','phone','email','password','realpassword','role','image','sts','timestamp'];

  protected $getFile;
  protected $getName;


  public function dashboard($role = null, $keyword = null, $data, $paginate)
  {
    $where = array();
    $like = array();
    $orLike = array();

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 5
    if(empty($paginate)) {
      $paginate = 8;
    }

    // Masukan Value berdarakan Array Assoc
    $data['role'] = $role;
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    // Jika Tidak null maka where role = $_['GET'] role
    if(!empty($role)) {
      $where = ['mstr_users.role' => $role];
    }

    // Jika Tidak null maka like name - or like usernik = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['mstr_users.name' => $keyword];
      $orLike = ['mstr_users.usernik' => $keyword];
    }

    $data += [
      'list' => $this->getListusers($where, $like, $orLike, $paginate),
      'pager' => $this->pager,
    ];

    echo view('adminpanel/user/main', $data);
  }

  public function update_new($id, $data)
  {
    $data += [
      'action' => self::ACTS.'update/'.$id,
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

  public function getListusers($where = null, $like = null, $orLike = null, $paginate = 5)
  {
    $query = $this->select('
      mstr_users.userid,
      mstr_users.usernik,
      mstr_users.name,
      mstr_users.role,
      mstr_users.image,
      mstr_role.roleid,
      mstr_role.rolename')
    ->selectCount('t_frmobs.userid', 'observations')
    ->join('mstr_role', 'mstr_users.role = mstr_role.roleid', 'left')
    ->join('observations_frmobservations t_frmobs', 'mstr_users.userid = t_frmobs.userid', 'left')
    ->where($where)->like($like)->orLike($orLike)
    ->groupBy('t_frmobs.userid')
    ->orderBy('mstr_users.userid DESC');
        
    return $query->paginate($paginate, 'default');
  }


  public function getUser($id = null)
  {
    $query = $this->select('usernik,name,phone,email,password,realpassword,roleid,rolename,image,sts')
    ->join('mstr_role', 'mstr_users.role = mstr_role.roleid')
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