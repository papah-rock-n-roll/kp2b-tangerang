<?= $this->extend('partials/index') ?>
<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-12">

<div class="card">
<?php echo form_open($action) ?>
  <div class="card-header">
    <h5 class="card-title"><i class="fas fa-upload"></i> <?= $filename ?></h5>
    <div class="card-tools">
    <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i>
    </button>
    </div>
  </div>
  <div class="card-body">

    <?php if($duplicate = session()->getFlashdata('duplicate')) : ?>
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
        <?= $duplicate ?>
      </div>
      <div class="callout callout-warning">
        <h6>Data Exsist <strong>Ownerid</strong></h6>
        <p><small><?= $inDB ?></small></p>
      </div>
      <input type="hidden" name="exsist" value="<?= $inDB ?>">
    <?php endif ?>

    <?php if($newdata = session()->getFlashdata('newdata')) : ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Hallo!</h5>
        <?= $newdata ?>
      </div>
      <div class="callout callout-success">
        <h6>New Data <strong>Ownerid</strong></h6>
        <p><small><?= $outDB ?></small></p>
      </div>
      <input type="hidden" name="newdata" value="<?= $outDB ?>">
    <?php endif ?>

  </div>
  <input type="hidden" name="filename" value="<?= $filename ?>">
  <div class="card-footer">
    <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= esc($back) ?>'">Back</button>
    <button type="submit" class="btn btn-primary">Import</button>
  </div>
  <?php echo form_close() ?>
</div>

</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>