<?php if(service('uri')->getSegment(1) === 'administrator' && session()->has('privilage')) : ?>

<?= $this->extend('partials/index') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
  <div class="error-page">
    <h2 class="headline text-warning"> 404</h2>

    <div class="error-content">
      <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

      <p>
        We could not find the page you were looking for.
        Meanwhile, you may <a href="/administrator/dashboard">return to dashboard</a> :)
      </p>

    </div>
    <!-- /.error-content -->
  </div>
  <!-- /.error-page -->
</section>
<!-- /.content -->
<?= $this->endSection() ?>

<?php else : ?> 

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="robots" content="noindex">

<title><?= htmlspecialchars('Error 404', ENT_SUBSTITUTE, 'UTF-8') ?></title>

<style type="text/css">
  <?= file_get_contents(ROOTPATH.'/public/themes/dist/css/adminlte.min.css') ?>
</style>
</head>
<body>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>404 Error Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/logout">Home</a></li>
              <li class="breadcrumb-item active">404 Page Not Found</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

          <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="/logout">return to home and logout</a> :)
          </p>

        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->

  <script type="text/javascript">
    <?= file_get_contents(ROOTPATH.'/public/themes/plugins/jquery/jquery.min.js') ?>
		<?= file_get_contents(ROOTPATH.'/public/themes/dist/js/adminlte.min.js') ?>
	</script>
</body>
</html>

<?php endif ?>