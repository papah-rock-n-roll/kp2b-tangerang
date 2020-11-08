
<div class="row">
  <div class="col-md-6">

    <div class="form-group">
      <label for="">Grow Season</label>
      <?php
      $growceason_ = [
        'class' => $validation->hasError('growceason') ? 'form-control is-invalid' : 'form-control',
        'name' => 'growceason[]',
        'minlength' => '1',
        'placeholder' => 'Enter your season',
        'value' => old('growceason') == null ? $growceason : old('growceason'),
        'required' => ''
      ];
      echo form_input($growceason_);
      ?>
      <div class="invalid-feedback">
      <?= $validation->getError('growceason') ?>
      </div>
    </div>

    <div class="form-group">
      <label for="">Month Grow</label>
      <?php $status = old('monthgrow') == null ? $monthgrow : old('monthgrow') ?>
      <select class="form-control select2" name="monthgrow[]" style="width: 100%;" required>
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
      <?php $status = old('monthharvest') == null ? $monthharvest : old('monthharvest') ?>
      <select class="form-control select2" name="monthharvest[]" style="width: 100%;" required>
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
      $varieties_ = [
        'class' => $validation->hasError('varieties') ? 'form-control is-invalid' : 'form-control',
        'type' => 'varieties',
        'name' => 'varieties[]',
        'placeholder' => 'Enter variety',
        'value' => old('varieties') == null ? $varieties : old('varieties'),
        'required' => ''
      ];
      echo form_input($varieties_);
      ?>
      <div class="invalid-feedback">
      <?= $validation->getError('varieties') ?>
      </div>
    </div>

    <div class="form-group">
      <label for="">Irrigation</label>
      <select name="irrigationavbl[]" id="" class="custom-select" required>
        <option value="">Choose Irrigation</option>
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
