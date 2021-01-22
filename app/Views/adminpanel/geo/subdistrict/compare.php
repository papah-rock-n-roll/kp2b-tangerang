<?= $this->extend('partials/index') ?>

<?= $this->section('link') ?>
<?= \App\Libraries\Link::style()->select2 ?>
<?= \App\Libraries\Link::style()->select2bootstrap ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-12">

<div class="card">
<?php echo form_open($action) ?>
  <div class="card-header">
    <h5 class="card-title"><i class="fas fa-upload"></i> Import - <?= $v['filename'] ?></h5>
    <div class="card-tools">
    <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i>
    </button>
    </div>
  </div>
  <div class="card-body text-sm">

    <div class="row">
      <div class="col-lg-6">
        <div class="form-group">
          <label for="">Fields DBF</label>
          <?php 
          $dbf_fields = [
            'class' => 'form-control',
            'cols' => '3',
            'rows' => '6',
            'value' => 'Type Shape : '. $v['type_shape'] ."\n". $v['str_fields'],
          ];
          echo form_textarea($dbf_fields);
          ?>
          <?php 
          $path = [
            'type' => 'hidden',
            'class' => 'form-control',
            'name' => 'path',
            'placeholder' => 'Enter Path',
            'minlength' => '3',
            'value' => old('path') == null ? $v['path'] : old('path'),
            'required' => ''
          ];
          echo form_input($path);
          ?>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="">Action</label>
          <div class="form-check">
            <input class="form-check-input" name="chk_shape" type="checkbox" value="1"
            <?= $v['chk_shape'] ? 'checked' : '' ?> >
            <label class="form-check-label">Shape</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" name="chk_dbf" type="checkbox" value="1" 
            <?= $v['chk_dbf'] ? 'checked' : '' ?> >
            <label class="form-check-label">DBF</label>
          </div>
        </div>
        <div class="alert alert-warning alert-dismissible p-3">
          <h6>Untuk mencegah <strong>Kesalahan,</strong> Ada baiknya untuk melakukan</h6>
          <p>Opsi "<strong>Export</strong>" Terlebih dahulu sebagai data backup.</p>
        </div>
      </div>
    </div>

    <div class="callout callout-info">
      <h6>Observation</h6>
    </div>

    <div class="row">
      <div class="col-lg-6"><!-- LEFT -->
        <div class="form-group">
          <label for="">FID - obscode DB</label>
          <select class="form-control custom-select select2" name="obscode" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Luas Petak Lahan - broadnrea DB</label>
          <select class="form-control custom-select select2" name="broadnrea" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Jarak Dari Sungai - distancefromriver DB</label>
          <select class="form-control custom-select select2" name="distancefromriver" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Lembaga Pengelolaan Air - wtrtreatnnst DB</label>
          <select class="form-control custom-select select2" name="wtrtreatnnst" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Intensitas Tanam - intensitynlan DB</label>
          <select class="form-control custom-select select2" name="intensitynlan" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Kelompok Tani - farmname DB</label>
          <select class="form-control custom-select select2" name="farmname" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Pemilik - ownername DB</label>
          <select class="form-control custom-select select2" name="ownername" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Responden - respname DB</label>
          <select class="form-control custom-select select2" name="respname" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Permasalahan Air - wtr DB</label>
          <select class="form-control custom-select select2" name="wtr" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Permasalahan Lainnya - other DB</label>
          <select class="form-control custom-select select2" name="other" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Panen Terbanyak - harvstmax DB</label>
          <select class="form-control custom-select select2" name="harvstmax" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Bulan Panen Terbanyak - monthmax DB</label>
          <select class="form-control custom-select select2" name="monthmax" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Penggunaan Lahan - landuse DB</label>
          <select class="form-control custom-select select2" name="landuse" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>

      </div>

      <div class="col-lg-6"><!-- RIGHT -->
        <div class="form-group">
          <label for="">Status Lahan - areantatus DB</label>
          <select class="form-control custom-select select2" name="areantatus" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Jenis Irigasi - typeirigation DB</label>
          <select class="form-control custom-select select2" name="typeirigation" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Jarak Dari Irigasi - distancefromIrgPre DB</label>
          <select class="form-control custom-select select2" name="distancefromIrgPre" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Indeks Pertanaman - indxnlant DB</label>
          <select class="form-control custom-select select2" name="indxnlant" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Pola Tanam - pattrnnlant DB</label>
          <select class="form-control custom-select select2" name="pattrnnlant" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>   
        <div class="form-group">
          <label for="">Kode Desa - vlcode DB</label>
          <select class="form-control custom-select select2" name="vlcode" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>   
        <div class="form-group">
          <label for="">Penggarap - cultivatorname DB</label>
          <select class="form-control custom-select select2" name="cultivatorname" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Permasalahan OPT - opt DB</label>
          <select class="form-control custom-select select2" name="opt" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Permasalahan Saprotan - saprotan DB</label>
          <select class="form-control custom-select select2" name="saprotan" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Penjualan Panen - harvstsell DB</label>
          <select class="form-control custom-select select2" name="harvstsell" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Panen Terkecil - harvstmin DB</label>
          <select class="form-control custom-select select2" name="harvstmin" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Bulan Panen Terkecil - monthmin DB</label>
          <select class="form-control custom-select select2" name="monthmin" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>

      </div>
    </div>

    <div class="callout callout-info">
      <h6>Plantdates</h6>
    </div>

    <div class="row">
      <div class="col-lg-6"><!-- LEFT -->
        <div class="form-group">
          <label for="">Bulan Tanam - monthgrow DB</label>
          <select class="form-control custom-select select2" name="monthgrow" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>      
        <div class="form-group">
          <label for="">Irigasi - irrigationavbl DB</label>
          <select class="form-control custom-select select2" name="irrigationavbl" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>      
      </div>

      <div class="col-lg-6"><!-- RIGHT -->
        <div class="form-group">
          <label for="">Varietas - varieties DB</label>
          <select class="form-control custom-select select2" name="varieties" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>  
        <div class="form-group">
          <label for="">Bulan Panen - monthharvest DB</label>
          <select class="form-control custom-select select2" name="monthharvest" style="width: 100%;" data-placeholder="OBJECTID">
            <?php foreach($fields as $v_field) : ?>
              <option <?= $v_field ?>><?= $v_field ?></option>
            <?php endforeach ?>
          </select>
        </div>  
      </div>
    </div>

  </div>
  <div class="card-footer">
    <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= esc($back) ?>'">Back</button>
    <button type="submit" class="btn btn-primary">Import</button>
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
<?= $this->endSection() ?>