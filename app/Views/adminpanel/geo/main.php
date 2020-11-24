<?= $this->extend('partials/index') ?>
<?= $this->section('link') ?>
<style>html, body, #viewDiv {padding:0;margin:0;height:calc(100vh - 57px);width:100%;}</style>
<style>
  #modal_petak {
    overflow-y: auto;
  }
</style>
<?= \App\Libraries\Link::style()->select2 ?>
<?= \App\Libraries\Link::style()->arcgis ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div id="viewDiv">
  <div class="modal fade" id="modal_petak"><!-- MODAL PETAK -->
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"> Update Petak </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div for='ownercultivator'><!-- OWNERCULTIVATOR MODAL -->
            <div class="modal fade" id="modal_create">
              <div class="modal-dialog modal-md">
                <div class="modal-content bg-default">
                  <div class="modal-header">
                    <h4 class="modal-title">Tambah data pemilik / penggarap</h4>
                    <button type="button" class="close child-modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <?php echo form_open() ?>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">NIK</label>
                            <?php
                            $ownernik = [
                              'type' => 'text',
                              'class' => 'form-control form-control-sm',
                              'name' => 'ownernik',
                              'placeholder' => 'Masukkan NIK pemilik',
                              'minlength' => '1',
                              'value' => old('ownernik') == null ? '' : old('ownernik'),
                              'required' => ''
                            ];
                            echo form_input($ownernik);
                            ?>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Nama</label>
                              <?php
                              $ownername = [
                                'type' => 'text',
                                'class' => 'form-control form-control-sm',
                                'name' => 'ownername',
                                'placeholder' => 'Masukkan nama pemilik',
                                'minlength' => '1',
                                'value' => old('ownername') == null ? '' : old('ownername'),
                                'required' => ''
                              ];
                              echo form_input($ownername);
                              ?>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="">Alamat</label>
                            <?php
                            $owneraddress = [
                              'class' => 'form-control form-control-sm',
                              'cols' => '2',
                              'rows' => '3',
                              'name' => 'owneraddress',
                              'minlength' => '1',
                              'placeholder' => 'Masukkan alamat pemilik',
                              'value' => old('owneraddress') == null ? '' : old('owneraddress'),
                              'required' => ''
                            ];
                            echo form_textarea($owneraddress);
                            ?>
                          </div>
                        </div>
                      </div>

                    <?php echo form_close() ?>

                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="child-modal btn btn-sm btn-default">Batal</button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="createPost()">Simpan</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
          </div>

          <div for='farmer'><!-- POKTAN MODAL -->
            <div class="modal fade" id="modal_poktan">
              <div class="modal-dialog modal-md">
                <div class="modal-content bg-default">
                  <div class="modal-header">
                    <h4 class="modal-title">Tambah data poktan</h4>
                    <button type="button" class="close child-modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                  <?php echo form_open() ?>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Nama ketua Poktan</label>
                          <?php
                          $farmhead = [
                            'type' => 'text',
                            'class' => 'form-control form-control-sm',
                            'name' => 'farmhead',
                            'placeholder' => 'Masukkan nama ketua Poktan',
                            'minlength' => '5',
                            'required' => ''
                          ];
                          echo form_input($farmhead);
                          ?>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">No kontak ketua Poktan</label>
                            <?php
                            $farmmobile = [
                              'type' => 'text',
                              'class' => 'form-control form-control-sm',
                              'name' => 'farmmobile',
                              'placeholder' => 'Masukkan no kontak ketua Poktan',
                              'minlength' => '5',
                              'required' => ''
                            ];
                            echo form_input($farmmobile);
                            ?>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Nama poktan</label>
                          <?php
                          $farmname = [
                            'type' => 'text',
                            'class' => 'form-control form-control-sm',
                            'name' => 'farmname',
                            'minlength' => '5',
                            'placeholder' => 'Masukkan nama Poktan',
                            'required' => ''
                          ];
                          echo form_input($farmname);
                          ?>
                        </div>
                      </div>
                    </div>

                  <?php echo form_close() ?>

                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="child-modal btn btn-sm btn-default">Batal</button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="createPost()">Simpan</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
          </div>

          <div for='responden'><!-- RESPONDEN MODAL -->
            <div class="modal fade" id="modal_respo">
              <div class="modal-dialog modal-md">
                <div class="modal-content bg-default">
                  <div class="modal-header">
                    <h4 class="modal-title">Tambah responden</h4>
                    <button type="button" class="close child-modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                  <?php echo form_open() ?>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Nama responden</label>
                          <?php
                          $respname = [
                            'type' => 'text',
                            'class' => 'form-control form-control-sm',
                            'name' => 'respname',
                            'placeholder' => 'Masukkan nama responden',
                            'minlength' => '5',
                            'required' => ''
                          ];
                          echo form_input($respname);
                          ?>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">No tlp responden</label>
                            <?php
                            $mobileno = [
                              'type' => 'text',
                              'class' => 'form-control form-control-sm',
                              'name' => 'mobileno',
                              'placeholder' => 'Masukkan no tlp responden',
                              'minlength' => '5'
                            ];
                            echo form_input($mobileno);
                            ?>
                        </div>
                      </div>
                    </div>

                  <?php echo form_close() ?>

                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="child-modal btn btn-sm btn-default">Batal</button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="createPost()">Simpan</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
          </div>

          <div class="row"><!-- FORM CONTROL MODAL PETAK -->
            <div class="col-md-6"><!-- LEFT col-md-6 -->

              <div class="form-group">
                <label for="">Pemilik</label>
                <?php
                $ownerid = old('ownerid') == null ? '' : old('ownerid');
                $ownername = old('ownername') == null ? '' : old('ownername');
                ?>
                <select name="ownerid" class="form-control form-control-sm custom-select select2-ownercultivator" style="width: 100%;" required>';
                  <option value="<?= $ownerid ?>" selected="selected"><?= esc($ownername) ?></option>
                </select>
              </div>

              <div class="form-group">
                <label for="">Penggarap</label>
                <?php
                $cultivatorid = old('cultivatorid') == null ? '' : old('cultivatorid');
                $cultivatorname = old('cultivatorname') == null ? '' : old('cultivatorname');
                ?>
                <select name="cultivatorid" class="form-control form-control-sm custom-select select2-ownercultivator" style="width: 100%;" required>';
                  <option value="<?= $cultivatorid ?>" selected="selected"><?= esc($cultivatorname) ?></option>
                </select>
              </div>

              <div class="form-group">
                <label for="">Kelompok Tani</label>
                <?php
                $farmcode = old('farmcode') == null ? '' : old('farmcode');
                $farmname = old('farmname') == null ? '' : old('farmname');
                ?>
                <select name="farmcode" class="form-control form-control-sm custom-select select2-farmer" style="width: 100%;" required>';
                  <option value="<?= $farmcode ?>" selected="selected"><?= esc($farmname) ?></option>
                </select>
              </div>

              <div class="form-group">
                <label for="">Status Lahan</label>
                <?php $status = old('areantatus') == null ? '' : old('areantatus') ?>
                <select class="form-control form-control-sm select2-input" id="areantatus" name="areantatus" style="width: 100%;" required>
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
                    'value' => old('broadnrea') == null ? '' : old('broadnrea'),
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
                <?php $valid = 'form-control form-control-sm' ?>
                <select class="<?= $valid ?> select2-multi" name="typeirigation[]" style="width: 100%;" multiple="multiple" data-placeholder="Select Module">
                  <?php foreach(array() as $k_irig => $v_irig) : ?>
                    <option <?= $v_irig ?>><?= $k_irig ?></option>
                  <?php endforeach ?>
                </select>
              </div>

              <div class="form-group">
                <label for="">Jarak Dari Sungai</label>
                <div class="input-group input-group-sm">
                  <?php
                  $distancefromriver = [
                    'class' =>  'form-control form-control-sm',
                    'type' => 'text',
                    'inputmode' => 'decimal',
                    'pattern' => '[-+]?[0-9]*[.,]?[0-9]+',
                    'name' => 'distancefromriver',
                    'min' => '1',
                    'max' => '1000000',
                    'placeholder' => 'Jarak dalam meter',
                    'value' => old('distancefromriver') == null ? '' : old('distancefromriver')
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
                    'value' => old('distancefromIrgPre') == null ? '' : old('distancefromIrgPre')
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
                  'value' => old('wtrtreatnnst') == null ? '' : old('wtrtreatnnst')
                ];
                echo form_input($wtrtreatnnst);
                ?>
              </div>

              <div class="form-group">
                <label for="">Intensitas Tanam</label>
                <?php $status = old('intensitynlan') == null ? '' : old('intensitynlan') ?>
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
                  'value' => old('indxnlant') == null ? '' : old('indxnlant'),
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
                  'value' => old('pattrnnlant') == null ? '' : old('pattrnnlant')
                ];
                echo form_input($pattrnnlant);
                ?>
              </div>

            </div><!-- col-md-6 -->

            <div class="col-md-6"><!-- RIGHT col-md-6 -->

              <div class="form-group">
                <label for="">Desa</label>
                <?php
                $vlcode = old('vlcode') == null ? '' : old('vlcode');
                $vlname = old('vlname') == null ? '' : old('vlname');
                ?>
                <select name="vlcode" class="form-control form-control-sm custom-select select2-subdist" style="width: 100%;" required>';
                  <option value="<?= $vlcode ?>" selected="selected"><?= esc($vlname) ?></option>
                </select>
              </div>

              <div class="form-group">
                <label for="">Responden</label>
                <?php
                $selected = old('respid') == null ? '' : old('respid');
                echo form_dropdown('respid', '', $selected, ['class' => 'form-control form-control-sm custom-select select2-respo', 'style' => 'width: 100%;', 'required' => '']);
                ?>
              </div>

              <div class="form-group">
                <label for="">Permasalahan OPT</label>
                <?php $valid = 'form-control form-control-sm' ?>
                <select class="<?= $valid ?> select2-multi" name="opt[]" style="width: 100%;" multiple="multiple" data-placeholder="Select Module">
                  <?php foreach(array() as $k_opt => $v_opt) : ?>
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
                  'value' => old('wtr') == null ? '' : old('wtr')
                ];
                echo form_input($wtr);
                ?>
              </div>

              <div class="form-group">
                <label for="">Permasalahan Saprotan</label>
                <?php $valid = 'form-control form-control-sm' ?>
                <select class="<?= $valid ?> select2-multi" name="saprotan[]" style="width: 100%;" multiple="multiple" data-placeholder="Select Module">
                  <?php foreach(array() as $k_sap => $v_sap) : ?>
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
                  'value' => old('other') == null ? '' : old('other')
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
                    'value' => old('harvstmax') == null ? '' : old('harvstmax')
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
                <?php $status = old('monthmax') == null ? '' : old('monthmax') ?>
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
                    'value' => old('harvstmin') == null ? '' : old('harvstmin')
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
                <?php $status = old('monthmin') == null ? '' : old('monthmin') ?>
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
                <?php $status = old('harvstsell') == null ? '' : old('harvstsell') ?>
                <select class="form-control form-control-sm select2-input" name="harvstsell" style="width: 100%;" required>
                  <option <?= $status == 'TIDAK DIJUAL' ? 'selected' : '' ?> >TIDAK DIJUAL</option>
                  <option <?= $status == 'PASAR' ? 'selected' : '' ?> >PASAR</option>
                  <option <?= $status == 'TENGKULAK' ? 'selected' : '' ?> >TENGKULAK</option>
                </select>
              </div>

              <div class="form-group">
                <label for="">Penggunaan Lahan</label>
                <?php $status = old('landuse') == null ? '': old('landuse') ?>
                <select class="form-control form-control-sm select2-input" name="landuse" style="width: 100%;" required>
                  <option <?= $status == 'Sawah' ? 'selected' : '' ?> >Sawah</option>
                  <option <?= $status == 'Non Sawah' ? 'selected' : '' ?> >Non Sawah</option>
                  <option <?= $status == 'Pemukiman' ? 'selected' : '' ?> >Pemukiman</option>
                </select>
              </div>

            </div><!-- RIGHT col-md-6 -->
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-sm btn-primary" onclick="">Simpan</button>
        </div>
      </div>
    </div>
  </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= \App\Libraries\Link::script()->select2 ?>
