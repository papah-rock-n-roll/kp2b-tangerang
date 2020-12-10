<?= $this->extend('partials/index') ?>
<?= $this->section('link') ?>
<?= \App\Libraries\Link::style()->select2 ?>
<?= \App\Libraries\Link::style()->select2bootstrap ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-12">

<div class="card">
  <div class="card-header">
    <h5 class="card-title">Tambah data Poktan</h5>
  </div>

  <?php echo form_open($action) ?>
  <div class="card-body">

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="">Nama ketua Poktan</label>
          <?php
          $farmhead = [
            'type' => 'text',
            'class' => $validation->hasError('farmhead') ? 'form-control is-invalid' : 'form-control form-control-sm',
            'name' => 'farmhead',
            'placeholder' => 'Masukkan nama ketua poktan',
            'minlength' => '1',
            'value' => old('farmhead') == null ? '' : old('farmhead'),
            'required' => ''
          ];
          echo form_input($farmhead);
          ?>
          <div class="invalid-feedback">
            <?= $validation->getError('farmhead') ?>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="">No kontak ketua Poktan</label>
            <?php
            $farmmobile = [
              'type' => 'text',
              'class' => $validation->hasError('farmmobile') ? 'form-control is-invalid' : 'form-control form-control-sm',
              'name' => 'farmmobile',
              'placeholder' => 'Masukkan no kontak ketua poktan',
              'minlength' => '1',
              'value' => old('farmmobile') == null ? '' : old('farmmobile'),
              'required' => ''
            ];
            echo form_input($farmmobile);
            ?>
            <div class="invalid-feedback">
              <?= $validation->getError('farmmobile') ?>
            </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="">Nama Poktan</label>
          <?php
          $farmname = [
            'type' => 'text',
            'class' => $validation->hasError('farmname') ? 'form-control is-invalid' : 'form-control form-control-sm',
            'name' => 'farmname',
            'placeholder' => 'Masukkan nama Poktan',
            'minlength' => '1',
            'value' => old('farmname') == null ? '' : old('farmname'),
            'required' => ''
          ];
          echo form_input($farmname);
          ?>
          <div class="invalid-feedback">
            <?= $validation->getError('farmname') ?>
          </div>
        </div>
      </div>
    </div>

    <div class="callout callout-success">
      <h5>Definisi Nilai Awal Poktan</h5>
    </div>

    <div class="row"><!-- Default Value -->

      <div class="col-md-6"><!-- LEFT col-md-6 -->
        <div class="form-group">
          <label for="">Jenis Irigasi</label>
          <?php $valid = $validation->hasError('typeirigation') ? 'form-control is-invalid' : 'form-control form-control-sm' ?>
          <select class="<?= $valid ?> select2-multi" name="typeirigation[]" style="width: 100%;" multiple="multiple" data-placeholder="Select Module">
            <?php foreach($typeirigation as $k_irig => $v_irig) : ?>
              <option <?= $v_irig ?>><?= $k_irig ?></option>
            <?php endforeach ?>
          </select>
          <div class="invalid-feedback">
            <?= $validation->getError('typeirigation') ?>
          </div>
        </div>

        <div class="form-group">
          <label for="">Intensitas Tanam</label>
          <select class="form-control select2-input" name="intensitynlan" style="width: 100%;">
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
          <label for="">Indeks Pertanaman</label>
          <?php
          $indxnlant = [
            'class' => $validation->hasError('indxnlant') ? 'form-control is-invalid' : 'form-control form-control-sm',
            'type' => 'number',
            'name' => 'indxnlant',
            'min' => '100',
            'max' => '500',
            'placeholder' => 'IP',
            'value' => old('indxnlant')
          ];
          echo form_input($indxnlant);
          ?>
          <div class="invalid-feedback">
            <?= $validation->getError('indxnlant') ?>
          </div>
        </div>
        
        <div class="form-group">
          <label for="">Pola Tanam</label>
          <?php
          $pattrnnlant = [
            'class' => $validation->hasError('pattrnnlant') ? 'form-control is-invalid' : 'form-control form-control-sm',
            'type' => 'input',
            'name' => 'pattrnnlant',
            'minlength' => '1',
            'placeholder' => 'Pola',
            'value' => old('pattrnnlant')
          ];
          echo form_input($pattrnnlant);
          ?>
          <div class="invalid-feedback">
          <?= $validation->getError('pattrnnlant') ?>
          </div>
        </div>
      </div>

      <div class="col-md-6"><!-- RIGHT col-md-6 -->
        <div class="form-group">
          <label for="">Permasalahan OPT</label>
          <?php $valid = $validation->hasError('opt') ? 'form-control is-invalid' : 'form-control form-control-sm' ?>
          <select class="<?= $valid ?> select2-multi" name="opt[]" style="width: 100%;" multiple="multiple" data-placeholder="Select Module">
            <?php foreach($opt as $k_opt => $v_opt) : ?>
              <option <?= $v_opt ?>><?= $k_opt ?></option>
            <?php endforeach ?>
          </select>
          <div class="invalid-feedback">
          <?= $validation->getError('opt') ?>
          </div>
        </div>

        <div class="form-group">
          <label for="">Permasalahan Air</label>
          <?php
          $wtr = [
            'class' => $validation->hasError('wtr') ? 'form-control is-invalid' : 'form-control form-control-sm',
            'type' => 'input',
            'name' => 'wtr',
            'minlength' => '1',
            'placeholder' => 'Enter..',
            'value' => old('wtr')
          ];
          echo form_input($wtr);
          ?>
          <div class="invalid-feedback">
          <?= $validation->getError('wtr') ?>
          </div>
        </div>

        <div class="form-group">
          <label for="">Permasalahan Saprotan</label>
          <?php $valid = $validation->hasError('saprotan') ? 'form-control is-invalid' : 'form-control form-control-sm' ?>
          <select class="<?= $valid ?> select2-multi" name="saprotan[]" style="width: 100%;" multiple="multiple" data-placeholder="Select Module">
            <?php foreach($saprotan as $k_sap => $v_sap) : ?>
              <option <?= $v_sap ?>><?= $k_sap ?></option>
            <?php endforeach ?>
          </select>
          <div class="invalid-feedback">
            <?= $validation->getError('saprotan') ?>
          </div>
        </div>
      </div>

    </div>

  </div>
  <div class="card-footer">
    <button type="button" class="btn btn-sm btn-secondary" onclick="window.location.href='<?= esc($back) ?>'">Back</button>
    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
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
