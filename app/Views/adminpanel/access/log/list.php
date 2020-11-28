<?= $this->extend('partials/index') ?>

<?= $this->section('link') ?>
<?= \App\Libraries\Link::style()->tempusdominus ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <?php foreach ($menu as $k => $v) : ?>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-gray elevation-1"><i class="fas fa-cog"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><?= ucfirst($v['name']) ?></span>
          <span class="info-box-number">
            <button type="button" class="tmb-delete btn btn-warning btn-sm" title="Delete - <?= esc($v['name']) ?>" data-toggle="modal" data-target="#modal_<?= $k ?>">
            <i class="fa fa-trash-alt"></i></button>
            <?php
              $modals = [
                'id' => 'modal_'.$k,
                'size' => 'modal-sm',
                'class' => 'bg-warning',
                'title' => 'Delete',
                'bodytext' => 'Anda Yakin Ingin Menghapus <br>'.esc($v['name']),
                'action' => $delete . $v['name'],
                ];
              echo view('events/modals', $modals);
            ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  <?php endforeach ?>
</div>

<div class="row">
<div class="col-lg-12">

<!-- filter -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title"><i class="fas fa-search"></i> Filter</h5>
    <div class="card-tools">
      <div class="input-group input-group-sm">
        <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse">
        <i class="fas fa-minus"></i></button>
      </div>
    </div>
  </div>
  <div class="card-body">

    <div class="row">
      
      <div class="col-md-6"><!-- LEFT col-md-6 -->
        <div class="form-group">  
          <?php echo form_dropdown('watch', $watchs, $watch, ['class' => 'custom-select', 'id' => 'watch']) ?>
        </div>
        <div class="form-group"><!-- timestamp -->      
            
          <div class="input-group date" id="timestamp" data-target-input="nearest">
            <input type="text" id="date" name="date" value="<?= $date ?>" class="form-control datetimepicker-input" data-target="#timestamp"/>
            <div class="input-group-append" data-target="#timestamp" data-toggle="datetimepicker">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
          </div>  

        </div>
      </div>

      <div class="col-md-6"><!-- RIGHT col-md-6 -->
        <div class="form-group"> 
          <?php echo form_dropdown('table', $tables, $table, ['class' => 'custom-select', 'id' => 'table']) ?>
        </div>
        <div class="form-group"><!-- keyword -->
          <div class="input-group">
            <?php
              $form_keyword = [
                'type'  => 'text',
                'class' => 'form-control',
                'name'  => 'keyword',
                'id'    => 'keyword',
                'value' => $keyword,
                'placeholder' => 'Enter username..'
              ];
            echo form_input($form_keyword);
            ?>
            <div class="input-group-append">
              <button class="btn btn btn-secondary input-group-text" id="filterSubmit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<!-- list -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title"><i class="fas fa-tags"></i> Daftar Logs</h5>
    <div class="card-tools">
      <div class="input-group input-group-sm">
        <?php
            $paginate = [
              '5' => '5',
              '10' => '10',
              '50' => '50',
              '100' => '100'
            ];
          echo form_dropdown('paginate', $paginate, $page, ['class' => 'custom-select', 'id' => 'paginate']);
        ?>
        <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover text-nowrap projects">
      <thead>
        <tr>
          <th>No</th>
          <th>User Name</th>
          <th>Watch</th>
          <th>Table</th>
          <th>DataID</th>
          <th>Timestamp</th>
          <th style="width: 5%">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php if(empty($list)) : ?>
        <tr><td colspan="7"><h3>Belum ada data</h3><p>Silahkan menambahkan data terlebih dahulu.</p></td></tr>      
      <?php else : ?>
        <?php foreach($list as $k => $v) : ?>
          <tr>
            <td><?= ++$k ?></td>
            <td><?= esc($v['name']) ?></h6></td>
            <td><b><?= esc($v['watch']) ?></b></td>
            <td><?= esc($v['table']) ?></td>
            <td><?= esc($v['dataid']) ?></td>
            <td><?= esc($v['timestamp']) ?></td>
            <td>
              <button type="button" class="tmb-read btn btn-info btn-sm" title="Read - <?= $v['logid'] ?>" onclick="window.location.href='<?= $read . $v['logid'] ?>'">
              <i class="fa fa-eye"></i></button>
            </td>
          </tr>
        <?php endforeach ?>
      <?php endif ?>
      </tbody>
      </table>
    </div>
  </div>

  <div class="card-footer clearfix">
    <div class="pagination pagination-sm m-0 float-right">
      <?= $pager->links('default', 'bootstrap-pager') ?>
    </div>
  </div>
</div>

</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= \App\Libraries\Link::script()->moment ?>
<?= \App\Libraries\Link::script()->tempusdominus ?>

<?php 
if(! empty(session()->getFlashdata('warning'))) {
  $toast = [
  'class' => 'bg-warning',
  'autohide' => 'true',
  'delay' => '10000',
  'title' => 'Delete',
  'subtitle' => '',
  'body' => session()->getFlashdata('warning'),
  'icon' => 'icon fas fa-trash-alt',
  'image' => '',
  'imageAlt' => '',
  ];
  echo view('events/toasts', $toast);
}
?>

<script type="text/javascript">

  let filter = function() {
    var watch = $("#watch").val();
    var table = $("#table").val();
    var date = $("#date").val();
    var keyword = $("#keyword").val();
    var paginate = $("#paginate").val();
    window.location.replace("?paginate="+ paginate +"&watch="+ watch +"&table="+ table +"&date="+ date +"&keyword="+ keyword);
  };
        
  $('#timestamp').datetimepicker({
    format: 'YYYY-MM-DD'
  });

  $("#timestamp").keypress(function(event) {
    if(event.keyCode == 13) {
      filter();
    }
  });

  $("#filterSubmit").click(function() {
    filter();
  });

  $("#watch").change(function() {
    filter();
  });

  $("#table").change(function() {
    filter();
  });

  $("#paginate").change(function() {
    filter();
  });

  $("#keyword").keypress(function(event) {
    if(event.keyCode == 13) {
      filter();
    }
  });

</script>
<?= $this->endSection() ?>