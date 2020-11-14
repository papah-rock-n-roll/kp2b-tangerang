<?= $this->extend('partials/index') ?>

<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-12">

<div class="card">
  <div class="card-header">
    <h5 class="card-title"><i class="fas fa-tags"></i> Daftar Menu</h5>
    <div class="card-tools">
      <div class="input-group input-group-sm">
        <div class="input-group-append">
          <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table projects">
      <thead>
        <tr>
          <th style="width: 10%">No</th>
          <th style="width: 85%">Nama</th>
          <th style="width: 5%">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php if(empty($list)) : ?>
        <tr><td colspan="3"><h3>Belum ada data</h3><p>Silahkan menambahkan data terlebih dahulu.</p></td></tr>      
      <?php else : ?>
        <?php foreach($list as $k => $v) : ?>
          <tr>
            <td><?= ++$k ?></td>
            <td><h6><?= esc($v['name']) ?></h6></td>
            <td>
              <div class="btn-group">
                <button type="button" class="tmb-delete btn btn-warning btn-sm" title="Delete - <?= esc($v['name']) ?>" data-toggle="modal" data-target="#modal_<?= $k ?>">
                <i class="fa fa-trash-alt"></i></button>
              </div>
              <?php
                $modals = [
                  'id' => 'modal_'.$k,
                  'size' => 'modal-sm',
                  'class' => 'bg-warning',
                  'title' => 'Delete',
                  'bodytext' => 'Anda Yakin Ingin Menghapus <br>'.esc($v['name']),
                  'action' => $delete . $v['name'],
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