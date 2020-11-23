<?= $this->extend('partials/index') ?>
<?= $this->section('link') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
<div class="col-lg-12">

  <div class="card bg-gradient-primary collapsed-card">
    <div class="card-header p-2">
      <h5 class="card-title col-3"><i class="fas fa-search"></i> Filter</h5>
      <div class="card-tools col-8 col-sm-8 col-lg-6">
        <div class="input-group input-group-sm">
          <?php
            $form_keyword = [
              'type'  => 'text',
              'class' => 'form-control',
              'name'  => 'keyword',
              'id'    => 'keyword',
              'value' => $keyword,
              'placeholder' => 'Enter keyword..'
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
    <div class="row pb-3">
      <div class="card-deck col-sm-12 col-md-12 col-lg-12 m-0 p-0">
        <?php foreach ($nlist as $v ) : ?> 
          <?= view('adminpanel/geo/observation/component', $v) ?>
        <?php endforeach ?>
      </div>
    </div>
  <?php endforeach ?>

  <div class="pagination pagination-md justify-content-center m-0">
    <?= $pager->links('default', 'bootstrap-pager') ?>
  </div>

</div>
</div>
<?= $this->endSection() ?>


<?= $this->section('script') ?>

<script type="text/javascript">

  let filter = function() {
    var keyword = $("#keyword").val();
    window.location.replace("?keyword="+ keyword);
  };

  $("#filterSubmit").click(function() {
    filter();
  });

  $("#keyword").keypress(function(event) {
    if(event.keyCode == 13) {
      filter();
    }
  });

</script>
<?= $this->endSection() ?>