<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<?= \App\Libraries\Link::style()->fontawesome ?>
<?= \App\Libraries\Link::style()->adminlte ?>
<style type="text/css" id="debugbar_dynamic_style"></style>
<style>
@media (min-width: 768px){
    .dl-horizontal dt {
        float: left;
        width: 160px;
        overflow: hidden;
        clear: left;
        text-align: right;
        margin-right: 15px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
}
</style>
<link rel="shortcut icon" type="image/png" href="<?php echo base_url('themes/dist') ?>/img/AdminLTELogo.png"/>
<?php 
$uri = service('uri');
if($uri->getTotalSegments() > 1) {
  $title = $uri->getSegment(2) == '' ? ucfirst($uri->getSegment(1)) : ucfirst($uri->getSegment(1)). ' - ' .ucfirst($uri->getSegment(2));
}
else
{
  $title = $uri->getSegment(1) == '' ? ucfirst($uri->getAuthority(true)) : ucfirst($uri->getSegment(1));
}
?>
<title><?= $title ?></title>