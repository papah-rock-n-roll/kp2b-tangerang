<div class="modal fade" id="<?= esc($id) ?>">
  <div class="modal-dialog <?= esc($size) ?>">
    <div class="modal-content <?= esc($class) ?>">

      <div class="overlay justify-content-center align-items-center" style="display: none;">
        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>

      <?php
        $attributes = ['id' => 'ownerform'];
        echo form_open(base_url('api/owners'), $attributes);
      ?>

      <div class="modal-header">
        <h6 class="modal-title"><?= $title ?></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div class="form-group">
          <?php
          $ownernik = [
            'type' => 'text',
            'id' => 'ownernik',
            'class' => 'form-control form-control-sm',
            'maxlength' => "30",
            'name' => 'ownernik',
            'placeholder' => 'NIK pemilik/penggarap',
            'value' => old('ownernik') == null ? '' : old('ownernik'),
            'required' => ''
          ];
          echo form_input($ownernik);
          ?>
        </div>

        <div class="form-group">
            <?php
            $ownername = [
              'type' => 'text',
              'id' => 'ownername',
              'class' => 'form-control form-control-sm',
              'maxlength' => "30",
              'name' => 'ownername',
              'placeholder' => 'Nama pemilik/penggarap',
              'value' => old('ownername') == null ? '' : old('ownername'),
              'required' => ''
            ];
            echo form_input($ownername);
            ?>
        </div>

        <div class="form-group mb-0">
          <?php
          $owneraddress = [
            'id' => 'owneraddress',
            'class' => 'form-control form-control-sm',
            'maxlength' => "255",
            'cols' => '2',
            'rows' => '3',
            'name' => 'owneraddress',
            'placeholder' => 'Alamat pemilik/penggarap',
            'value' => old('owneraddress') == null ? '' : old('owneraddress')
          ];
          echo form_textarea($owneraddress);
          ?>
        </div>

      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
      </div>

      <?php echo form_close() ?>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
