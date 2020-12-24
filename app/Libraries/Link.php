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
      'datatable' => '<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">',
      'datatable4' => '<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">',
      'datatableResponsive4' => '<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">',
      'datatableBtn4' => '<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.bootstrap4.min.css">',
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
      'toastr' => '<link rel="stylesheet" href="'.base_url('themes/plugins/toastr/toastr.min.css').'">',
      'datatable' => '<link rel="stylesheet" href="'.base_url('themes/plugins/datatable/css/jquery.dataTables.min.css').'">',
      'datatable4' => '<link rel="stylesheet" href="'.base_url('themes/plugins/datatable/css/dataTables.bootstrap4.min.css').'">',
      'datatableResponsive4' => '<link rel="stylesheet" href="'.base_url('themes/plugins/datatable/css/responsive.bootstrap4.min.css').'">',
      'datatableBtn4' => '<link rel="stylesheet" href="'.base_url('themes/plugins/datatable/css/buttons.bootstrap4.min.css').'">',
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
      'chartjslabel' => '<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script>',
      'jquery' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>',
      'bootstrap' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js"></script>',
      'select2' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>',
      'adminlte' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js"></script>',
      'moment' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>',
      'tempusdominus' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"></script>',
      'jqueryvalidation' => '<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>',
      'toastr' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>',
      'particlesjs' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>',
      'datatable' => '<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>',
      'datatable4' => '<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>',
      'datatableResponsive' => '<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>',
      'datatableResponsive4' => '<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>',
      'columnfixed' => '<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>',
      'datatableBtn' => '<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>',
      'datatableBtn4' => '<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.bootstrap4.min.js"></script>',
      'btnFlash' => '<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>',
      'jszip' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>',
      'pdfmake' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>',
      'vfsFont' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>',
      'html5Btn' => '<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>',
      'btnPrint' => '<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>',
      'btncolVis' => '<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.colVis.min.js"></script>',
    );

    $local = (object) array(
      'arcgis' => '<script src="https://js.arcgis.com/4.17/"></script>',
      'chartjs' => '<script src="'.base_url('themes/plugins/chart.js/Chart.bundle.min.js').'"></script>',
      'chartjslabel' => '<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script>',
      'jquery' => '<script src="'.base_url('themes/plugins/jquery/jquery.min.js').'"></script>',
      'bootstrap' => '<script src="'.base_url('themes/plugins/bootstrap/js/bootstrap.bundle.min.js').'"></script>',
      'select2' => '<script src="'.base_url('themes/plugins/select2/js/select2.full.min.js').'"></script>',
      'adminlte' => '<script src="'.base_url('themes/dist/js/adminlte.min.js').'"></script>',
      'moment' => '<script src="'.base_url('themes/plugins/moment/moment.min.js').'"></script>',
      'tempusdominus' => '<script src="'.base_url('themes/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js').'"></script>',
      'jqueryvalidation' => '<script src="'.base_url('themes/plugins/jquery/jquery.validate.min.js').'"></script>',
      'toastr' => '<script src="'.base_url('themes/plugins/toastr/toastr.min.js').'"></script>',
      'particlesjs' => '<script src="'.base_url('themes/plugins/particlejs/particles.min.js').'"></script>',
      'datatable' => '<script src="'.base_url('themes/plugins/datatable/js/jquery.dataTables.min.js').'"></script>',
      'datatable4' => '<script src="'.base_url('themes/plugins/datatable/js/dataTables.bootstrap4.min.js').'"></script>',
      'datatableResponsive' => '<script src="'.base_url('themes/plugins/datatable/js/dataTables.responsive.min.js').'"></script>',
      'datatableResponsive4' => '<script src="'.base_url('themes/pluginsdatatable/js/responsive.bootstrap4.min.js').'"></script>',
      'columnfixed' => '<script src="'.base_url('themes/plugins/datatable/js/dataTables.fixedColumns.min.js').'"></script>',
      'datatableBtn' => '<script src="'.base_url('themes/plugins/datatable/js/dataTables.buttons.min.js').'"></script>',
      'datatableBtn4' => '<script src="'.base_url('themes/plugins/datatable/js/buttons.bootstrap4.min.js').'"></script>',
      'btnFlash' => '<script src="'.base_url('themes/plugins/datatable/js/buttons.flash.min.js').'"></script>',
      'jszip' => '<script src="'.base_url('themes/plugins/misc/jszip.min.js').'"></script>',
      'pdfmake' => '<script src="'.base_url('themes/plugins/misc/pdfmake.min.js').'"></script>',
      'vfsFont' => '<script src="'.base_url('themes/plugins/misc/vfs_fonts.js').'"></script>',
      'html5Btn' => '<script src="'.base_url('themes/plugins/datatable/js/buttons.html5.min.js').'"></script>',
      'btnPrint' => '<script src="'.base_url('themes/plugins/datatable/js/buttons.print.min.js').'"></script>',
      'btncolVis' => '<script src="'.base_url('themes/plugins/datatable/js/buttons.colVis.min.js').'"></script>',
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
