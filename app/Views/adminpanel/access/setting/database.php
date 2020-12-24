<?= $this->extend('partials/index') ?>
<?= $this->section('content') ?>

<div class="row">
  <div class="col-md-6">
    <div class="card">
      <?php echo form_open($dump) ?>
      <div class="card-header">
        <h5 class="card-title"><i class="fas fa-file-alt"></i> Dump</h5>
        <div class="card-tools">
          <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="">Database Filename</label>
          <?php 
          $filename = [
            'type' => 'text',
            'class' => 'form-control',
            'name' => 'filename',
            'placeholder' => 'Enter filename',
            'minlength' => '3',
            'value' => old('filename') == null ? 'db_'.date('Y-m-d').'.sql' : old('filename'),
            'required' => ''
          ];
          echo form_input($filename);
          ?>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
      <?php echo form_close() ?>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card">
      <?php echo form_open_multipart($import) ?>
      <div class="card-header">
        <h5 class="card-title"><i class="fas fa-upload"></i> Import</h5>
        <div class="card-tools">
          <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="">Import File</label>
          <div class="custom-file">
            <?php $custom = $validation->hasError('zip_file') ? 'custom-file-label form-control is-invalid' : 'custom-file-label form-control' ?>
            <label class="<?= esc($custom) ?>" for="zip_file">Choose file</label>
            <?php
            $import = [
              'id' => 'zip_file',
              'class' => 'custom-file-input',
              'name' => 'zip_file',
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
        <button type="submit" class="btn btn-primary">Import</button>
      </div>
      <?php echo form_close() ?>
    </div>
  </div>
</div>

<div class="row">
<div class="col-lg-12">

  <div class="card">
    <div class="card-header">
      <h5 class="card-title"><i class="fas fa-tags"></i> Daftar File</h5>
      <div class="card-tools">
        <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i>
        </button>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover text-nowrap projects">
      <thead>
        <tr>
          <th style="width: 5%">No</th>
          <th style="width: 35%">Filename</th>
          <th style="width: 25%">Size</th>
          <th style="width: 25%">Modified</th>
          <th style="width: 10%">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php if(empty($list)) : ?>
      <tr><td colspan="3"><h3>Belum ada data</h3><p>Silahkan menambahkan data terlebih dahulu.</p></td></tr>      
      <?php else : ?>
        <?php $no = 1 ?>
        <?php foreach($list as $v) : ?>
          <tr>  
            <td><?= $no ?></td>
            <td><?= esc($v['name']) ?></td>
            <td><?= number_to_size(esc($v['size'])) ?></td>
            <td><?= date('Y-m-d H:i:s', esc($v['date'])) ?></td>
            <td>
            <div class="btn-group">
              <button type="button" class="btn btn-info btn-sm" title="Load - <?= esc($v['name']) ?>" data-toggle="modal" data-target="#modal_<?= $no ?>_load">
              <i class="fa fa-edit"></i></button>
              <button type="button" class="btn btn-primary btn-sm" title="Export - <?= esc($v['name']) ?>" onclick="window.location.href='<?= $export . $v['name'] ?>'">
              <i class="fa fa-download"></i></button>
              <button type="button" class="btn btn-warning btn-sm" title="Delete - <?= esc($v['name']) ?>" data-toggle="modal" data-target="#modal_<?= $no ?>_delete">
              <i class="fa fa-trash-alt"></i></button>
            </div>
            <?php
              $modals_1 = [
                'id' => 'modal_'.$no.'_load',
                'size' => 'modal-sm',
                'class' => 'bg-info',
                'title' => 'Restore',
                'bodytext' => 'Anda Yakin Ingin restore database <br>'. esc($v['name']),
                'action' => esc($load . $v['name']),
                ];
              echo view('events/modals', $modals_1);

              $modals_2 = [
                'id' => 'modal_'.$no.'_delete',
                'size' => 'modal-sm',
                'class' => 'bg-warning',
                'title' => 'Delete',
                'bodytext' => 'Anda Yakin Ingin Menghapus <br>'. esc($v['name']),
                'action' => esc($delete . $v['name']),
                ];
              echo view('events/modals', $modals_2);
            ?>
            </td>
          </tr>
          <?php $no++ ?>
        <?php endforeach ?>
      <?php endif ?>
      </tbody>
      </table>
    </div>
  </div>

</div>
</div>

<button type="button" class="btn btn-secondary" onclick="window.location.href='<?= esc($back) ?>'">Back</button>
<div class="clearfix pb-3"></div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?php
if(! empty(session()->getFlashdata('success'))) {
  $toast = [
  'class' => 'bg-success',
  'autohide' => 'true',
  'delay' => '5000',
  'title' => 'Dump',
  'subtitle' => '',
  'body' => session()->getFlashdata('success'),
  'icon' => 'icon fas fa-file-alt',
  'image' => '',
  'imageAlt' => '',
  ];
  echo view('events/toasts', $toast);
}

if(! empty(session()->getFlashdata('info'))) {
  $toast = [
  'class' => 'bg-info',
  'autohide' => 'true',
  'delay' => '5000',
  'title' => 'Load',
  'subtitle' => '',
  'body' => session()->getFlashdata('info'),
  'icon' => 'icon fas fa-edit',
  'image' => '',
  'imageAlt' => '',
  ];
  echo view('events/toasts', $toast);
}

if(! empty(session()->getFlashdata('warning'))) {
  $toast = [
  'class' => 'bg-warning',
  'autohide' => 'true',
  'delay' => '5000',
  'title' => 'Delete',
  'subtitle' => '',
  'body' => session()->getFlashdata('warning'),
  'icon' => 'icon fas fa-trash-alt',
  'image' => '',
  'imageAlt' => '',
  ];
  echo view('events/toasts', $toast);
}
?>

<script>
function filename() {

  const file = document.querySelector('#zip_file');
  const fileLabel = document.querySelector('.custom-file-label');

  fileLabel.textContent = file.files[0].name;
}
</script>
<?= $this->endSection() ?>