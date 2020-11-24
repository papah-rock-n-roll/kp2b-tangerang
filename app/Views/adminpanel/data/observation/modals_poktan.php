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
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-sm btn-primary" onclick="createPost()">Simpan</button>
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
