<?= $this->extend('partials/index') ?>
<?= $this->section('link') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
<div class="col-lg-12">

  <div class="card bg-gradient-primary collapsed-card">
    <div class="card-header">
      <h5 class="card-title"><i class="fas fa-search"></i> Filter Data</h5>
      <div class="card-tools" style="width: 50%">
        <div class="input-group input-group-sm">
          <?php echo form_dropdown('role', $roles, $role, ['class' => 'custom-select', 'id' => 'roles']) ?>
          <?php
            $form_keyword = [
              'type'  => 'text',
              'class' => 'form-control',
              'name'  => 'keyword',
              'id'    => 'keyword',
              'value' => $keyword,
              'placeholder' => 'Enter keyword ...'
            ];
          echo form_input($form_keyword);
          ?>
          <div class="input-group-append">
            <button class="btn btn btn-secondary" id="filterSubmit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

    
  <?php foreach (array_chunk($list, 4) as $nlist ) : ?>  
      <div class="card-deck">
        <?php foreach ($nlist as $v ) : ?> 
          <?= view('adminpanel/user/component', $v) ?>
        <?php endforeach ?>
      </div>
  <?php endforeach ?>
    

  <div class="card-footer clearfix">
    <div class="pagination pagination-md m-0 float-right">
      <?= $pager->links('users', 'bootstrap-pager') ?>
    </div>
  </div>

</div>
</div>
<?= $this->endSection() ?>


<?= $this->section('script') ?>

<script type="text/javascript">

  let filter = function() {
    var role = $("#roles").val();
    var keyword = $("#keyword").val();
    window.location.replace("?role="+ role +"&keyword="+ keyword);
  };

  $("#filterSubmit").click(function() {
    filter();
  });

  $("#roles").change(function() {
    filter();
  });

  $("#keyword").keypress(function(event) {
    if(event.keyCode == 13) {
      filter();
    }
  });

</script>
<?= $this->endSection() ?>