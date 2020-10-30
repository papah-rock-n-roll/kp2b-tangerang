<?= $this->extend('partials/index') ?>
<?= $this->section('link') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?= $total_users ?></h3>
        <p>Users</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?= $total_administrator ?></h3>
        <p>Administrator</p>
      </div>
      <div class="icon">
        <i class="fas fa-user-ninja"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?= $total_user ?></h3>
        <p>User</p>
      </div>
      <div class="icon">
        <i class="fa fa-user-tie"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?= $total_surveyor ?></h3>
        <p>Surveyor</p>
      </div>
      <div class="icon">
        <i class="fas fa-user-secret"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>