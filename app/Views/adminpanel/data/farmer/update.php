<?= $this->extend('partials/index') ?>

<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-12">

<div class="card">
  <div class="card-header">
    <h5 class="card-title">Create Farm</h5>
  </div>

  <?php echo form_open($action) ?>
  <div class="card-body">

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="">Chief Name</label>
          <?php 
          $farmhead = [
            'type' => 'text',
            'class' => $validation->hasError('farmhead') ? 'form-control is-invalid' : 'form-control',
            'name' => 'farmhead',
            'placeholder' => 'Enter Farm Name',
            'minlength' => '1',
            'value' => old('farmhead') == null ? $v['farmhead'] : old('farmhead'),
            'required' => ''
          ];
          echo form_input($farmhead);
          ?>
          <div class="invalid-feedback">
            <?= $validation->getError('farmhead') ?>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="">Phone</label>
            <?php 
            $farmmobile = [
              'type' => 'text',
              'class' => $validation->hasError('farmmobile') ? 'form-control is-invalid' : 'form-control',
              'name' => 'farmmobile',
              'placeholder' => 'Enter Name',
              'minlength' => '1',
              'value' => old('farmmobile') == null ? $v['farmmobile'] : old('farmmobile'),
              'required' => ''
            ];
            echo form_input($farmmobile);
            ?>
            <div class="invalid-feedback">
              <?= $validation->getError('farmmobile') ?>
            </div>
        </div>
      </div>      
    </div>         
     
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="">Farm Name</label>
          <?php
          $farmname = [
            'type' => 'text',
            'class' => $validation->hasError('farmname') ? 'form-control is-invalid' : 'form-control',
            'name' => 'farmname',
            'placeholder' => 'Enter Name',
            'minlength' => '1',
            'value' => old('farmname') == null ? $v['farmname'] : old('farmname'),
            'required' => ''
          ];
          echo form_input($farmname);
          ?>
          <div class="invalid-feedback">
            <?= $validation->getError('farmname') ?>
          </div>
        </div>
      </div>        
    </div>

  </div>
  <div class="card-footer">
    <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= esc($back) ?>'">Back</button>
    <button type="submit" class="btn btn-primary">Simpan</button>
  </div>
  <?php echo form_close() ?>

</div>

</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?php
if(! empty(session()->getFlashdata('success'))) {
  $toast = [
  'class' => 'bg-success',
  'autohide' => 'true',
  'delay' => '5000',
  'title' => 'Update',
  'subtitle' => '',
  'body' => session()->getFlashdata('success'),
  'icon' => 'icon fas fa-file-alt',
  'image' => '',
  'imageAlt' => '',
  ];
  echo view('events/toasts', $toast);
}
?>
<?= $this->endSection() ?>