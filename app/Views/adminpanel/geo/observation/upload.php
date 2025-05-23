<?= $this->extend('partials/index') ?>
<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-12">

<div class="card">
<?php echo form_open_multipart($action) ?>
  <div class="card-header">
    <h5 class="card-title"><i class="fas fa-upload"></i> Upload</h5>
    <div class="card-tools">
    <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i>
    </button>
    </div>
  </div>
  <div class="card-body">
    <div class="callout callout-warning">
      <h6>Silahkan Pelajari Attribut observasi <strong>Export</strong></h6>
      <p>Primary Key "<strong>obscode, obsshape</strong>"</p>
    </div>
    <div class="form-group">
      <label for="">Tata Cara Upload</label>
      <div>
        <img src="/themes/dist/img/sample-import-shp.png" alt="Thumbnail" class="img-fluid">
      </div>
    </div>
    <div class="form-group">
      <label for="">Import File Zip</label>
      <div class="custom-file">
        <?php $custom = $validation->hasError('zip_file') ? 'custom-file-label form-control is-invalid' : 'custom-file-label form-control' ?>
        <label class="<?= esc($custom) ?>" for="zip_file">Choose file</label>
        <?php
        $import = [
          'id' => 'zip_file',
          'class' => 'custom-file-input',
          'name' => 'zip_file',
          'multiple' => '',
          'accept' => '.zip',
          'onchange' => 'filename()',
        ];
        echo form_upload($import);
        ?>
        <div class="invalid-feedback">
          <?= $validation->getError('zip_file') ?>
        </div>

      </div>
    </div>
  </div>
  <div class="card-footer">
    <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= esc($back) ?>'">Back</button>
    <button type="submit" class="btn btn-primary">Next</button>
  </div>
  <?php echo form_close() ?>
</div>

</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
function filename() {

  const file = document.querySelector('#zip_file');
  const fileLabel = document.querySelector('.custom-file-label');

  fileLabel.textContent = file.files[0].name;
}
</script>
<?= $this->endSection() ?>