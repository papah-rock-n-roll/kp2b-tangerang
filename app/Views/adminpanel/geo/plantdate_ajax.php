<?php
  $attributes = ['id' => 'plantform'];
  echo form_open($action, $attributes)
?>

<div class="overlay justify-content-center align-items-center" style="display: none;">
  <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
    <span class="sr-only">Loading...</span>
  </div>
</div>

<div class="modal-header">
  <h5 class="modal-title">Ubah kalender tanam petak: <strong><?= $kodepetak ?></strong></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
</div>

<div class="modal-body">

  <?php if(empty($newlist)) : ?>

    <div class="callout callout-warning mb-0">
      <h6>Silahkan isi Nilai Index Plantation "IP" terlebih dahulu</h6>
    </div>

  <?php else : ?>

      <div class="card mb-0">

        <div class="card-header d-flex p-0">
          <h5 class="card-title p-3"><i class="fas fa-tags"></i>
            <span class="badge badge-warning"> IP Baru - <?= $idxbaru ?> </span>
          </h5>
          <ul class="nav nav-pills ml-auto p-2">
            <?php $no = 1 ?>
            <?php for ($i = 0; $i < count($newlist); $i++) : ?>
              <li class="nav-item"><a class="nav-link <?= $i == 0 ? 'active' : '' ?>" href="#tab_<?= $i ?>" data-toggle="tab">IP <?= $no ?></a></li>
              <?php $no++ ?>
            <?php endfor ?>
          </ul>
        </div>

        <div class="card-body">
          <div class="tab-content">
            <?php foreach ($newlist as $k => $v) : ?>
              <div class="tab-pane <?= $k == 0 ? 'active' : '' ?>" id="tab_<?= $k ?>">

                <div class="row">
                  <div class="col-md-6">

                    <div class="form-group">
                      <label for="">Musim</label>
                      <?php
                      $growceason_ = [
                        'class' => 'form-control form-control-sm',
                        'type' => 'number',
                        'min' => '1',
                        'max' => '5',
                        'name' => 'growceason[]',
                        'minlength' => '1',
                        'placeholder' => 'Enter musim',
                        'value' => $v['growceason'],
                        'required' => ''
                      ];
                      echo form_input($growceason_);
                      ?>
                    </div>

                    <div class="form-group">
                      <label for="">Bulan Tanam</label>
                      <?php $status = $v['monthgrow'] ?>
                      <select class="custom-select form-control form-control-sm select2" name="monthgrow[]" style="width: 100%;" required>
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
                    </div>

                    <div class="form-group">
                      <label for="">Bulan Panen</label>
                      <?php $status = $v['monthharvest'] ?>
                      <select class="custom-select form-control form-control-sm select2" name="monthharvest[]" style="width: 100%;" required>
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
                    </div>

                  </div>
                  <div class="col-md-6">

                    <div class="form-group">
                      <label for="">Varietas</label>
                      <?php
                      $varieties_ = [
                        'class' => 'form-control form-control-sm',
                        'type' => 'input',
                        'minlength' => '1',
                        'name' => 'varieties[]',
                        'placeholder' => 'Enter Varietas',
                        'value' => $v['varieties']
                      ];
                      echo form_input($varieties_);
                      ?>
                    </div>

                    <div class="form-group">
                      <label for="">Irigasi</label>
                      <select name="irrigationavbl[]" class="custom-select form-control form-control-sm select2" style="width: 100%;">
                        <option value="">Pilih Irigasi</option>
                        <?php $status = $v['irrigationavbl'] ?>
                        <option <?= $status == 'ADA' ? 'selected' : '' ?> value="ADA">ADA</option>
                        <option <?= $status == 'TIDAK' ? 'selected' : '' ?> value="TIDAK">TIDAK</option>
                      </select>
                    </div>

                  </div>
                </div>

              </div>
            <?php endforeach ?>
          </div>
        </div>

      </div>

  <?php endif ?>

</div>

<div class="modal-footer justify-content-between">
  <?php if(!empty($newlist)) : ?>
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
  <?php endif ?>
</div>

<?php echo form_close() ?>
