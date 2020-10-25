<?= $this->extend('partials/index') ?>
<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?php echo $total_transaction ?></h3>
        <p>Transactions</p>
      </div>
      <div class="icon">
        <i class="fas fa-dollar-sign"></i>
      </div>
      <a href="/transaction" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?php echo $total_product ?></h3>
        <p>Products</p>
      </div>
      <div class="icon">
        <i class="fas fa-cart-plus"></i>
      </div>
      <a href="/product" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?php echo $total_category ?></h3>
        <p>Categories</p>
      </div>
      <div class="icon">
        <i class="fa fa-tags"></i>
      </div>
      <a href="/category" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?php echo $total_user ?></h3>
        <p>Users</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Sales Graph</h5>
      </div>
      <div class="card-body">
        <?php
        $total = array();
        $month = array();

        foreach($grafik as $data) :
          $total[] = $data['total'];
          $month[] = $data['month'];
        endforeach;
        ?>
        <canvas id="chartPenjualan" width="100%" height="45"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Latest Transaction</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hovered">
            <thead>
              <tr>
              <th>No</th>
              <th>Product</th>
              <th>Date</th>
              <th>Price</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($latest_trx as $k => $v) : ?>
              <tr>
              <td><?php echo ++$k ?></td>
              <td><?php echo $v['product_name'] ?></td>
              <td><?php echo date('j F Y', strtotime($v['trx_date'])) ?></td>
              <td><?php echo "Rp. ".number_format($v['trx_price'], false, false, ".") ?></td>
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
<?php
$chart = [
  'id' => 'chartPenjualan',
  'type' => 'bar',
  'title' => 'Grafik Penjualan',
  'labels' => $month,
  'values' => $total,
  'xlabels' => 'Month',
  'ylabels' => 'Transactions',
];
echo view('events/chart', $chart); 
?>
<?= $this->endSection() ?>