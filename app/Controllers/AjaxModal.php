<?php
  defined(‘BASEPATH’) or exit(‘No direct script access allowed’);
  class Ajaxmodal extends CI_Controller{
    function__construct(){
      parent::__construct();
      // load helper
      $this->load->helper(array(‘url’));
      //load model
      $this->load->model(‘ajaxmodal_model’, ”, true);
    }

    functionindex(){
      //load view
      $this->load->view(‘index’);
    }

    functionsrvLoad_usergetbyid(){
      $user=$this->ajaxmodal_model->userGetById(array($this->input->post(‘id’)));
    ?>

      <tableclass=”table table-bordered”>
        <tbody>
          <tr>
            <th>Nama</th>
            <th>:</th>
            <th><?=$user[0][‘nama’]?></th>
          </tr>
          <tr>
            <th>Jenis Kelamin</th>
            <th>:</th>
            <th><?=$user[0][‘kelamin’]?></th>
          </tr>
          <tr>
            <th>Tempat & Tanggal Lahir</th>
            <th>:</th>
            <th><?=$user[0][‘tempat_lahir’].’, ‘.date(‘d-m-Y’,strtotime($user[0][‘tempat_lahir’]))?></th>
          </tr>
          <tr>
            <th>No HP</th>
            <th>:</th>
            <th><?=$user[0][‘hp’]?></th>
          </tr>
          <tr>
            <th>Alamat</th>
            <th>:</th>
            <th><?=$user[0][‘alamat’]?></th>
          </tr>
        </tbody>
      </table>
    <?php
    }
  }
