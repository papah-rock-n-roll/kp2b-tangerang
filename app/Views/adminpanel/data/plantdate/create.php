<?= $this->extend('partials/index') ?>

<?= $this->section('link') ?>
<?= \App\Libraries\Link::style()->select2 ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-12">

    <div class="card">
      <div class="card-header">
        <?php
          $uri = service('uri');
          $kodepetak = $uri->getSegment(5);
        ?>
        <h5 class="card-title"><i class="fas fa-search"></i> Plantdates Data - <?= $kodepetak ?></h5>
        <div class="card-tools">
          <div class="input-group-append">
            <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table projects">
          <thead>
            <tr>
              <th style="width: 5%">No</th>
              <th style="width: 25%">Grow Season</th>
              <th style="width: 20%">Month Grow</th>
              <th style="width: 20%">Month Harvest</th>
              <th style="width: 25%">Variety</th>
              <th style="width: 5%">Irrigation</th>
            </tr>
          </thead>
          <tbody>
          <?php if(empty($oldlist)) : ?>
            <tr><td colspan="6"><h3>Belum ada data</h3><p>Silahkan menambahkan data terlebih dahulu.</p></td></tr>      
          <?php else : ?>
            <?php foreach($oldlist as $k => $v) : ?>
              <tr>
                <td><?= ++$k ?></td>
                <td><?= $v['growceason'] ?></td>
                <td><?= $v['monthgrow'] ?></td>
                <td><?= $v['monthharvest'] ?></td>
                <td><?= $v['varieties'] ?></td>
                <td><?= $v['irrigationavbl'] ?></td>
              </tr>
            <?php endforeach ?>
          <?php endif ?>
          </tbody>
          </table>
        </div>
      </div>
    </div>


    <div class="card">
      <div class="card-header">
        <h5 class="card-title"><i class="fas fa-tags"></i>  Modify Plantdates Data</h5>
      </div>

      <?php echo form_open($action) ?>
      <div class="card-body">
      <?php if(empty($newlist)) : ?>
        <div class="callout callout-warning">
          <h5>Silahkan isi Nilai Index Plantation "IP" terlebih dahulu</h5>
        </div>
      <?php else : ?>
        <?php foreach ($newlist as $k => $v) : ?>

          <div class="callout callout-success">
            <h5>Index Plantation - <?= ++$k ?></h5>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Grow Season</label>
                <?php
                $growceason = [
                  'class' => $validation->hasError('growceason') ? 'form-control is-invalid' : 'form-control',
                  'name' => 'growceason[]',
                  'minlength' => '1',
                  'placeholder' => 'Enter your season',
                  'value' => old('growceason') == null ? $v['growceason'] : old('growceason'),
                  'required' => ''
                ];
                echo form_input($growceason);
                ?>
                <div class="invalid-feedback">
                <?= $validation->getError('growceason') ?>
                </div>
              </div>
              <div class="form-group">
                <label for="">Month Grow</label>
                <?php $status = old('monthgrow') == null ? $v['monthgrow'] : old('monthgrow') ?>
                <select class="form-control select2" name="monthgrow[]" required>
                  <option <?= $status == 'JANUARI' ? 'selected' : '' ?>>JANUARI</option>
                  <option <?= $status == 'FEBRUARI' ? 'selected' : '' ?>>FEBRUARI</option>
                  <option <?= $status == 'MARET' ? 'selected' : '' ?>>MARET</option>
                  <option <?= $status == 'APRIL' ? 'selected' : '' ?>>APRIL</option>
                  <option <?= $status == 'MEI' ? 'selected' : '' ?>>MEI</option>
                  <option <?= $status == 'JUNI' ? 'selected' : '' ?>>JUNI</option>
                  <option <?= $status == 'JULI' ? 'selected' : '' ?>>JULI</option>
                  <option <?= $status == 'AGUSTUS' ? 'selected' : '' ?>>AGUSTUS</option>
                  <option <?= $status == 'SEPTEMBER' ? 'selected' : '' ?>>SEPTEMBER</option>
                  <option <?= $status == 'OKTOBER' ? 'selected' : '' ?>>OKTOBER</option>
                  <option <?= $status == 'NOVEMBER' ? 'selected' : '' ?>>NOVEMBER</option>
                  <option <?= $status == 'DESEMBER' ? 'selected' : '' ?>>DESEMBER</option>
                </select>
                <div class="invalid-feedback">
                <?= $validation->getError('monthgrow') ?>
                </div>
              </div>
              <div class="form-group">
                <label for="">Month Harvest</label>
                <?php $status = old('monthharvest') == null ? $v['monthharvest'] : old('monthharvest') ?>
                <select class="form-control select2" name="monthharvest[]" required>
                  <option <?= $status == 'JANUARI' ? 'selected' : '' ?>>JANUARI</option>
                  <option <?= $status == 'FEBRUARI' ? 'selected' : '' ?>>FEBRUARI</option>
                  <option <?= $status == 'MARET' ? 'selected' : '' ?>>MARET</option>
                  <option <?= $status == 'APRIL' ? 'selected' : '' ?>>APRIL</option>
                  <option <?= $status == 'MEI' ? 'selected' : '' ?>>MEI</option>
                  <option <?= $status == 'JUNI' ? 'selected' : '' ?>>JUNI</option>
                  <option <?= $status == 'JULI' ? 'selected' : '' ?>>JULI</option>
                  <option <?= $status == 'AGUSTUS' ? 'selected' : '' ?>>AGUSTUS</option>
                  <option <?= $status == 'SEPTEMBER' ? 'selected' : '' ?>>SEPTEMBER</option>
                  <option <?= $status == 'OKTOBER' ? 'selected' : '' ?>>OKTOBER</option>
                  <option <?= $status == 'NOVEMBER' ? 'selected' : '' ?>>NOVEMBER</option>
                  <option <?= $status == 'DESEMBER' ? 'selected' : '' ?>>DESEMBER</option>
                </select>
                <div class="invalid-feedback">
                <?= $validation->getError('monthharvest') ?>
                </div>
              </div>
              
            </div>

            <div class="col-md-6">

              <div class="form-group">
                <label for="">Variety</label>
                <?php
                $varieties = [
                  'class' => $validation->hasError('varieties') ? 'form-control is-invalid' : 'form-control',
                  'type' => 'varieties',
                  'name' => 'varieties[]',
                  'placeholder' => 'Enter variety',
                  'value' => old('varieties') == null ? $v['varieties'] : old('varieties'),
                  'required' => ''
                ];
                echo form_input($varieties);
                ?>
                <div class="invalid-feedback">
                <?= $validation->getError('varieties') ?>
                </div>
              </div>
              <div class="form-group">
                <label for="">Irrigation</label>
                <select name="irrigationavbl[]" id="" class="custom-select" required>
                  <option value="">Choose Irrigation</option>
                  <?php $status = old('irrigationavbl') == null ? $v['irrigationavbl'] : old('irrigationavbl') ?>
                  <option <?= $status == 'ADA' ? 'selected' : '' ?> value="ADA">ADA</option>
                  <option <?= $status == 'TIDAK' ? 'selected' : '' ?> value="TIDAK">TIDAK</option>
                </select>
                <div class="invalid-feedback">
                <?= $validation->getError('irrigationavbl') ?>
                </div>
              </div>
            
            </div>
          </div>

        <?php endforeach ?>
      <?php endif ?>  
      
      </div>   
      <div class="card-footer">
        <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= esc($back) ?>'">Back</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>

      <?php echo form_close() ?>

    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= \App\Libraries\Link::script()->select2 ?>

<script>

  $('.select2').select2()

</script>

<?php
if(! empty(session()->getFlashdata('success'))) {
  $toast = [
  'class' => 'bg-success',
  'autohide' => 'true',
  'delay' => '5000',
  'title' => 'Create',
  'subtitle' => '',
  'body' => session()->getFlashdata('success'),
  'icon' => 'icon fas fa-file-alt',
  'image' => '',
  'imageAlt' => '',
  ];
  echo view('events/toasts', $toast);
}
?>

<?= $this->endSection() ?>