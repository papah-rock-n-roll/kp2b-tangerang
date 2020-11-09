<?= $this->extend('partials/index') ?>

<?= $this->section('link') ?>
<?= \App\Libraries\Link::style()->select2 ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-12">

    <div class="card">
      <div class="card-header">
        <?php
          $uri = service('uri');
          $kodepetak = $uri->getSegment(5);
        ?>
        <h5 class="card-title"><i class="fas fa-search"></i> Plantdates Data -
        <span class="badge badge-primary"><?= $kodepetak ?></span>
        <span class="badge badge-warning"> Index Plantation - 
        <?= $indxnlant ?></span> </h5>
        <div class="card-tools">
          <div class="input-group-append">
            <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table projects">
          <thead>
            <tr>
              <th style="width: 5%">No</th>
              <th style="width: 25%">Grow Season</th>
              <th style="width: 20%">Month Grow</th>
              <th style="width: 20%">Month Harvest</th>
              <th style="width: 25%">Variety</th>
              <th style="width: 5%">Irrigation</th>
            </tr>
          </thead>
          <tbody>
          <?php if(empty($oldlist)) : ?>
            <tr><td colspan="6"><h3>Belum ada data</h3><p>Silahkan menambahkan data terlebih dahulu.</p></td></tr>      
          <?php else : ?>
            <?php foreach($oldlist as $k => $v) : ?>
              <tr>
                <td><?= ++$k ?></td>
                <td><?= esc($v['growceason']) ?></td>
                <td><?= esc($v['monthgrow']) ?></td>
                <td><?= esc($v['monthharvest']) ?></td>
                <td><?= esc($v['varieties']) ?></td>
                <td><?= esc($v['irrigationavbl']) ?></td>
              </tr>
            <?php endforeach ?>
          <?php endif ?>
          </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php if(empty($newlist)) : ?> 

      <div class="card">
        <div class="card-header">
          <h5 class="card-title"><i class="fas fa-tags"></i>  Modify Plantdates Data</h5>
        </div>
        <div class="card-body">
          <div class="callout callout-warning">
            <h5>Silahkan isi Nilai Index Plantation "IP" terlebih dahulu</h5>
          </div>
        </div>
      </div>

    <?php else : ?>
    
      <?php echo form_open($action) ?>  

        <div class="card">
          <div class="card-header d-flex p-0">
            <h5 class="card-title p-3"><i class="fas fa-tags"></i>  Modify Plantdates Data</h5>
            <ul class="nav nav-pills ml-auto p-2">
              <?php $no = 1 ?>
              <?php for ($i = 0; $i < count($newlist); $i++) : ?>
                <li class="nav-item"><a class="nav-link <?= $i == 0 ? 'active' : '' ?>" href="#tab_<?= $i ?>" data-toggle="tab">Index <?= $no ?></a></li>
                <?php ++$no ?>
              <?php endfor ?>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <?php foreach ($newlist as $k => $v) : ?>
                <div class="tab-pane <?= $k == 0 ? 'active' : '' ?>" id="tab_<?= $k ?>">
                  <div class="callout callout-success">
                    <h5>Index Plantation - <?= ++$k ?></h5>
                  </div>

                  <?= view('adminpanel/data/plantdate/component', $v) ?>

                </div>
              <?php endforeach ?>
            </div>
          </div>      
     
          <div class="card-footer">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= esc($back) ?>'">Back</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>

      <?php echo form_close() ?>

    <?php endif ?>

</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= \App\Libraries\Link::script()->select2 ?>

<script>
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    changeSelect()
})

function changeSelect() {
  $('select.select2').select2()
}

</script>

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