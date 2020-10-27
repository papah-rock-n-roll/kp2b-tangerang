<?= $this->extend('partials/index') ?>
<?= $this->section('link') ?>
<?= \App\Libraries\Link::style()->chartjs ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?php echo $total_pemilik ?></h3>
        <p>Pemilik</p>
      </div>
      <div class="icon">
        <i class="fas fa-user-secret"></i>
      </div>
      <a href="/transaction" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?php echo $total_penggarap?></h3>
        <p>Penggarap</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <a href="/product" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?php echo $total_poktan ?></h3>
        <p>Poktan</p>
      </div>
      <div class="icon">
        <i class="fa fa-tractor"></i>
      </div>
      <a href="/category" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?php echo $total_desa ?></h3>
        <p>Desa</p>
      </div>
      <div class="icon">
        <i class="fas fa-campground"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Graph Status</h5>
      </div>
      <div class="card-body">
        <?php
          $total = array();
          $arentatus = array();

          foreach($graph as $v) :
            $total[] = $v['total'];
            $arentatus[] = $v['arentatus'];
          endforeach;
        ?>
        <canvas id="graph" width="100%" height="45"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Data Poktan</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hovered">
            <thead>
              <tr>
              <th>No</th>
              <th>Poktan</th>
              <th>Pemilik</th>
              <th>Penggarap</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($list as $k => $v) : ?>
                <tr>
                <td><?= ++$k ?></td>
                <td><?= $v['poktan'] ?></td>
                <td><?= $v['pemilik'] ?></td>
                <td><?= $v['penggarap'] ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= \App\Libraries\Link::script()->chartjs ?>

<?php
$chart = [
  'id' => 'graph',
  'type' => 'bar',
  'title' => 'Grafik Poktan',
  'labels' => $arentatus,
  'values' => $total,
  'xlabels' => 'Bulan',
  'ylabels' => 'Jumlah',
];
echo view('events/chart', $chart); 
?>
<?= $this->endSection() ?>