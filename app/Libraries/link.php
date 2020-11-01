<?php namespace App\Libraries;
 
class Link
{
  public static function style()
  {
    $public = (object) array();

    $local = (object) array(
      'arcgis' => '<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css" />',
      'chartjs' => '<link rel="stylesheet" href="'.base_url('themes/plugins/chart.js/Chart.min.css').'">',
      'fontawesome' => '<link rel="stylesheet" href="'.base_url('themes/plugins/fontawesome-free/css/all.min.css').'">',
      'select2' => '<link rel="stylesheet" href="'.base_url('themes/plugins/select2/css/select2.min.css').'">',
      'adminlte' => '<link rel="stylesheet" href="'.base_url('themes/dist/css/adminlte.min.css').'">',
    );

    return $local;
  }

  public static function script()
  {
    $public = (object) array();
    
    $local = (object) array(
      'arcgis' => '<script src="https://js.arcgis.com/4.17/"></script>',
      'chartjs' => '<script src="'.base_url('themes/plugins/chart.js/Chart.bundle.min.js').'"></script>',
      'jquery' => '<script src="'.base_url('themes/plugins/jquery/jquery.min.js').'"></script>',
      'bootstrap' => '<script src="'.base_url('themes/plugins/bootstrap/js/bootstrap.bundle.min.js').'"></script>',
      'select2' => '<script src="'.base_url('themes/plugins/select2/js/select2.full.min.js').'"></script>',
      'adminlte' => '<script src="'.base_url('themes/dist/js/adminlte.min.js').'"></script>',
    );

    return $local;
  }

}