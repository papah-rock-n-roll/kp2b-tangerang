<?= $this->extend('partials/index') ?>
<?= $this->section('link') ?>
<?= \App\Libraries\Link::style()->select2 ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Update Observation</h5>
      </div>

      <?php echo form_open($action) ?>
      <div class="card-body">

        <div class="row">
          <div class="col-md-6"><!-- LEFT col-md-6 -->

          <div class="form-group">
              <label for="">Owner</label>
              <?php
              $selected = old('ownerid') == null ? $v['ownerid'] : old('ownerid');
              echo form_dropdown('ownerid', $owners, $selected, ['class' => 'custom-select select2', 'required' => '']);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('ownerid') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Cultivator</label>
              <?php
              $selected = old('cultivatorid') == null ? $v['cultivatorid'] : old('cultivatorid');
              echo form_dropdown('cultivatorid', $cultivators, $selected, ['class' => 'custom-select select2', 'required' => '']);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('cultivatorid') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Farmer</label>
              <?php
              $selected = old('farmcode') == null ? $v['farmcode'] : old('farmcode');
              echo form_dropdown('farmcode', $farms, $selected, ['class' => 'custom-select select2', 'required' => '']);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('farmcode') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Area Status</label>
              <?php $status = old('areantatus') == null ? $v['areantatus'] : old('areantatus') ?>
              <select class="form-control select2-input" name="areantatus" required>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >MILIK</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >SEWA</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >GARAP</option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('areantatus') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Broad Area</label>
              <div class="input-group">
                <?php
                $broadnrea = [
                  'class' => $validation->hasError('broadnrea') ? 'form-control is-invalid' : 'form-control',
                  'type' => 'numeric',
                  'name' => 'broadnrea',
                  'minlength' => '1',
                  'placeholder' => 'Area in meter square',
                  'value' => old('broadnrea') == null ? $v['broadnrea'] : old('broadnrea'),
                  'required' => ''
                ];
                echo form_input($broadnrea);
                ?>
                <div class="input-group-append">
                  <span class="input-group-text">m2</span>
                </div>
              </div>
              <div class="invalid-feedback">
                <?= $validation->getError('broadnrea') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Area Status</label>
              <?php $status = old('typeirigation') == null ? $v['typeirigation'] : old('typeirigation') ?>
              <select class="form-control select2-input" name="typeirigation" required>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >SUNGAI</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >PRIMER</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >SEKUNDER</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >TERSIER</option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('typeirigation') ?>
              </div>
            </div>
            
            <div class="form-group">
              <label for="">Distance From River</label>
              <div class="input-group">
                <?php
                $distancefromriver = [
                  'class' => $validation->hasError('distancefromriver') ? 'form-control is-invalid' : 'form-control',
                  'type' => 'input',
                  'inputmode' => 'decimal',
                  'name' => 'distancefromriver',
                  'minlength' => '1',
                  'placeholder' => 'Distance in meter - decimal',
                  'value' => old('distancefromriver') == null ? $v['distancefromriver'] : old('distancefromriver'),
                  'required' => ''
                ];
                echo form_input($distancefromriver);
                ?>
                <div class="input-group-append">
                  <span class="input-group-text">m</span>
                </div>
              </div>
              <div class="invalid-feedback">
                <?= $validation->getError('distancefromriver') ?>
              </div>
            </div>
            
            <div class="form-group">
              <label for="">Distance From Irigation</label>
              <div class="input-group">
                <?php
                $distancefromIrgPre = [
                  'class' => $validation->hasError('distancefromIrgPre') ? 'form-control is-invalid' : 'form-control',
                  'type' => 'input',
                  'inputmode' => 'decimal',
                  'name' => 'distancefromIrgPre',
                  'minlength' => '1',
                  'placeholder' => 'Distance in meter - decimal',
                  'value' => old('distancefromIrgPre') == null ? $v['distancefromIrgPre'] : old('distancefromIrgPre'),
                  'required' => ''
                ];
                echo form_input($distancefromIrgPre);
                ?>
                <div class="input-group-append">
                  <span class="input-group-text">m</span>
                </div>
              </div>
              <div class="invalid-feedback">
                <?= $validation->getError('distancefromIrgPre') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Intensity Land</label>
              <?php $status = old('intensitynlan') == null ? $v['intensitynlan'] : old('intensitynlan') ?>
              <select class="form-control select2-input" name="intensitynlan" required>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >1</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >2</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >2.5</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >3</option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('intensitynlan') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Index Plantations</label>
              <?php
              $indxnlant = [
                'class' => $validation->hasError('indxnlant') ? 'form-control is-invalid' : 'form-control',
                'type' => 'number',
                'name' => 'indxnlant',
                'min' => '1',
                'placeholder' => 'Index',
                'value' => old('indxnlant') == null ? $v['indxnlant'] : old('indxnlant'),
                'required' => ''
              ];
              echo form_input($indxnlant);
              ?>
              <div class="invalid-feedback">
              <?= $validation->getError('indxnlant') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Pattern Plantations</label>
              <?php
              $pattrnnlant = [
                'class' => $validation->hasError('pattrnnlant') ? 'form-control is-invalid' : 'form-control',
                'name' => 'pattrnnlant',
                'minlength' => '1',
                'placeholder' => 'Pattern',
                'value' => old('pattrnnlant') == null ? $v['pattrnnlant'] : old('pattrnnlant'),
                'required' => ''
              ];
              echo form_input($pattrnnlant);
              ?>
              <div class="invalid-feedback">
              <?= $validation->getError('pattrnnlant') ?>
              </div>
            </div>

          </div><!-- col-md-6 -->

          <div class="col-md-6"><!-- RIGHT col-md-6 -->

            <div class="form-group">
              <label for="">Responden</label>
              <?php
              $selected = old('respid') == null ? '' : old('respid');
              echo form_dropdown('respid', $respondens, $selected, ['class' => 'custom-select select2', 'required' => '']);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('respid') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Relate Production OPT</label>
              <?php $valid = $validation->hasError('opt') ? 'form-control is-invalid' : 'form-control' ?>
              <select class="<?= $valid ?> select2-multi" name="opt[]" multiple="multiple" data-placeholder="Select Module">
                <?php foreach($v['opt'] as $k_opt => $v_opt) : ?>
                  <option <?= $v_opt ?>><?= $k_opt ?></option>
                <?php endforeach ?>
              </select>
              <div class="invalid-feedback">
              <?= $validation->getError('opt') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Relate Production Air</label>
              <?php 
              $wtr = [
                'class' => $validation->hasError('wtr') ? 'form-control is-invalid' : 'form-control',
                'type' => 'input',
                'name' => 'wtr',
                'minlength' => '1',
                'placeholder' => 'Enter..',
                'value' => old('wtr') == null ? $v['wtr'] : old('wtr'),
                'required' => ''
              ];
              echo form_input($wtr);
              ?>
              <div class="invalid-feedback">
              <?= $validation->getError('wtr') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Relate Production Saprotan</label>
              <?php $valid = $validation->hasError('saprotan') ? 'form-control is-invalid' : 'form-control' ?>
              <select class="<?= $valid ?> select2-multi" name="saprotan[]" multiple="multiple" data-placeholder="Select Module">
                <?php foreach($v['saprotan'] as $k_sap => $v_sap) : ?>
                  <option <?= $v_sap ?>><?= $k_sap ?></option>
                <?php endforeach ?>
              </select>
              <div class="invalid-feedback">
              <?= $validation->getError('saprotan') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Other</label>
              <?php
              $other = [
                'class' => $validation->hasError('other') ? 'form-control is-invalid' : 'form-control',
                'type' => 'input',
                'name' => 'other',
                'minlength' => '1',
                'placeholder' => 'Enter..',
                'value' => old('other') == null ? $v['other'] : old('other'),
                'required' => ''
              ];
              echo form_input($other);
              ?>
              <div class="invalid-feedback">
              <?= $validation->getError('other') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Harvest Max</label>
              <?php
              $harvstmax = [
                'class' => $validation->hasError('harvstmax') ? 'form-control is-invalid' : 'form-control',
                'type' => 'input',
                'inputmode' => 'decimal',
                'name' => 'harvstmax',
                'minlength' => '1',
                'placeholder' => 'Enter Decimal..',
                'value' => old('harvstmax') == null ? $v['harvstmax'] : old('harvstmax'),
                'required' => ''
              ];
              echo form_input($harvstmax);
              ?>
              <div class="invalid-feedback">
              <?= $validation->getError('harvstmax') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Month Max</label>
              <?php $status = old('monthmax') == null ? $v['monthmax'] : old('monthmax') ?>
              <select class="form-control select2" name="monthmax" required>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >JANUARI</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >FEBRUARI</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >MARET</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >APRIL</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >MEI</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >JUNI</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >JULI</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >AGUSTUS</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >SEPTEMBER</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >OKTOBER</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >NOVEMBER</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >DESEMBER</option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('monthmax') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Harvest Min</label>
              <?php
              $harvstmin = [
                'class' => $validation->hasError('harvstmin') ? 'form-control is-invalid' : 'form-control',
                'type' => 'input',
                'inputmode' => 'decimal',
                'name' => 'harvstmin',
                'minlength' => '1',
                'placeholder' => 'Enter Decimal..',
                'value' => old('harvstmin') == null ? $v['harvstmin'] : old('harvstmin'),
                'required' => ''
              ];
              echo form_input($harvstmin);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('harvstmin') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Month Min</label>
              <?php $status = old('monthmin') == null ? $v['monthmin'] : old('monthmin') ?>
              <select class="form-control select2" name="monthmin" required>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >JANUARI</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >FEBRUARI</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >MARET</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >APRIL</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >MEI</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >JUNI</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >JULI</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >AGUSTUS</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >SEPTEMBER</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >OKTOBER</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >NOVEMBER</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >DESEMBER</option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('monthmin') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Harvest Sell</label>
              <?php $status = old('harvstsell') == null ? $v['harvstsell'] : old('harvstsell') ?>
              <select class="form-control select2-input" name="harvstsell" required>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >TIDAK DIJUAL</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >PASAR</option>
                <option <?= $status == 'Active' ? 'selected' : '' ?> >TENGKULAK</option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('harvstsell') ?>
              </div>
            </div>
            
          </div><!-- RIGHT col-md-6 -->
        </div><!-- ROW -->

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

  $(".select2-input").select2({
    tags: true
  });

  $(".select2-multi").select2({
    tags: true
  });

</script>

<?php
if(! empty(session()->getFlashdata('success'))) {
  $toast = [
  'class' => 'bg-success',
  'autohide' => 'true',
  'delay' => '5000',
  'title' => 'Update',
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