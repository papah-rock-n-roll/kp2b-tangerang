<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['firstname','lastname','password','email'];

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];


    protected function beforeInsert(array $data)
    {
        $data = $this->password_hash($data);
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data = $this->password_hash($data);
        return $data;
    }

    protected function password_hash(array $data)
    {
        if (isset($data['data']['password']))
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }
}