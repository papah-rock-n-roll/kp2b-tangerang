<?php namespace App\Libraries;
 
class Link
{
  public static function style()
  {
    return (object) array(
      'arcgis' => '<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css" />',
      'chartjs' => '<link rel="stylesheet" href="'.base_url('themes/plugins/chart.js/Chart.min.css').'">',
    );
  }

  public static function script()
  {
    return (object) array(
      'arcgis' => '<script src="https://js.arcgis.com/4.17/"></script>',
      'chartjs' => '<script src="'.base_url('themes/plugins/chart.js/Chart.bundle.min.js').'"></script>',
    );
  }

}