<?= $this->extend('partials/index') ?>
<?= $this->section('link') ?>
<?= \App\Libraries\Link::style()->select2 ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      
      <div class="card-header">
        <h5 class="card-title">Update Petak</h5>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_create">
            <i class="fas fa-file-alt"></i>
          </button>
          <?php
            $modals = [
              'id' => 'modal_create',
              'size' => 'modal-lg',
              'class' => 'bg-default',
              'title' => 'Tambah',
              ];
            echo view('adminpanel/data/observation/modals', $modals);
          ?>
        </div>
      </div>

      <?php echo form_open($action) ?>
      <div class="card-body">

        <div class="row">
          <div class="col-md-6"><!-- LEFT col-md-6 -->

            <div class="form-group">
              <label for="">Pemilik</label>
              <?php
              $ownerid = old('ownerid') == null ? $v['ownerid'] : old('ownerid');
              $ownername = old('ownername') == null ? $v['ownername'] : old('ownername');
              ?>
              <select name="ownerid" class="form-control custom-select select2-ownercultivator" style="width: 100%;" required>';
                <option value="<?= $ownerid ?>" selected="selected"><?= esc($ownername) ?></option>
              </select>
              
              <div class="invalid-feedback">
                <?= $validation->getError('ownerid') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Penggarap</label>
              <?php
              $cultivatorid = old('cultivatorid') == null ? $v['cultivatorid'] : old('cultivatorid');
              $cultivatorname = old('cultivatorname') == null ? $v['cultivatorname'] : old('cultivatorname');
              ?>
              <select name="cultivatorid" class="form-control custom-select select2-ownercultivator" style="width: 100%;" required>';
                <option value="<?= $cultivatorid ?>" selected="selected"><?= esc($cultivatorname) ?></option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('cultivatorid') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Kelompok Tani</label>
              <?php
              $farmcode = old('farmcode') == null ? $v['farmcode'] : old('farmcode');
              $farmname = old('farmname') == null ? $v['farmname'] : old('farmname');
              ?>
              <select name="farmcode" class="form-control custom-select select2-farmer" style="width: 100%;" required>';
                <option value="<?= $farmcode ?>" selected="selected"><?= esc($farmname) ?></option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('farmcode') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Status Lahan</label>
              <?php $status = old('areantatus') == null ? $v['areantatus'] : old('areantatus') ?>
              <select class="form-control select2-input" name="areantatus" style="width: 100%;" required>
                <option <?= $status == 'MILIK' ? 'selected' : '' ?> >MILIK</option>
                <option <?= $status == 'SEWA' ? 'selected' : '' ?> >SEWA</option>
                <option <?= $status == 'GARAP' ? 'selected' : '' ?> >GARAP</option>
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
                  'value' => old('broadnrea') == null ? $v['broadnrea'] : old('broadnrea'),
                  'required' => ''
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
                <?php foreach($v['typeirigation'] as $k_irig => $v_irig) : ?>
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
                  'value' => old('distancefromriver') == null ? $v['distancefromriver'] : old('distancefromriver'),
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
                  'value' => old('distancefromIrgPre') == null ? $v['distancefromIrgPre'] : old('distancefromIrgPre'),
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
                'value' => old('wtrtreatnnst') == null ? $v['wtrtreatnnst'] : old('wtrtreatnnst')
              ];
              echo form_input($wtrtreatnnst);
              ?>
              <div class="invalid-feedback">
                <?= $validation->getError('wtrtreatnnst') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Intensitas Tanam</label>
              <?php $status = old('intensitynlan') == null ? $v['intensitynlan'] : old('intensitynlan') ?>
              <select class="form-control select2-input" name="intensitynlan" style="width: 100%;" required>
                <option <?= $status == '1' ? 'selected' : '' ?> >1</option>
                <option <?= $status == '2' ? 'selected' : '' ?> >2</option>
                <option <?= $status == '2.5' ? 'selected' : '' ?> >2.5</option>
                <option <?= $status == '3' ? 'selected' : '' ?> >3</option>
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
                'min' => '100',
                'max' => '500',
                'placeholder' => 'IP',
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
              <label for="">Pola Tanam</label>
              <?php
              $pattrnnlant = [
                'class' => $validation->hasError('pattrnnlant') ? 'form-control is-invalid' : 'form-control',
                'type' => 'input',
                'name' => 'pattrnnlant',
                'minlength' => '1',
                'placeholder' => 'Pola',
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
              <label for="">Desa</label>
              <?php
              $vlcode = old('vlcode') == null ? $v['vlcode'] : old('vlcode');
              $vlname = old('vlname') == null ? $v['vlname'] : old('vlname');
              ?>
              <select name="vlcode" class="form-control custom-select select2-subdist" style="width: 100%;" required>';
                <option value="<?= $vlcode ?>" selected="selected"><?= esc($vlname) ?></option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('vlcode') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Responden</label>
              <?php
              $selected = old('respid') == null ? $v['respid'] : old('respid');
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
                <?php foreach($v['opt'] as $k_opt => $v_opt) : ?>
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
                'value' => old('wtr') == null ? $v['wtr'] : old('wtr')
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
                <?php foreach($v['saprotan'] as $k_sap => $v_sap) : ?>
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
                'value' => old('other') == null ? $v['other'] : old('other')
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
              <label for="">Bulan Panen Terbanyak</label>
              <?php $status = old('monthmax') == null ? $v['monthmax'] : old('monthmax') ?>
              <select class="form-control select2" name="monthmax" style="width: 100%;" required>
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
              <label for="">Bulan Panen Terkecil</label>
              <?php $status = old('monthmin') == null ? $v['monthmin'] : old('monthmin') ?>
              <select class="form-control select2" name="monthmin" style="width: 100%;" required>
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
                <?= $validation->getError('monthmin') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Penjualan Panen</label>
              <?php $status = old('harvstsell') == null ? $v['harvstsell'] : old('harvstsell') ?>
              <select class="form-control select2-input" name="harvstsell" style="width: 100%;" required>
                <option <?= $status == 'TIDAK DIJUAL' ? 'selected' : '' ?> >TIDAK DIJUAL</option>
                <option <?= $status == 'PASAR' ? 'selected' : '' ?> >PASAR</option>
                <option <?= $status == 'TENGKULAK' ? 'selected' : '' ?> >TENGKULAK</option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('harvstsell') ?>
              </div>
            </div>

            <div class="form-group">
              <label for="">Penggunaan Lahan</label>
              <?php $status = old('landuse') == null ? $v['landuse'] : old('landuse') ?>
              <select class="form-control select2-input" name="landuse" style="width: 100%;" required>
                <option <?= $status == 'Sawah' ? 'selected' : '' ?> >Sawah</option>
                <option <?= $status == 'Non Sawah' ? 'selected' : '' ?> >Non Sawah</option>
                <option <?= $status == 'Pemukiman' ? 'selected' : '' ?> >Pemukiman</option>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('landuse') ?>
              </div>
            </div>

          </div><!-- RIGHT col-md-6 -->
        </div><!-- ROW -->

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

  $(".select2-ownercultivator").select2({
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
    placeholder: 'Cari.. pilih',
    minimumInputLength: 1,
    templateResult: formatDataOwnerCultivator,
    templateSelection: formatDataSelection
  });

  function formatDataOwnerCultivator (data) {
    if (data.loading) return data.text;

    var markup = $(
      '<optgroup label="'+ data.items.ownername +'">' + 
        '<option class="nik"></option>' +
      '</optgroup>');

    markup.find(".nik").text(data.items.ownernik);

    return markup;
  }

  $(".select2-farmer").select2({
    ajax: {
      url: "/api/farmer",
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
            'id': v.farmcode,
            'text': v.farmname, 
            'items': {
              'farmname': v.farmname, 
              'farmhead': v.farmhead ,
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
    placeholder: 'Pilih poktan',
    minimumInputLength: 1,
    templateResult: formatDataFarmer,
    templateSelection: formatDataSelection
  });

  function formatDataFarmer(data) {
    if (data.loading) return data.text;

    var markup = $(
      '<optgroup label="'+ data.items.farmname +'">' + 
        '<option class="farmhead"></option>' +
      '</optgroup>');

    markup.find(".farmhead").text(data.items.farmhead);

    return markup;
  }

  $(".select2-subdist").select2({
    ajax: {
      url: "/api/subdist",
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
            'id': v.vlcode,
            'text': v.vlname, 
            'items': {
              'vlname': v.vlname, 
              'sdname': v.sdname ,
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
    placeholder: 'Pilih desa',
    minimumInputLength: 1,
    templateResult: formatDataSubdist,
    templateSelection: formatDataSelection
  });


  function formatDataSubdist(data) {
    if (data.loading) return data.text;

    var markup = $(
      '<optgroup label="'+ data.items.vlname +'">' + 
        '<option class="sdname"></option>' +
      '</optgroup>');

    markup.find(".sdname").text(data.items.sdname);

    return markup;
  }

  function formatDataSelection (data) {
    return data.text;
  }

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
