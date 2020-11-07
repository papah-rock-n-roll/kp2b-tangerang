<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<?= $this->renderSection('link') ?>
<?= $this->include('public/partials/head') ?>
</head>
<body class="layout-top-nav">
<div class="wrapper">
  <?= $this->include('public/partials/nav') ?>
  <!-- <? // $this->include('public/partials/sidebar') ?> -->
  <div class="content-wrapper">
  <!--
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <? // $this->include('public/partials/title') ?>
          </div>
          <div class="col-sm-6">
            <? // $this->include('public/partials/breadcrumbs') ?>
          </div>
        </div>
      </div>
    </div>
  -->
    <?= $this->renderSection('content') ?>
  </div>
  <!-- <? // $this->include('public/partials/footer') ?> -->
</div>
<?= $this->include('public/partials/script') ?>
<?= $this->renderSection('script') ?>
</body>
</html>
