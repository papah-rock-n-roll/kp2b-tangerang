
<div class="row">
  <div class="col-md-6">

    <div class="form-group">
      <label for="">Musim</label>
      <?php
      $growceason_ = [
        'class' => $validation->hasError('growceason') ? 'form-control form-control-sm is-invalid' : 'form-control form-control-sm',
        'type' => 'number',
        'min' => '1',
        'max' => '5',
        'name' => 'growceason[]',
        'minlength' => '1',
        'placeholder' => 'Enter musim',
        'value' => old('growceason') == null ? esc($growceason) : old('growceason'),
        'required' => ''
      ];
      echo form_input($growceason_);
      ?>
      <div class="invalid-feedback">
      <?= $validation->getError('growceason') ?>
      </div>
    </div>

    <div class="form-group">
      <label for="">Bulan Tanam</label>
      <?php $status = old('monthgrow') == null ? $monthgrow : old('monthgrow') ?>
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
      <div class="invalid-feedback">
      <?= $validation->getError('monthgrow') ?>
      </div>
    </div>

    <div class="form-group">
      <label for="">Bulan Panen</label>
      <?php $status = old('monthharvest') == null ? $monthharvest : old('monthharvest') ?>
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
      <div class="invalid-feedback">
      <?= $validation->getError('monthharvest') ?>
      </div>
    </div>

  </div>

  <div class="col-md-6">

    <div class="form-group">
      <label for="">Varietas</label>
      <?php
      $varieties_ = [
        'class' => $validation->hasError('varieties') ? 'form-control form-control-sm is-invalid' : 'form-control form-control-sm',
        'type' => 'input',
        'minlength' => '1',
        'name' => 'varieties[]',
        'placeholder' => 'Enter Varietas',
        'value' => old('varieties') == null ? $varieties : old('varieties')
      ];
      echo form_input($varieties_);
      ?>
      <div class="invalid-feedback">
      <?= $validation->getError('varieties') ?>
      </div>
    </div>

    <div class="form-group">
      <label for="">Irigasi</label>
      <select name="irrigationavbl[]" class="custom-select form-control form-control-sm select2" required>
        <option value="">Pilih Irigasi</option>
        <?php $status = old('irrigationavbl') == null ? $irrigationavbl : old('irrigationavbl') ?>
        <option <?= $status == 'ADA' ? 'selected' : '' ?> value="ADA">ADA</option>
        <option <?= $status == 'TIDAK' ? 'selected' : '' ?> value="TIDAK">TIDAK</option>
      </select>
      <div class="invalid-feedback">
      <?= $validation->getError('irrigationavbl') ?>
      </div>
    </div>

  </div>
</div>
