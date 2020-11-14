<?= $this->extend('partials/index') ?>
<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-12">

<div class="card card-primary card-outline">
  <div class="card-body box-profile">
    <div class="text-center">
      <img class="profile-user-img img-fluid img-rounded"
            src="<?= site_url('uploads/users/') . 'default.png' ?>"
            alt="User profile picture">
    </div>

    <h3 class="profile-username text-center"><?= $v['farmname'] ?></h3>

    <p class="text-muted text-center"><?= $v['sdname'] ?></p>
    <p class="text-muted text-center"><?= $v['vlname'] ?></p>

    <ul class="list-group list-group-unbordered mb-3">
      <li class="list-group-item">
        <b>Pemilik</b> <a class="float-right"><?= $v['ownername'] ?></a>
      </li>
      <li class="list-group-item">
        <b>Penggarap</b> <a class="float-right"><?= $v['cultivatorname'] ?></a>
      </li>
      <li class="list-group-item">
        <b>Area Status</b> <a class="float-right"><?= $v['areantatus'] ?></a>
      </li>
      <li class="list-group-item">
        <b>Broad Area</b> <a class="float-right"><?= $v['broadnrea'] ?></a>
      </li>
      <li class="list-group-item">
        <b>Responden</b> <a class="float-right"><?= $v['respname'] ?></a>
      </li>
    </ul>

    <a href="<?= $back ?>" class="btn btn-primary btn-block"><b>Okay</b></a>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->

</div>
</div>
<?= $this->endSection() ?>