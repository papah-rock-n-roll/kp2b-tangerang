<!DOCTYPE html>
<html lang="en">
<head>
<?= $this->include('public/partials/head') ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">  
  <?= $this->include('public/partials/nav') ?>
  <?= $this->include('public/partials/sidebar') ?>
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
    <div class="content">
      <div class="container-fluid">
      <?= $this->renderSection('content') ?>
      </div>
    </div>
  </div>
  <?= $this->include('public/partials/footer') ?>
</div>
<?= $this->include('public/partials/script') ?>
<?= $this->renderSection('script') ?>
</body>
</html>