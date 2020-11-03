<?= $this->extend('partials/index') ?>
<?= $this->section('link') ?>
<?= \App\Libraries\Link::style()->select2 ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Create Observation</h5>
      </div>

      <?php echo form_open($action) ?>
      <div class="card-body">

        <div class="row">
          <div class="col-md-6"><!-- LEFT col-md-6 -->

            <div class="form-group">
              <label for="">Owner</label>
              <?php
              $selected = old('ownerid') == null ? '' : old('ownerid');
              echo form_dropdown('pemilik', $owners, $selected, ['class' => 'custom-select select2', 'required' => '']);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('pemilik') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Cultivator</label>
              <?php
              $selected = old('ownerid') == null ? '' : old('ownerid');
              echo form_dropdown('penggarap', $cultivators, $selected, ['class' => 'custom-select select2', 'required' => '']);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('penggarap') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Farmer</label>
              <?php
              $selected = old('farmcode') == null ? '' : old('farmcode');
              echo form_dropdown('farmcode', $farms, $selected, ['class' => 'custom-select select2', 'required' => '']);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('farmcode') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Area Status</label>
              <select class="form-control select2-input" name="areantatus" placeholder="Status" required>
                <option>MILIK</option>
                <option>SEWA</option>
                <option>GARAP</option>
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
                  'value' => old('broadnrea'),
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
              <select class="form-control select2-input" name="typeirigation" placeholder="Status" required>
                <option>SUNGAI</option>
                <option>PRIMER</option>
                <option>SEKUNDER</option>
                <option>TERSIER</option>
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
                  'value' => old('distancefromriver'),
                  'required' => ''
                ];
                echo form_input($distancefromriver);
                ?>
                <div class="input-group-append">
                  <span class="input-group-text">m</span>
                </div>
              </div>
              <div class="invalid-feedback">
                <?= $validation->getError('wtrtreatnnst') ?>
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
                  'value' => old('distancefromIrgPre'),
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
              <select class="form-control select2-input" name="intensitynlan" placeholder="Intensity" required>
                <option>1</option>
                <option>2</option>
                <option>2.5</option>
                <option>3</option>
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
                'value' => old('indxnlant'),
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
                'placeholder' => 'Index',
                'value' => old('pattrnnlant'),
                'required' => ''
              ];
              echo form_input($pattrnnlant);
              ?>
              <div class="invalid-feedback">
              <?= $validation->getError('indxnlant') ?>
              </div>
            </div>

          </div><!-- col-md-6 -->

          <div class="col-md-6"><!-- RIGHT col-md-6 -->

            <div class="form-group">
              <label for="">Responden</label>
              <?php
              $selected = old('respId') == null ? '' : old('respId');
              echo form_dropdown('respId', $respondens, $selected, ['class' => 'custom-select select2', 'required' => '']);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('respId') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Relate Production OPT</label>
              <?php
              $opt = [
                'class' => $validation->hasError('opt') ? 'form-control is-invalid' : 'form-control',
                'type' => 'opt',
                'name' => 'opt',
                'minlength' => '1',
                'placeholder' => 'Enter..',
                'value' => old('opt'),
                'required' => ''
              ];
              echo form_input($opt);
              ?>
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
                'value' => old('wtr'),
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
              <?php
              $saprotan = [
                'class' => $validation->hasError('saprotan') ? 'form-control is-invalid' : 'form-control',
                'type' => 'input',
                'name' => 'saprotan',
                'minlength' => '1',
                'placeholder' => 'Enter..',
                'value' => old('saprotan'),
                'required' => ''
              ];
              echo form_input($saprotan);
              ?>
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
                'value' => old('other'),
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
                'value' => old('harvstmax'),
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
              <select class="form-control select2" name="monthmax" placeholder="Enter.. Month" required>
                <option>JANUARI</option>
                <option>FEBRUARI</option>
                <option>MARET</option>
                <option>APRIL</option>
                <option>MEI</option>
                <option>JUNI</option>
                <option>JULI</option>
                <option>AGUSTUS</option>
                <option>SEPTEMBER</option>
                <option>OKTOBER</option>
                <option>NOVEMBER</option>
                <option>DESEMBER</option>
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
                'value' => old('harvstmin'),
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
              <select class="form-control select2" name="monthmin" placeholder="Enter.. Month" required>
                <option>JANUARI</option>
                <option>FEBRUARI</option>
                <option>MARET</option>
                <option>APRIL</option>
                <option>MEI</option>
                <option>JUNI</option>
                <option>JULI</option>
                <option>AGUSTUS</option>
                <option>SEPTEMBER</option>
                <option>OKTOBER</option>
                <option>NOVEMBER</option>
                <option>DESEMBER</option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('monthmin') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Harvest Sell</label>
              <select class="form-control select2-input" name="harvstsell" placeholder="Harvest.." required>
                <option>TIDAK DIJUAL</option>
                <option>PASAR</option>
                <option>TENGKULAK</option>
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