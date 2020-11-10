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
      <a href="access/management" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?= $total_roles ?></h3>
        <p>Roles</p>
      </div>
      <div class="icon">
        <i class="fas fa-cog"></i>
      </div>
      <a href="access/setting" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?= $total_register ?></h3>
        <p>New Register</p>
      </div>
      <div class="icon">
        <i class="fas fa-user-plus"></i>
      </div>
      <a href="access/setting" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

</div>

<div class="row">
  <?php foreach ($list as $v) : ?>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-gray elevation-1"><i class="fas fa-cog"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><?= ucfirst($v['rolename']) ?></span>
          <span class="info-box-number">
            <?= ucfirst($v['count']) ?>
            <small>User</small>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  <?php endforeach ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>