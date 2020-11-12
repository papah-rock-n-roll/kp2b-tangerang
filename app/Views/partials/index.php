<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<?= csrf_meta() ?>
<?= $this->renderSection('link') ?>
<?= $this->include('partials/head') ?>
</head>
<body class="sidebar-mini layout-navbar-fixed">
<div class="wrapper">  
  <?= $this->include('partials/nav') ?>
  <?= $this->include('partials/sidebar') ?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <?= $this->include('partials/title') ?>
          </div>
          <div class="col-sm-6">
            <?= $this->include('partials/breadcrumbs') ?>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
      <?= $this->renderSection('content') ?>
      </div>
    </div>
  </div>
  <?= $this->include('partials/footer') ?>
</div>
<?= $this->include('partials/script') ?>
<?= $this->renderSection('script') ?>
</body>
</html>