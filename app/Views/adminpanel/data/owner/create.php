<?= $this->extend('partials/index') ?>

<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-12">

<div class="card">
  <div class="card-header">
    <h5 class="card-title">Tambah data pemilik</h5>
  </div>

  <?php echo form_open($action) ?>
  <div class="card-body">

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="">NIK</label>
          <?php
          $ownernik = [
            'type' => 'text',
            'class' => $validation->hasError('ownernik') ? 'form-control is-invalid' : 'form-control',
            'name' => 'ownernik',
            'placeholder' => 'Masukkan NIK pemilik',
            'minlength' => '1',
            'value' => old('ownernik') == null ? '' : old('ownernik'),
            'required' => ''
          ];
          echo form_input($ownernik);
          ?>
          <div class="invalid-feedback">
            <?= $validation->getError('ownernik') ?>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="">Nama</label>
            <?php
            $ownername = [
              'type' => 'text',
              'class' => $validation->hasError('ownername') ? 'form-control is-invalid' : 'form-control',
              'name' => 'ownername',
              'placeholder' => 'Masukkan nama pemilik',
              'minlength' => '1',
              'value' => old('ownername') == null ? '' : old('ownername'),
              'required' => ''
            ];
            echo form_input($ownername);
            ?>
            <div class="invalid-feedback">
              <?= $validation->getError('ownername') ?>
            </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="">Alamat</label>
          <?php
          $owneraddress = [
            'class' => 'form-control',
            'cols' => '2',
            'rows' => '3',
            'name' => 'owneraddress',
            'minlength' => '1',
            'placeholder' => 'Masukkan alamat pemilik',
            'value' => old('owneraddress') == null ? '' : old('owneraddress'),
            'required' => ''
          ];
          echo form_textarea($owneraddress);
          ?>
          <div class="invalid-feedback">
            <?= $validation->getError('owneraddress') ?>
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
  'title' => 'Create',
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
