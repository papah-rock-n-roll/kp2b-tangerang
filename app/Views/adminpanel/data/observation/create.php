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
        <h5 class="card-title">Create Petak</h5>
      </div>

      <?php echo form_open($action) ?>
      <div class="card-body">

        <div class="row">
          <div class="col-md-6"><!-- LEFT col-md-6 -->

            <div class="form-group">
              <label for="">Pemilik</label>
              <?php
              $selected = old('ownerid') == null ? '' : old('ownerid');
              echo form_dropdown('ownerid', 'Pilih pemilik', $selected, ['class' => 'custom-select select2-owner', 'style' => 'width: 100%;', 'required' => '']);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('ownerid') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Penggarap</label>
              <?php
              $selected = old('cultivatorid') == null ? '' : old('cultivatorid');
              echo form_dropdown('cultivatorid', $cultivators, $selected, ['class' => 'custom-select select2', 'style' => 'width: 100%;', 'required' => '']);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('cultivatorid') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Kelompok Tani</label>
              <?php
              $selected = old('farmcode') == null ? '' : old('farmcode');
              echo form_dropdown('farmcode', $farms, $selected, ['class' => 'custom-select select2', 'style' => 'width: 100%;', 'required' => '']);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('farmcode') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Status Lahan</label>
              <select class="form-control select2-input" name="areantatus" style="width: 100%;" required>
                <option>MILIK</option>
                <option>SEWA</option>
                <option>GARAP</option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('areantatus') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Luas Petak Lahan</label>
              <div class="input-group">
                <?php
                $broadnrea = [
                  'class' => $validation->hasError('broadnrea') ? 'form-control is-invalid' : 'form-control',
                  'type' => 'text',
                  'inputmode' => 'decimal',
                  'pattern' => '[-+]?[0-9]*[.,]?[0-9]+',
                  'name' => 'broadnrea',
                  'min' => '1',
                  'max' => '1000000',
                  'placeholder' => 'Area meter persegi',
                  'value' => old('broadnrea'),
                  'required' => '',
                ];
                echo form_input($broadnrea);
                ?>
                <div class="input-group-append">
                  <span class="input-group-text">m<sup>2</sup></span>
                </div>
                <div class="invalid-feedback">
                  <?= $validation->getError('broadnrea') ?>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="">Jenis Irigasi</label>
              <?php $valid = $validation->hasError('typeirigation') ? 'form-control is-invalid' : 'form-control' ?>
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
              <label for="">Jarak Dari Sungai</label>
              <div class="input-group">
                <?php
                $distancefromriver = [
                  'class' => $validation->hasError('distancefromriver') ? 'form-control is-invalid' : 'form-control',
                  'type' => 'text',
                  'inputmode' => 'decimal',
                  'pattern' => '[-+]?[0-9]*[.,]?[0-9]+',
                  'name' => 'distancefromriver',
                  'min' => '1',
                  'max' => '1000000',
                  'placeholder' => 'Jarak dalam meter',
                  'value' => old('distancefromriver'),
                  'required' => ''
                ];
                echo form_input($distancefromriver);
                ?>
                <div class="input-group-append">
                  <span class="input-group-text">m</span>
                </div>
                <div class="invalid-feedback">
                  <?= $validation->getError('distancefromriver') ?>
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <label for="">Jarak Dari Irigasi</label>
              <div class="input-group">
                <?php
                $distancefromIrgPre = [
                  'class' => $validation->hasError('distancefromIrgPre') ? 'form-control is-invalid' : 'form-control',
                  'type' => 'text',
                  'inputmode' => 'decimal',
                  'pattern' => '[-+]?[0-9]*[.,]?[0-9]+',
                  'name' => 'distancefromIrgPre',
                  'min' => '1',
                  'man' => '1000000',
                  'placeholder' => 'Jarak dalam meter',
                  'value' => old('distancefromIrgPre'),
                  'required' => ''
                ];
                echo form_input($distancefromIrgPre);
                ?>
                <div class="input-group-append">
                  <span class="input-group-text">m</span>
                </div>
                <div class="invalid-feedback">
                  <?= $validation->getError('distancefromIrgPre') ?>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="">Lembaga Pengelolaan Air</label>
              <?php
              $wtrtreatnnst = [
                'class' => $validation->hasError('wtrtreatnnst') ? 'form-control is-invalid' : 'form-control',
                'type' => 'input',
                'name' => 'wtrtreatnnst',
                'minlenght' => '1',
                'placeholder' => 'Enter..',
                'value' => old('wtrtreatnnst'),
                'required' => ''
              ];
              echo form_input($wtrtreatnnst);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('wtrtreatnnst') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Intensitas Tanam</label>
              <select class="form-control select2-input" name="intensitynlan" style="width: 100%;" required>
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
                'class' => $validation->hasError('indxnlant') ? 'form-control is-invalid' : 'form-control',
                'type' => 'number',
                'name' => 'indxnlant',
                'min' => '1',
                'max' => '5',
                'placeholder' => 'IP',
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
              <label for="">Pola Tanam</label>
              <?php
              $pattrnnlant = [
                'class' => $validation->hasError('pattrnnlant') ? 'form-control is-invalid' : 'form-control',
                'type' => 'input',
                'name' => 'pattrnnlant',
                'minlength' => '1',
                'placeholder' => 'Pola',
                'value' => old('pattrnnlant'),
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
              <label for="">Desa</label>
              <?php
              $selected = old('vlcode') == null ? '' : old('vlcode');
              echo form_dropdown('vlcode', $villages, $selected, ['class' => 'custom-select select2', 'style' => 'width: 100%;', 'required' => '']);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('vlcode') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Responden</label>
              <?php
              $selected = old('respid') == null ? '' : old('respid');
              echo form_dropdown('respid', $respondens, $selected, ['class' => 'custom-select select2', 'style' => 'width: 100%;', 'required' => '']);
              ?>
              <div class="invalid-feedback">
              <?= $validation->getError('respid') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Permasalahan OPT</label>
              <?php $valid = $validation->hasError('opt') ? 'form-control is-invalid' : 'form-control' ?>
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
              <label for="">Permasalahan Saprotan</label>
              <?php $valid = $validation->hasError('saprotan') ? 'form-control is-invalid' : 'form-control' ?>
              <select class="<?= $valid ?> select2-multi" name="saprotan[]" style="width: 100%;" multiple="multiple" data-placeholder="Select Module">
                <?php foreach($saprotan as $k_sap => $v_sap) : ?>
                  <option <?= $v_sap ?>><?= $k_sap ?></option>
                <?php endforeach ?>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('saprotan') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Permasalahan Lainnya</label>
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
              <label for="">Panen Terbanyak</label>
              <?php
              $harvstmax = [
                'class' => $validation->hasError('harvstmax') ? 'form-control is-invalid' : 'form-control',
                'type' => 'text',
                'inputmode' => 'decimal',
                'pattern' => '[-+]?[0-9]*[.,]?[0-9]+',
                'name' => 'harvstmax',
                'min' => '1',
                'max' => '1000000',
                'placeholder' => 'Enter Desimal..',
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
              <label for="">Bulan Panen Terbanyak</label>
              <select class="form-control select2" name="monthmax" style="width: 100%;" required>
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
              <label for="">Panen Terkecil</label>
              <?php
              $harvstmin = [
                'class' => $validation->hasError('harvstmin') ? 'form-control is-invalid' : 'form-control',
                'type' => 'text',
                'inputmode' => 'decimal',
                'pattern' => '[-+]?[0-9]*[.,]?[0-9]+',
                'name' => 'harvstmin',
                'min' => '1',
                'max' => '1000000',
                'placeholder' => 'Enter Desimal..',
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
              <label for="">Bulan Panen Terkecil</label>
              <select class="form-control select2" name="monthmin" style="width: 100%;" required>
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
              <label for="">Penjualan Panen</label>
              <select class="form-control select2-input" name="harvstsell" style="width: 100%;" required>
                <option>TIDAK DIJUAL</option>
                <option>PASAR</option>
                <option>TENGKULAK</option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('harvstsell') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Penggunaan Lahan</label>
              <select class="form-control select2" name="landuse" style="width: 100%;" required>
                <option>Sawah</option>
                <option>Non Sawah</option>
                <option>Pemukiman</option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('landuse') ?>
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

  $(".select2-owner").select2({
    ajax: {
      url: "/api/owners",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          q: params.term,
          page: params.page
        };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;

        var items = [];
        $.each(data.results, function (k,v) {
          items.push({
            'id': v.ownerid,
            'text': v.ownername, 
            'items': {
              'ownername': v.ownername, 
              'ownernik': v.ownernik ,
              },
          });
        });

        return {
          results: items,
          pagination: {
            more: (params.page * 10) < data.total_count
          }
        };
      },
      cache: true
    },
    escapeMarkup: function (markup) { return markup; },
    minimumInputLength: 1,
    templateResult: formatData,
    templateSelection: formatDataSelection

  });
    
  function formatData (data) {
    console.log('fd',data);
    if (data.loading) return data.text;

    var markup = $(
    '<div class="clearfix">' +
      '<b class="name col"></b>' + 
      '<p class="nik col"></p>' +
    '</div>');

    markup.find(".name").append(data.items.ownername);
    markup.find(".nik").append(data.items.ownernik);

    return markup;
  }

  function formatDataSelection (data) {
    console.log('ds', data);
    return data.text ;
  }

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