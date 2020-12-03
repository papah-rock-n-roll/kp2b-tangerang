<div class="modal fade" id="<?= esc($id) ?>">
  <div class="modal-dialog <?= esc($size) ?>">
    <div class="modal-content <?= esc($class) ?>">

      <div class="overlay justify-content-center align-items-center" style="display: none;">
        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>

      <?php
        $attributes = ['id' => 'respform'];
        echo form_open(base_url('api/respondens'), $attributes);
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
          $respname = [
            'type' => 'text',
            'id' => 'respname',
            'class' => 'form-control form-control-sm',
            'name' => 'respname',
            'placeholder' => 'Nama responden',
            'minlength' => '5',
            'required' => ''
          ];
          echo form_input($respname);
          ?>
        </div>

        <div class="form-group mb-0">
            <?php
            $mobileno = [
              'type' => 'text',
              'id' => 'mobileno',
              'class' => 'form-control form-control-sm',
              'name' => 'mobileno',
              'placeholder' => 'No tlp responden',
              'minlength' => '5'
            ];
            echo form_input($mobileno);
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
