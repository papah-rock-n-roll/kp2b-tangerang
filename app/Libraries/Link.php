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
      'sourcesand' => '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">'
    );

    $local = (object) array(
      'arcgis' => '<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css" />',
      'chartjs' => '<link rel="stylesheet" href="'.base_url('themes/plugins/chart.js/Chart.min.css').'">',
      'fontawesome' => '<link rel="stylesheet" href="'.base_url('themes/plugins/fontawesome-free/css/all.min.css').'">',
      'select2' => '<link rel="stylesheet" href="'.base_url('themes/plugins/select2/css/select2.min.css').'">',
      'bootstrap' => '<link rel="stylesheet" href="'.base_url('themes/plugins/bootstrap/css/bootstrap.min.css').'">',
      'select2bootstrap' => '<link rel="stylesheet" href="'.base_url('themes/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css').'">',
      'adminlte' => '<link rel="stylesheet" href="'.base_url('themes/dist/css/adminlte.min.css').'">',
      'sourcesand' => '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">'
    );

    return $local;
  }

  public static function script()
  {
    $public = (object) array(
      'arcgis' => '<script src="https://js.arcgis.com/4.17/"></script>',
      'chartjs' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>',
      'jquery' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>',
      'bootstrap' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js"></script>',
      'select2' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>',
      'adminlte' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js"></script>'
    );

    $local = (object) array(
      'arcgis' => '<script src="https://js.arcgis.com/4.17/"></script>',
      'chartjs' => '<script src="'.base_url('themes/plugins/chart.js/Chart.bundle.min.js').'"></script>',
      'jquery' => '<script src="'.base_url('themes/plugins/jquery/jquery.min.js').'"></script>',
      'bootstrap' => '<script src="'.base_url('themes/plugins/bootstrap/js/bootstrap.bundle.min.js').'"></script>',
      'select2' => '<script src="'.base_url('themes/plugins/select2/js/select2.full.min.js').'"></script>',
      'adminlte' => '<script src="'.base_url('themes/dist/js/adminlte.min.js').'"></script>'
    );

    return $local;
  }

}
