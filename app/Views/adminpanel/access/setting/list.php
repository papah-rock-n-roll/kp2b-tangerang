<?= $this->extend('partials/index') ?>
<?= $this->section('content') ?>
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-gray elevation-1"><i class="fas fa-cog"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Database</span>
        <span class="info-box-number">
          <button type="button" class="tmb-read btn btn-info btn-sm" title="Manage" onclick="window.location.href='<?= $database ?>'">
          <i class="fa fa-eye"></i></button>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
</div>

<div class="row">
<div class="col-lg-12">

<div class="card">
  <div class="card-header">
    <h5 class="card-title"><i class="fas fa-tags"></i> Daftar Role</h5>
    <div class="card-tools">
      <button type="button" class="tmb-create btn btn-success btn-sm" onclick="window.location.href='<?= esc($create) ?>'"><i class="fas fa-file-alt"></i> Tambah
      </button>
      <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover text-nowrap projects">
      <thead>
        <tr>
          <th style="width: 5%">No</th>
          <th style="width: 20%">Role</th>
          <th style="width: 30%">Modules</th>
          <th style="width: 5%">Create</th>
          <th style="width: 5%">Read</th>
          <th style="width: 5%">Update</th>
          <th style="width: 5%">Delete</th>
          <th style="width: 5%">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php if(empty($list)) : ?>
      <tr><td colspan="8"><h3>Belum ada data</h3><p>Silahkan menambahkan data terlebih dahulu.</p></td></tr>      
      <?php else : ?>
        <?php foreach($list as $k => $v) : ?>
          <tr>  
            <td><?= ++$k ?></td>
            <td><h6><?= esc($v['rolename']) ?></h6></td>
            <td><?= esc($v['rolemodules']) ?></td>
            <td><?= esc($v['create']) ?></td>
            <td><?= esc($v['read']) ?></td>
            <td><?= esc($v['update']) ?></td>
            <td><?= esc($v['delete']) ?></td>
            <td>
            <div class="btn-group">
              <button type="button" class="tmb-update btn btn-info btn-sm" title="Edit - <?= esc($v['rolename']) ?>" onclick="window.location.href='<?= $update . $v['roleid'] ?>'">
              <i class="fa fa-edit"></i></button>
              <button type="button" class="tmb-delete btn btn-warning btn-sm" title="Delete -<?= esc($v['rolename']) ?>" data-toggle="modal" data-target="#modal_<?= $k ?>">
              <i class="fa fa-trash-alt"></i></button>
            </div>
            <?php
              $modals = [
                'id' => 'modal_'.$k,
                'size' => 'modal-sm',
                'class' => 'bg-warning',
                'title' => 'Delete',
                'bodytext' => 'Anda Yakin Ingin Menghapus '. esc($v['rolename']),
                'action' => esc($delete . $v['roleid']),
                ];
              echo view('events/modals', $modals);
            ?>
            </td>
          </tr>
        <?php endforeach ?>
      <?php endif ?>
      </tbody>
      </table>
    </div>
  </div>
</div>

</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?php 
if(! empty(session()->getFlashdata('warning'))) {
  $toast = [
  'class' => 'bg-warning',
  'autohide' => 'true',
  'delay' => '10000',
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
<?= $this->endSection() ?>