<?= \App\Libraries\Link::script()->arcgis ?>

<!-- ESRI SCRIPT -->
<script>
  require([
    "esri/Map",
    "esri/views/MapView",
    "esri/layers/GeoJSONLayer",
    "esri/layers/GroupLayer",
    "esri/widgets/LayerList",
    "esri/widgets/Track",
    "esri/widgets/Expand",
    "esri/widgets/BasemapGallery",
    "esri/widgets/Fullscreen",
    "esri/widgets/Search",
    "esri/widgets/Editor",
    "dojo/dom-construct",
    "dojo/dom",
    "dojo/on",
    "esri/core/watchUtils"
  ], function (Map, MapView, GeoJSONLayer, GroupLayer, LayerList, Track, Expand, BasemapGallery, Fullscreen, Search, Editor, domConstruct, dom, on, watchUtils) {

    const url = "<?= $url ?>";
    const url_kec = "<?= $url_kec ?>";
    const url_desa = "<?= $url_desa ?>";
    const url_obs = "<?= $url_obs ?>";
    const url_edtObs = "<?= $url_edtObs ?>";
    const url_edtPlt = "<?= $url_edtPlt ?>";
    let editor, features;
    var dataKec = [], dataDesa = [], dataObs = [];
    var geojsonLayer;
    var dataHead = ["Kode petak","Nama responden","Nama Kelompok Tani","Nama kecamatan","Nama desa","Landuse",
    "Status lahan","Luas petak (m<sup>2</sup>)","NIK pemilik","Nama pemilik","Nama penggarap","Tipe irigasi",
    "Jarak dari sungai (m)","Jarak dari irigasi primer (m)","Lembaga pengelola air","Intensitas tanam","Index pertanaman (IP)",
    "Pola tanam","Permasalahan OPT","Permasalahan air","Permasalahan saprotan","Permasalahan lain",
    "Panen terbanyak (kuintal)","Bulan panen terbanyak","Panen terkecil (kuintal)","Bulan panen terkecil",
    "Penjualan panen","Surveyor","Update"]

    const editAttributes = {
      title: "Edit attributes",
      id: "edit-this",
      className: "esri-icon-edit"
    };

    const editCalendar = {
      title: "Edit kalender tanam",
      id: "edit-cal",
      className: "esri-icon-calendar"
    };

    const template = {
      title: "Kode Petak: {FID}",
      actions: [editAttributes, editCalendar],
      content: getDetail
    };

    const renderer = {
      type: "simple",
      field: "FID",
      symbol: {
        type: "simple-fill",
        color: "green",
        outline: {
          color: "white"
        }
      }
    };

    const labelClass = {
      symbol: {
        type: "text",
        color: "yellow",
        font: {
          size: 9,
          weight: "light"
        }
      },
      labelPlacement: "above-center",
      labelExpressionInfo: {
        expression: "$feature.FID"
      }
    };

    const map = new Map({
      basemap: "gray-vector"
    });

    const view = new MapView({
      container: "viewDiv",
      center: [106.518852, -6.120213],
      zoom: 10,
      map: map,
      popup: {
        dockOptions: {
          position: "bottom-right"
        }
      }
    });

    function getDetail(feature) {
      var obscode = feature.graphic.attributes.FID;
      $.ajax({
        async : false,
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        url : url_obs + '?obscode=' + obscode,
        type : 'GET',
        success : function(response){
          dataObs = JSON.parse(response);
        }
      });
      var div = document.createElement("div");
      var divContent = '<table class="esri-widget__table"><tbody>';
      for (var i = 0; i < dataHead.length; i++) {
        divContent += '<tr><th class="esri-feature-fields__field-header">' + dataHead[i] + '</th> \
        <td class="esri-feature-fields__field-data">' + Object.values(dataObs)[i] + '</td></tr>';
      }
      divContent += '</tbody></table>';
      divContent += '<p class="mt-3">Update terkahir oleh: ' + dataObs.username + '. Tanggal ' + dataObs.timestamp + '</p>';
      div.innerHTML = divContent;
      return div;
    }

    function defineActions(event) {
      var item = event.item;

      if (item.title === "Petak sawah") {
        item.actionsSections = [
          [{
            title: "Go to full extent",
            className: "esri-icon-zoom-out-fixed",
            id: "full-extent"
          }],
          [{
            title: "Increase opacity",
            className: "esri-icon-up",
            id: "increase-opacity"
          },{
            title: "Decrease opacity",
            className: "esri-icon-down",
            id: "decrease-opacity"
          }]
        ];
      }
    }

    view.when(function () {
      var popup = view.popup;

      var searchWidget = new Search({
        view: view,
        includeDefaultSources: false
      });

      view.ui.add(searchWidget, {
        position: "top-right"
      });

      view.ui.add(
        new Fullscreen({
          view: view,
          element: viewDiv
        }),
        "top-right"
      );

      var track = new Track({
        view: view,
        useHeadingEnabled: false,
        goToLocationEnabled: false
      });
      view.ui.add(track, "top-left");

      const basemapGallery = new BasemapGallery({
        view: view,
        container: document.createElement("div")
      });

      view.ui.add(
        new Expand({
          view: view,
          content: basemapGallery
        }),
        "bottom-left"
      );

      var layerList = new LayerList({
        view: view,
        listItemCreatedFunction: defineActions
      });

      view.ui.add(
        new Expand({
          view: view,
          content: layerList
        }),
        "top-left"
      );

      layerList.on("trigger-action", function (event) {

        var id = event.action.id;

        if (id === "full-extent") {
          view.goTo(geojsonLayer.fullExtent).catch(function (error) {
            if (error.name != "AbortError") {
              console.error(error);
            }
          });
        } else if (id === "increase-opacity") {
          if (geojsonLayer.opacity < 1) {
            geojsonLayer.opacity += 0.25;
          }
        } else if (id === "decrease-opacity") {
          if (geojsonLayer.opacity > 0) {
            geojsonLayer.opacity -= 0.25;
          }
        }
      });

      view.popup.on("trigger-action", function (event) {
        if (event.action.id === "edit-this") {
          var attributes = popup.viewModel.selectedFeature.attributes;
          var id = attributes.FID;
          $.ajax({
            async : true,
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            type: "GET",
            format: "json",
            url: '/api/observation/ajax?id=' + id,
            success: function(response){
              data = JSON.parse(response);
              console.log(data);
            }
          });
          view.popup.close();
          //$('#modal_petak').modal('show');
          //window.location.href = url_edtObs + "/" + id;
        }else if (event.action.id === "edit-cal") {
            var attributes = popup.viewModel.selectedFeature.attributes;
            var id = attributes.FID;
            window.location.href = url_edtPlt + "/" + id;
          }
      });

      $.ajax({
        async : false,
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        url : url_kec,
        type : 'GET',
        success : function(response){
          dataKec = JSON.parse(response);
        }
      });

      // Format char to Title Case
    	function toTitleCase(str) {
          return str.replace(
              /\w\S*/g,
              function(txt) {
                  return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
              }
          );
      }

      // get List Desa
      function getDesa(sdcode = ''){
        $.ajax({
          async : false,
          headers: {'X-Requested-With': 'XMLHttpRequest'},
          url : url_desa + '?sdcode=' + sdcode,
          type : 'GET',
          success : function(response){
            dataDesa = JSON.parse(response);
          }
        });
        var desaDom = '<option value="">Semua desa</option>';
        for (var i = 0; i < dataDesa.length; i++) {
          var optDesa = '<option value="' + dataDesa[i].vlcode + '"> ' + toTitleCase(dataDesa[i].vlname) + ' </option>';
          desaDom = desaDom + optDesa;
        }
        $('#layerDesa').html(desaDom);
      }

      // update search layer source
      function updateSearchSource(){
        const sources = [
          {
            layer: geojsonLayer,
            searchFields: ["FID"],
            suggestionTemplate: "Kode Petak: {FID}",
            displayField: "FID",
            exactMatch: false,
            outFields: ["FID"],
            name: "Kode petak",
            placeholder: "Cari kode petak"
          }
        ];
        searchWidget.sources = sources;
      }

      // Update layers
      function updateLayer(kec, desa){
        map.layers.removeAll();
        popup.close();
        geojsonLayer = new GeoJSONLayer({
          url: url + "/info?table=v_observations&fid=obscode&shape=obsshape&sdcode=" + kec + "&vlcode=" + desa,
          copyright: "Dinas Pertanian Kab. Tangerang",
          popupTemplate: template,
          labelingInfo: [labelClass],
          renderer: renderer,
          title: "Petak sawah",
          opacity: .75
        });
        geojsonLayer.queryExtent().then(function(results){
          view.goTo(results.extent);
        });
        map.add(geojsonLayer);
        updateSearchSource();
        layerAdd.collapse();
      }

      var kecDom = '<div class="form-group input-group-sm" id="kecForm"> \
        <label>Pilih kecamatan</label> \
        <select class="form-control" id="layerKec"> \
          <option value="">Semua kecamatan</option>';
          for (var i = 0; i < dataKec.length; i++) {
            var opt = '<option value="' + dataKec[i].sdcode + '"> ' + toTitleCase(dataKec[i].sdname) + ' </option>';
            kecDom = kecDom + opt;
        	}
        kecDom = kecDom + '</select> \
      </div> \
      <div class="form-group input-group-sm" id="desaForm" style="display: none;"> \
        <label>Pilih desa</label> \
        <select class="form-control" id="layerDesa"> \
          <option value="">Semua desa</option> \
        </select> \
      </div> \
      <div class="form-group input-group-sm" id="layerForm"><button id="applyLayer" type="submit" class="btn btn-block btn-sm btn-primary">Apply</button></div>';

      var node = domConstruct.create("div", {
        className: "esri-layer-list esri-widget esri-widget--panel",
        innerHTML: kecDom
      });

      const layerAdd = new Expand({
        view: view,
        expanded: false,
        expandIconClass: "esri-icon-collection",
        expandTooltip: "Add layer",
        content: node
       });

      view.ui.add(layerAdd, "top-left");

      watchUtils.whenTrueOnce(layerAdd, 'expanded', function(){
        on(dom.byId("layerKec"), 'change', function(){
          if(this.value == ''){$("#desaForm").hide();}else{$("#desaForm").show();}
          getDesa(this.value);
        });
        on(dom.byId("applyLayer"), 'click', function(){
          updateLayer($("#layerKec").val(), $("#layerDesa").val());
        });
      });

    });

  });
