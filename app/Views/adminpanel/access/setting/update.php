<?= $this->extend('partials/index') ?>

<?= $this->section('link') ?>
<?= \App\Libraries\Link::style()->select2 ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php 
$create = $v['create'] ? 'checked' : '';
$read = $v['read'] ? 'checked' : '';
$update = $v['update'] ? 'checked' : '';
$delete = $v['delete'] ? 'checked' : '';
?>

<div class="row">
<div class="col-lg-12">

<div class="card">
  <div class="card-header">
    <h5 class="card-title">Create Role</h5>
  </div>
  <div class="card-body">
  <?php echo form_open($action) ?>
    <div class="form-group">
      <label for="">Role Name</label>
      <?php 
      $rolename = [
        'type' => 'text',
        'class' => $validation->hasError('rolename') ? 'form-control is-invalid' : 'form-control',
        'name' => 'rolename',
        'placeholder' => 'Enter Role name',
        'minlength' => '3',
        'value' => old('rolename') == null ? $v['rolename'] : old('rolename'),
        'required' => ''
      ];
      echo form_input($rolename);
      ?>
      <div class="invalid-feedback">
      <?= $validation->getError('rolename') ?>
      </div>
    </div>
    <div class="form-group">
      <label for="">Role Module</label>
      <?php $valid = $validation->hasError('rolemodules') ? 'form-control is-invalid' : 'form-control' ?>
      <select class="<?= $valid ?> select2" name="rolemodules[]" multiple="multiple" data-placeholder="Select Module">
        <?php foreach($v['rolemodules'] as $k => $v) : ?>
          <option <?= $v ?>><?= $k ?></option>
        <?php endforeach ?>
      </select>
      <div class="invalid-feedback">
        <?= $validation->getError('rolemodules') ?>
      </div>
    </div>
    
    <div class="form-group">
      <label for="">Action</label>
      <div class="form-check">
        <input class="form-check-input" name="create" type="checkbox" value="1" <?= $create ?> >
        <label class="form-check-label">Create</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="read" type="checkbox" value="1" <?= $read ?> >
        <label class="form-check-label">Read</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="update" type="checkbox" value="1" <?= $update ?> >
        <label class="form-check-label">Update</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="delete" type="checkbox" value="1" <?= $delete ?> >
        <label class="form-check-label">Delete</label>
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
<?= \App\Libraries\Link::script()->select2 ?>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

  });
</script>

<?php
if(! empty(session()->getFlashdata('success'))) {
  $toast = [
  'class' => 'bg-success',
  'autohide' => 'true',
  'delay' => '5000',
  'title' => 'Update Category',
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