<?= $this->extend('partials/index') ?>

<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-12">

<div class="card">
  <div class="card-header">
    <h5 class="card-title">Ubah data responden</h5>
  </div>

  <?php echo form_open($action) ?>
  <div class="card-body">

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="">Nama</label>
          <?php
          $respname = [
            'type' => 'text',
            'class' => $validation->hasError('respname') ? 'form-control is-invalid' : 'form-control',
            'name' => 'respname',
            'placeholder' => 'Masukkan nama responden',
            'minlength' => '1',
            'value' => old('respname') == null ? $v['respname'] : old('respname'),
            'required' => ''
          ];
          echo form_input($respname);
          ?>
          <div class="invalid-feedback">
            <?= $validation->getError('respname') ?>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="">Telp</label>
            <?php
            $mobileno = [
              'type' => 'text',
              'class' => $validation->hasError('mobileno') ? 'form-control is-invalid' : 'form-control',
              'name' => 'mobileno',
              'placeholder' => 'Masukkan no tlp responden',
              'minlength' => '1',
              'value' => old('mobileno') == null ? $v['mobileno'] : old('mobileno'),
              'required' => ''
            ];
            echo form_input($mobileno);
            ?>
            <div class="invalid-feedback">
              <?= $validation->getError('mobileno') ?>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <button type="button" class="btn btn-sm btn-secondary" onclick="window.location.href='<?= esc($back) ?>'">Back</button>
    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
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