</script>

<!-- MODALS SCRIPT -->
<script>
  document.addEventListener('DOMContentLoaded', function() {

    var flg = 0;

    $(".child-modal").click(function(){
        $(this).closest(".modal").modal("hide")
    });

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
    }).on("select2:open", () => {
      $(".select2-results:not(:has(a))")
        .prepend('<div class="select2-results__option"><div class="wrapper">' +
          '<a href="#" class="btn btn-block btn-sm btn-primary" data-toggle="modal" data-target="#modal_create">+ Tambah pemilik/penggarap</a>' +
        '</div></div>')
    });

    $('#modal_create').on('shown.bs.modal', function () {
      $(".select2-ownercultivator").select2("close");
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
    }).on("select2:open", () => {
      $(".select2-results:not(:has(a))")
        .prepend('<div class="select2-results__option"><div class="wrapper">' +
          '<a href="#" class="btn btn-block btn-sm btn-primary" data-toggle="modal" data-target="#modal_poktan">+ Tambah kelompok tani</a>' +
        '</div></div>')
    });

    $('#modal_poktan').on('shown.bs.modal', function () {
      $(".select2-farmer").select2("close");
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

    $(".select2-respo").select2({
      ajax: {
        url: "/api/respondens",
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
              'id': v.respid,
              'text': v.respname,
              'items': {
                'respname': v.respname,
                'mobileno': v.mobileno ,
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
      placeholder: 'Pilih responden',
      minimumInputLength: 1,
      templateResult: formatDataRespo,
      templateSelection: formatDataSelection
    }).on("select2:open", () => {
      $(".select2-results:not(:has(a))")
        .prepend('<div class="select2-results__option"><div class="wrapper">' +
          '<a href="#" class="btn btn-block btn-sm btn-primary" data-toggle="modal" data-target="#modal_respo">+ Tambah responden</a>' +
        '</div></div>')
    });

    $('#modal_respo').on('shown.bs.modal', function () {
      $(".select2-respo").select2("close");
    });

    function formatDataRespo(data) {
      if (data.loading) return data.text;

      var markup = $(
        '<optgroup label="'+ data.items.respname +'">' +
          '<option class="mobileno"></option>' +
        '</optgroup>');

      markup.find(".mobileno").text(data.items.mobileno);

      return markup;
    }

    function formatDataSelection (data) {
      return data.text;
    }

  });
</script>
<?= $this->endSection() ?>
