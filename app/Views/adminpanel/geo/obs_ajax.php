<?php
  $attributes = ['id' => 'obsform', 'method' => 'PUT'];
  echo form_open(base_url('api/observation/'.$v['obscode']), $attributes);
?>
<?php
  $ownerid = $v['ownerid'];
  $ownername = $v['ownername'];
  $cultivatorid = $v['cultivatorid'];
  $cultivatorname = $v['cultivatorname'];
?>

<div class="row overlay-wrapper" style="width: calc(100% - -7px);">

  <div class="overlay justify-content-center align-items-center" style="display: none;">
    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <div class="col-md-12"><!-- LEFT col-md-12 -->

    <div class="form-group">
      <label for="">Responden</label>
      <?php
      $respid = old('respid') == null ? $v['respid'] : old('respid');
      $respname = old('respname') == null ? $v['respname'] : old('respname');
      ?>
      <select name="respid" class="form-control form-control-sm custom-select select2-respo" style="width: 100%;" required>
        <option value="<?= $respid ?>" selected="selected"><?= esc($respname) ?></option>
      </select>
    </div>

    <div class="form-group">
      <label for="">Pemilik</label>
      <select name="ownerid" class="form-control form-control-sm select2-ownercultivator" style="width: 100%;" required>
        <option value="<?= $ownerid ?>" selected><?= esc($ownername) ?></option>
      </select>
    </div>

    <div class="form-group">
      <label for="">Penggarap</label>
      <select name="cultivatorid" class="form-control form-control-sm custom-select select2-ownercultivator" style="width: 100%;" required>
        <option value="<?= $cultivatorid ?>" selected="selected"><?= esc($cultivatorname) ?></option>
      </select>
    </div>

    <div class="form-group">
      <label for="">Kelompok Tani</label>
      <?php
      $farmcode = old('farmcode') == null ? $v['farmcode'] : old('farmcode');
      $farmname = old('farmname') == null ? $v['farmname'] : old('farmname');
      ?>
      <select name="farmcode" class="form-control form-control-sm custom-select select2-farmer" style="width: 100%;" required>
        <option value="<?= $farmcode ?>" selected="selected"><?= esc($farmname) ?></option>
      </select>
    </div>

    <div class="form-group">
      <label for="">Desa</label>
      <?php
      $vlcode = old('vlcode') == null ? $v['vlcode'] : old('vlcode');
      $vlname = old('vlname') == null ? $v['vlname'] : old('vlname');
      ?>
      <select name="vlcode" class="form-control form-control-sm custom-select select2-subdist" style="width: 100%;" required>
        <option value="<?= $vlcode ?>" selected="selected"><?= esc($vlname) ?></option>
      </select>
    </div>

    <div class="form-group">
      <label for="">Status Lahan</label>
      <?php $status = old('areantatus') == null ? $v['areantatus'] : old('areantatus') ?>
      <select class="form-control form-control-sm select2-input" name="areantatus" style="width: 100%;" required>
        <option <?= $status == 'MILIK' ? 'selected' : '' ?> >MILIK</option>
        <option <?= $status == 'SEWA' ? 'selected' : '' ?> >SEWA</option>
        <option <?= $status == 'GARAP' ? 'selected' : '' ?> >GARAP</option>
      </select>
    </div>

    <div class="form-group">
      <label for="">Luas Petak Lahan</label>
      <div class="input-group input-group-sm">
        <?php
        $broadnrea = [
          'class' => 'form-control',
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
      </div>
    </div>

    <div class="form-group">
      <label for="">Jenis Irigasi</label>
      <select class="form-control form-control-sm select2-multi" name="typeirigation[]" multiple="multiple" data-placeholder="Select Module" style="width: 100%;">
        <?php foreach($v['typeirigation'] as $k_irig => $v_irig) : ?>
          <option <?= $v_irig ?>><?= $k_irig ?></option>
        <?php endforeach ?>
      </select>
    </div>

    <div class="form-group">
      <label for="">Jarak Dari Sungai</label>
      <div class="input-group input-group-sm">
        <?php
        $distancefromriver = [
          'class' => 'form-control form-control-sm',
          'type' => 'text',
          'inputmode' => 'decimal',
          'pattern' => '[-+]?[0-9]*[.,]?[0-9]+',
          'name' => 'distancefromriver',
          'min' => '1',
          'max' => '1000000',
          'placeholder' => 'Jarak dalam meter',
          'value' => old('distancefromriver') == null ? $v['distancefromriver'] : old('distancefromriver')
        ];
        echo form_input($distancefromriver);
        ?>
        <div class="input-group-append">
          <span class="input-group-text">m</span>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="">Jarak Dari Irigasi</label>
      <div class="input-group input-group-sm">
        <?php
        $distancefromIrgPre = [
          'class' => 'form-control form-control-sm',
          'type' => 'text',
          'inputmode' => 'decimal',
          'pattern' => '[-+]?[0-9]*[.,]?[0-9]+',
          'name' => 'distancefromIrgPre',
          'min' => '1',
          'man' => '1000000',
          'placeholder' => 'Jarak dalam meter',
          'value' => old('distancefromIrgPre') == null ? $v['distancefromIrgPre'] : old('distancefromIrgPre')
        ];
        echo form_input($distancefromIrgPre);
        ?>
        <div class="input-group-append">
          <span class="input-group-text">m</span>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="">Lembaga Pengelolaan Air</label>
      <?php
      $wtrtreatnnst = [
        'class' => 'form-control form-control-sm',
        'type' => 'input',
        'name' => 'wtrtreatnnst',
        'minlenght' => '1',
        'placeholder' => 'Enter..',
        'value' => old('wtrtreatnnst') == null ? $v['wtrtreatnnst'] : old('wtrtreatnnst')
      ];
      echo form_input($wtrtreatnnst);
      ?>
    </div>

    <div class="form-group">
      <label for="">Intensitas Tanam</label>
      <?php $status = old('intensitynlan') == null ? $v['intensitynlan'] : old('intensitynlan') ?>
      <select class="form-control form-control-sm select2-input" name="intensitynlan" style="width: 100%;" required>
        <option <?= $status == '1' ? 'selected' : '' ?> >1</option>
        <option <?= $status == '2' ? 'selected' : '' ?> >2</option>
        <option <?= $status == '2.5' ? 'selected' : '' ?> >2.5</option>
        <option <?= $status == '3' ? 'selected' : '' ?> >3</option>
      </select>
    </div>

    <div class="form-group">
      <label for="">Indeks Pertanaman</label>
      <?php
      $indxnlant = [
        'class' => 'form-control form-control-sm',
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
    </div>

    <div class="form-group">
      <label for="">Pola Tanam</label>
      <?php
      $pattrnnlant = [
        'class' => 'form-control form-control-sm',
        'type' => 'input',
        'name' => 'pattrnnlant',
        'minlength' => '1',
        'placeholder' => 'Pola',
        'value' => old('pattrnnlant') == null ? $v['pattrnnlant'] : old('pattrnnlant')
      ];
      echo form_input($pattrnnlant);
      ?>
    </div>

    <div class="form-group">
      <label for="">Permasalahan OPT</label>
      <select class="form-control form-control-sm select2-multi" name="opt[]" multiple="multiple" data-placeholder="Select Module" style="width: 100%;">
        <?php foreach($v['opt'] as $k_opt => $v_opt) : ?>
          <option <?= $v_opt ?>><?= $k_opt ?></option>
        <?php endforeach ?>
      </select>
    </div>

    <div class="form-group">
      <label for="">Permasalahan Air</label>
      <?php
      $wtr = [
        'class' => 'form-control form-control-sm',
        'type' => 'input',
        'name' => 'wtr',
        'minlength' => '1',
        'placeholder' => 'Enter..',
        'value' => old('wtr') == null ? $v['wtr'] : old('wtr')
      ];
      echo form_input($wtr);
      ?>
    </div>

    <div class="form-group">
      <label for="">Permasalahan Saprotan</label>
      <select class="form-control form-control-sm select2-multi" name="saprotan[]" multiple="multiple" data-placeholder="Select Module" style="width: 100%;">
        <?php foreach($v['saprotan'] as $k_sap => $v_sap) : ?>
          <option <?= $v_sap ?>><?= $k_sap ?></option>
        <?php endforeach ?>
      </select>
    </div>

    <div class="form-group">
      <label for="">Permasalahan Lainnya</label>
      <?php
      $other = [
        'class' => 'form-control form-control-sm',
        'type' => 'input',
        'name' => 'other',
        'minlength' => '1',
        'placeholder' => 'Enter..',
        'value' => old('other') == null ? $v['other'] : old('other')
      ];
      echo form_input($other);
      ?>
    </div>

    <div class="form-group">
      <label for="">Panen Terbanyak</label>
      <div class="input-group input-group-sm">
        <?php
        $harvstmax = [
          'class' => 'form-control form-control-sm',
          'type' => 'text',
          'inputmode' => 'decimal',
          'pattern' => '[-+]?[0-9]*[.,]?[0-9]+',
          'name' => 'harvstmax',
          'min' => '1',
          'max' => '1000000',
          'placeholder' => 'Enter Desimal..',
          'value' => old('harvstmax') == null ? $v['harvstmax'] : old('harvstmax')
        ];
        echo form_input($harvstmax);
        ?>
        <div class="input-group-append">
          <span class="input-group-text">kwintal</span>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="">Bulan Panen Terbanyak</label>
      <?php $status = old('monthmax') == null ? $v['monthmax'] : old('monthmax') ?>
      <select class="form-control form-control-sm select2" name="monthmax" style="width: 100%;" required>
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
      <label for="">Panen Terkecil</label>
      <div class="input-group input-group-sm">
        <?php
        $harvstmin = [
          'class' => 'form-control form-control-sm',
          'type' => 'text',
          'inputmode' => 'decimal',
          'pattern' => '[-+]?[0-9]*[.,]?[0-9]+',
          'name' => 'harvstmin',
          'min' => '1',
          'max' => '1000000',
          'placeholder' => 'Enter Desimal..',
          'value' => old('harvstmin') == null ? $v['harvstmin'] : old('harvstmin')
        ];
        echo form_input($harvstmin);
        ?>
        <div class="input-group-append">
          <span class="input-group-text">kwintal</span>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="">Bulan Panen Terkecil</label>
      <?php $status = old('monthmin') == null ? $v['monthmin'] : old('monthmin') ?>
      <select class="form-control form-control-sm select2" name="monthmin" style="width: 100%;" required>
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
      <label for="">Penjualan Panen</label>
      <?php $status = old('harvstsell') == null ? $v['harvstsell'] : old('harvstsell') ?>
      <select class="form-control form-control-sm select2-input" name="harvstsell" style="width: 100%;" required>
        <option <?= $status == 'TIDAK DIJUAL' ? 'selected' : '' ?> >TIDAK DIJUAL</option>
        <option <?= $status == 'PASAR' ? 'selected' : '' ?> >PASAR</option>
        <option <?= $status == 'TENGKULAK' ? 'selected' : '' ?> >TENGKULAK</option>
      </select>
    </div>

    <div class="form-group">
      <label for="">Penggunaan Lahan</label>
      <?php $status = old('landuse') == null ? $v['landuse'] : old('landuse') ?>
      <select class="form-control form-control-sm select2-input" name="landuse" style="width: 100%;" required>
        <option <?= $status == 'Sawah' ? 'selected' : '' ?> >Sawah</option>
        <option <?= $status == 'Non Sawah' ? 'selected' : '' ?> >Non Sawah</option>
        <option <?= $status == 'Pemukiman' ? 'selected' : '' ?> >Pemukiman</option>
      </select>
    </div>

    <button type="submit" class="btn btn-block btn-sm btn-primary">Simpan</button>

  </div><!-- RIGHT col-md-12 -->
</div><!-- ROW -->

<?php echo form_close() ?>
