
  <div class="card card-success card-outline">
    <div class="card-body box-profile">
      <div class="text-center">
        <p><small>Kode Petak</small></p>
      </div>

      <h3 class="profile-username text-center"><?= $obscode ?></h3>

      <p class="text-muted text-center"><?= $farmname ?></p>

      <ul class="list-group list-group-unbordered mb-3">
        <li class="list-group-item">
          <b>Pemilik</b>
          <br>
          <small><?= $ownername ?></small>
        </li>
        <li class="list-group-item">
          <b>Penggarap</b>
          <br>
          <small><?= $cultivatorname ?></small>
        </li>
        <li class="list-group-item">
          <b>Kecamatan</b>
          <br>
          <small><?= $sdname ?></small>
        </li>
        <li class="list-group-item">
          <b>Desa</b>
          <br>
          <small><?= $vlname ?></small>
        </li>
      </ul>

      <a href="<?= $import ?>" class="btn btn-sm btn-warning btn-block"><b>Import</b></a>
      <a href="<?= $export .'/'. $obscode ?>" class="btn btn-sm btn-primary btn-block"><b>Export</b></a>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->