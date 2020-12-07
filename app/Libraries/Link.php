<?php namespace App\Libraries;

class Link
{
  public static function style()
  {
    $public = (object) array(
      'arcgis' => '<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css" />',
      'chartjs' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">',
      'fontawesome' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">',
      'select2' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">',
      'bootstrap' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">',
      'select2bootstrap' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">',
      'adminlte' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/css/adminlte.min.css">',
      'sourcesand' => '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">',
      'tempusdominus' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.css">',
      'toastr' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">',
    );

    $local = (object) array(
      'arcgis' => '<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css" />',
      'chartjs' => '<link rel="stylesheet" href="'.base_url('themes/plugins/chart.js/Chart.min.css').'">',
      'fontawesome' => '<link rel="stylesheet" href="'.base_url('themes/plugins/fontawesome-free/css/all.min.css').'">',
      'select2' => '<link rel="stylesheet" href="'.base_url('themes/plugins/select2/css/select2.min.css').'">',
      'bootstrap' => '<link rel="stylesheet" href="'.base_url('themes/plugins/bootstrap/css/bootstrap.min.css').'">',
      'select2bootstrap' => '<link rel="stylesheet" href="'.base_url('themes/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css').'">',
      'adminlte' => '<link rel="stylesheet" href="'.base_url('themes/dist/css/adminlte.min.css').'">',
      'sourcesand' => '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">',
      'tempusdominus' => '<link rel="stylesheet" href="'.base_url('themes/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css').'">',
      'toastr' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">',
    );

    if (ENVIRONMENT !== 'production')
	  {
      return $local;
    }
    else
    {
      return $public;
    }

  }

  public static function script()
  {
    $public = (object) array(
      'arcgis' => '<script src="https://js.arcgis.com/4.17/"></script>',
      'chartjs' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>',
      'jquery' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>',
      'bootstrap' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js"></script>',
      'select2' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>',
      'adminlte' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js"></script>',
      'moment' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>',
      'tempusdominus' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"></script>',
      'jqueryvalidation' => '<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>',
      'toastr' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>',
      'particlesjs' => '<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>'
    );

    $local = (object) array(
      'arcgis' => '<script src="https://js.arcgis.com/4.17/"></script>',
      'chartjs' => '<script src="'.base_url('themes/plugins/chart.js/Chart.bundle.min.js').'"></script>',
      'jquery' => '<script src="'.base_url('themes/plugins/jquery/jquery.min.js').'"></script>',
      'bootstrap' => '<script src="'.base_url('themes/plugins/bootstrap/js/bootstrap.bundle.min.js').'"></script>',
      'select2' => '<script src="'.base_url('themes/plugins/select2/js/select2.full.min.js').'"></script>',
      'adminlte' => '<script src="'.base_url('themes/dist/js/adminlte.min.js').'"></script>',
      'moment' => '<script src="'.base_url('themes/plugins/moment/moment.min.js').'"></script>',
      'tempusdominus' => '<script src="'.base_url('themes/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js').'"></script>',
      'jqueryvalidation' => '<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>',
      'toastr' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>',
      'particlesjs' => '<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>'
    );

    if (ENVIRONMENT !== 'production')
	  {
      return $local;
    }
    else
    {
      return $public;
    }

  }

}
