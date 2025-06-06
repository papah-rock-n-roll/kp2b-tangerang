<?= $this->extend('partials/index') ?>
<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-12">

<div class="card card-primary card-outline">
  <div class="card-body box-profile">
    <div class="text-center">
      <img class="profile-user-img img-fluid img-rounded"
            src="<?= site_url('uploads/users/') . $v['image'] ?>"
            alt="User profile picture">
    </div>

    <h3 class="profile-username text-center"><?= $v['name'] ?></h3>

    <p class="text-muted text-center"><?= $v['usernik'] ?></p>

    <ul class="list-group list-group-unbordered mb-3">
      <li class="list-group-item">
        <b>Phone</b> <a class="float-right"><?= $v['phone'] ?></a>
      </li>
      <li class="list-group-item">
        <b>Email</b> <a class="float-right"><?= $v['email'] ?></a>
      </li>
      <li class="list-group-item">
        <b>Role</b> <a class="float-right"><?= $v['rolename'] ?></a>
      </li>
      <li class="list-group-item">
        <b>Password</b> <a class="float-right"><?= $v['realpassword'] ?></a>
      </li>
      <li class="list-group-item">
        <b>Status</b> <a class="float-right"><?= $v['sts'] ?></a>
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