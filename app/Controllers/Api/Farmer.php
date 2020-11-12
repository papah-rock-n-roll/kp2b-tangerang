<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Farmer extends ResourceController
{
    protected $modelName = 'App\Models\FarmerModel';
    protected $format = 'json';

    public function index()
    {
        $posts = $this->model->findAll();
        return $this->respond($posts);
    }

    public function create()
    {
        helper(['form']);
        $rules = [
            'farmcode' => 'required',
            'farmname' => 'required|min_length[1]',
            'farmmobile' => 'required',
            'farmhead' => 'required',
        ];

        if (!$this->validate($rules)) {
           return $this->fail($this->validator->getErrors());
        }else{
            $data = [
                'farmcode' => $this->request->getVar('farmcode'),
                'farmname' => $this->request->getVar('farmname'),
                'farmmobile' => $this->request->getVar('farmmobile'),
                'farmhead' => $this->request->getVar('farmhead'),
            ];
            $post_farmcode=$this->model->insert($data);
            // $data['farmcode'] = $post_farmcode;
            return $this->respondCreated($data);
        }
    }


    public function show($id =null)
    {
        $data = $this->model->find($id);
        var_dump($data);
        return $this->respond($data);
    }


    public function update($id = null){
        helper(['form']);
        $rules = [
            // 'farmcode' => 'required',
            'farmname' => 'required|min_length[1]',
            'farmmobile' => 'required',
            'farmhead' => 'required',
        ];
        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
         }else{
             $input = $this->request->getRawInput();
             $data = [
                 'farmcode' => $id,
                 'farmname' => $input['farmname'],
                 'farmmobile' => $input['farmmobile'],
                 'farmhead' => $input['farmhead'],
             ];

             $this->model->save($data);
             return $this->respond($data);
         }
    }

    public function delete($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            $this->model->delete($id);
            return $this->respondDeleted($data);
        }else{
            return $this->failNotFound('Item tidak di temukan mang,...'); 
        }
    }

}
