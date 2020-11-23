<div class="modal fade" id="<?= esc($id) ?>">
  <div class="modal-dialog <?= esc($size) ?>">
    <div class="modal-content <?= esc($class) ?>">
      <div class="modal-header">
        <h4 class="modal-title"><?= $title ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php echo form_open($action) ?>
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
                <div class="invalid-feedback">
                  <?= $validation->getError('ownernik') ?>
                </div>
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
                  <div class="invalid-feedback">
                    <?= $validation->getError('ownername') ?>
                  </div>
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
                <div class="invalid-feedback">
                  <?= $validation->getError('owneraddress') ?>
                </div>
              </div>
            </div>
          </div>

        <?php echo form_close() ?>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-sm btn-primary" onclick="createPost()">Confirm</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>

function createPost() {

  $.ajaxSetup({
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-KP2B': $('meta[name="X-CSRF-KP2B"]').attr('content')
    },
  })

  $.ajax({
    async : true,
    url : '/api/owners',
    type : 'GET',
    success : function(data, status, response){
      console.log(data)
    }
  });

}

</script>
