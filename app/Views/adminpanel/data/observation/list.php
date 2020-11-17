<?= $this->extend('partials/index') ?>

<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-12">

<div class="card bg-gradient-primary collapsed-card">
  <div class="card-header p-2">
    <h5 class="card-title col-3"><i class="fas fa-search"></i> Filter</h5>
    <div class="card-tools col-8 col-sm-8 col-lg-6">
      <div class="input-group input-group-sm">
        <?php echo form_dropdown('farm', $farms, $farm, ['class' => 'custom-select', 'id' => 'farms']) ?>
        <?php
          $form_keyword = [
            'type'  => 'text',
            'class' => 'form-control',
            'name'  => 'keyword',
            'id'    => 'keyword',
            'value' => $keyword,
            'placeholder' => 'Enter keyword..'
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
    <h5 class="card-title"><i class="fas fa-tags"></i> Observasi Petak</h5>
    <div class="card-tools">
      <div class="input-group input-group-sm">
        <?php
            $paginate = [
              '5' => '5',
              '10' => '10',
              '50' => '50',
              '100' => '100'
            ];
          echo form_dropdown('paginate', $paginate, $page, ['class' => 'custom-select', 'id' => 'paginate']);
        ?>
        <div class="input-group-append">
          <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
          Action  <span class="sr-only">Toggle Dropdown</span>
          </button>
          <div class="dropdown-menu" role="menu">
            <a class="tmb-read dropdown-item" id="export">Export <i class="fas fa-download float-right p-1"></i></a>
            <a class="tmb-update dropdown-item" href="<?= esc($import) ?>">Import <i class="fas fa-upload float-right p-1"></i></a>
          </div>
        </div>
        <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover text-nowrap projects">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode</th>
          <th>Poktan</th>
          <th>Pemilik</th>
          <th>Penggarap</th>
          <th width="40px">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php if(empty($list)) : ?>
        <tr><td colspan="6"><h3>Belum ada data</h3><p>Silahkan menambahkan data terlebih dahulu.</p></td></tr>
      <?php else : ?>
        <?php foreach($list as $k => $v) : ?>
          <tr>
            <td><?= ++$k ?></td>
            <td><?= esc($v['obscode']) ?></td>
            <td>
              <b><?= esc($v['farmname']) ?></b>
              <p class="text-muted text-sm mb-0"><?= esc($v['vlname']) ?></p>
            </td>
            <td>
              <b><?= esc($v['ownername']) ?></b>
              <p class="text-muted text-sm mb-0"><?= esc($v['ownernik']) ?></p>
            </td>
            <td>
              <b><?= esc($v['cultivatorname']) ?></b>
              <p class="text-muted text-sm mb-0"><?= esc($v['cultivatornik']) ?></p>
            </td>
            <td>
              <div class="btn-group btn-group-sm">
                <button type="button" class="tmb-update btn btn-default btn-sm" title="Edit - <?= esc($v['obscode']) ?>" onclick="window.location.href='<?= $update . $v['obscode'] ?>'">
                <i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu">
                  <a class="tmb-read dropdown-item" href="<?= $read . $v['obscode'] ?>">View Farmer</a>
                  <div class="dropdown-divider"></div>
                  <a class="tmb-update dropdown-item" href="<?= $plantdate . $v['obscode'] ?>">Calendar Plantation</a>
                </div>
              </div>
              <?php
                $modals = [
                  'id' => 'modal_'.$k,
                  'size' => 'modal-sm',
                  'class' => 'bg-warning',
                  'title' => 'Delete',
                  'bodytext' => 'Anda Yakin Ingin Menghapus <br> obscode - '. esc($v['obscode'] .' Farmname - '.$v['farmname']),
                  'action' => $delete . $v['obscode'],
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
    <div class="pagination pagination-sm m-0 float-right">
      <?= $pager->links('default', 'bootstrap-pager') ?>
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

if(! empty(session()->getFlashdata('catch'))) {
  $toast = [
  'class' => 'bg-warning',
  'autohide' => 'true',
  'delay' => '10000',
  'title' => 'Warning',
  'subtitle' => '',
  'body' => session()->getFlashdata('catch'),
  'icon' => 'icon fas fa-exclamation-triangle',
  'image' => '',
  'imageAlt' => '',
  ];
  echo view('events/toasts', $toast);
}

if(! empty(session()->getFlashdata('import'))) {
  $toast = [
  'class' => 'bg-info',
  'autohide' => 'true',
  'delay' => '10000',
  'title' => 'Import',
  'subtitle' => '',
  'body' => session()->getFlashdata('import'),
  'icon' => 'icon fas fa-check',
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

  $("#paginate").change(function() {
    filter();
  });

  let obs_export = function() {
    var farm = $("#farms").val();
    var keyword = $("#keyword").val();
    var paginate = $("#paginate").val();
    window.location.replace("<?= esc($export) ?>?paginate="+ paginate +"&farm="+ farm +"&keyword="+ keyword);
  };

  $("#export").click(function() {
    obs_export();
  });

</script>
<?= $this->endSection() ?>
