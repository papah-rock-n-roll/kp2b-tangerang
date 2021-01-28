
  <div class="card card-success card-outline">
    <div class="card-body box-profile">
      <div class="text-center">
        <p><small><?= $vlcode ?></small></p>
      </div>

      <h3 class="profile-username text-center"><?= $vlname ?></h3>

      <p class="text-muted text-center"><?= $sdname ?></p>

      <a href="<?= $import ?>" class="tmb-import btn btn-sm btn-warning btn-block"><b>Import</b></a>
      <a href="<?= $export .'/'. $vlcode ?>" class="tmb-export btn btn-sm btn-primary btn-block"><b>Export</b></a>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->