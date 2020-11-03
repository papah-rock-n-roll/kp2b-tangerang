<?= $this->extend('partials/index') ?>
<?= $this->section('link') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">

  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?= $total_observations ?></h3>
        <p>Petak Survey</p>
      </div>
      <div class="icon">
        <i class="fas fa-search"></i>
      </div>
      <a href="data/petak" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?= $total_owners ?></h3>
        <p>Pemilik</p>
      </div>
      <div class="icon">
        <i class="fas fa-user-friends"></i>
      </div>
      <a href="data/tuan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?= $total_cultivators ?></h3>
        <p>Penggarap</p>
      </div>
      <div class="icon">
        <i class="fas fa-user-friends"></i>
      </div>
      <a href="data/tuan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?= $total_farm ?></h3>
        <p>Poktan</p>
      </div>
      <div class="icon">
        <i class="fas fa-tractor"></i>
      </div>
      <a href="data/poktan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>