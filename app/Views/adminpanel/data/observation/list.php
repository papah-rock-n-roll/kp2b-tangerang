<?= $this->extend('partials/index') ?>

<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-12">

<div class="card bg-gradient-primary collapsed-card">
  <div class="card-header">
    <h5 class="card-title"><i class="fas fa-search"></i> Filter Data</h5>
    <div class="card-tools" style="width: 50%">
      <div class="input-group input-group-sm">
        <?php
          $paginate = [
            'type'  => 'number',
            'list'  => 'defaultPaginate',
            'class' => 'form-control',
            'name'  => 'paginate',
            'id'    => 'paginate',
            'min'   => 1,
            'max'   => 100,
            'value' => $paginate,
            'placeholder' => 'Paginate...'
          ];
          echo form_input($paginate);
        ?>
        <datalist id="defaultPaginate">
          <option value="5">
          <option value="25">
          <option value="50">
        </datalist>
        <?php echo form_dropdown('farm', $farms, $farm, ['class' => 'custom-select', 'id' => 'farms']) ?>
        <?php
          $form_keyword = [
            'type'  => 'text',
            'class' => 'form-control',
            'name'  => 'keyword',
            'id'    => 'keyword',
            'value' => $keyword,
            'placeholder' => 'Enter keyword ...'
          ];
        echo form_input($form_keyword);
        ?>
        <div class="input-group-append">
          <button class="btn btn btn-secondary" id="filterSubmit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h5 class="card-title"><i class="fas fa-tags"></i> List Data</h5>
    <div class="card-tools">
      <button type="button" class="tmb-create btn btn-success btn-sm" onclick="window.location.href='<?= esc($create) ?>'"><i class="fas fa-file-alt"></i> Tambah
      </button>
      <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i>
      </button>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table projects">
      <thead>
        <tr>
          <th style="width: 5%">No</th>
          <th style="width: 30%">Kode Petak</th>
          <th style="width: 25%">Desa</th>
          <th style="width: 25%">Poktan</th>
          <th style="width: 10%">Pemilik</th>
          <th style="width: 5%">Penggarap</th>
          <th style="width: 25%">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php if(empty($list)) : ?>
        <tr><td colspan="7"><h3>Belum ada data</h3><p>Silahkan menambahkan data terlebih dahulu.</p></td></tr>      
      <?php else : ?>
        <?php foreach($list as $k => $v) : ?>
            <td><?= ++$k ?></td>
            <td><?= $v['obscode'] ?></td>
            <td><?= $v['vlname'] ?></td>
            <td><?= $v['farmname'] ?></td>
            <td><?= $v['ownername'] ?></td>
            <td><?= $v['cultivatorname'] ?></td>
            <td>
              <div class="btn-group">
                <button type="button" class="tmb-read btn btn-primary btn-sm" title="View - <?= $v['obscode'] ?>" onclick="window.location.href='<?= esc($read . $v['obscode']) ?>'">
                <i class="fa fa-eye"></i></button>
                <button type="button" class="tmb-update btn btn-info btn-sm" title="Edit - <?= $v['obscode'] ?>" onclick="window.location.href='<?= esc($update . $v['obscode']) ?>'">
                <i class="fa fa-edit"></i></button>
                <button type="button" class="tmb-delete btn btn-warning btn-sm" title="Delete - <?= $v['obscode'] ?>" data-toggle="modal" data-target="#modal_<?= $k ?>">
                <i class="fa fa-trash-alt"></i></button>
              </div>
              <?php
                $modals = [
                  'id' => 'modal_'.$k,
                  'size' => 'modal-sm',
                  'class' => 'bg-warning',
                  'title' => 'Delete',
                  'bodytext' => 'Anda Yakin Ingin Menghapus '.$v['obscode'],
                  'action' => esc($delete . $v['obscode']),
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
  <div class="card-footer clearfix">
    <div class="pagination pagination-md m-0 float-right">
      <?= $pager->links('observations', 'bootstrap-pager') ?>
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

<script type="text/javascript">

  let filter = function() {
    var farm = $("#farms").val();
    var keyword = $("#keyword").val();
    var paginate = $("#paginate").val();
    window.location.replace("?paginate="+ paginate +"&farm="+ farm +"&keyword="+ keyword);
  };

  $("#filterSubmit").click(function() {
    filter();
  });

  $("#farms").change(function() {
    filter();
  });

  $("#keyword").keypress(function(event) {
    if(event.keyCode == 13) {
      filter();
    }
  });

  $("#paginate").keypress(function(event) {
    if(event.keyCode == 13) {
      filter();
    }
  });

</script>
<?= $this->endSection() ?>