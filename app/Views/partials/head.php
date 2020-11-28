<?= \App\Libraries\Link::style()->fontawesome ?>
<?= \App\Libraries\Link::style()->adminlte ?>
<?= \App\Libraries\Link::style()->sourcesand ?>
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
<link rel="shortcut icon" type="image/png" href="<?= base_url('themes/dist/img/favicon.ico') ?>"/>
<?php
$uri = service('uri');
if($uri->getTotalSegments() > 1) 
{
  $title = $uri->getSegment(2) == '' ? ucfirst($uri->getSegment(1)) : ucfirst($uri->getSegment(1)). ' - ' .ucfirst($uri->getSegment(2));
}
else
{
  $title = $uri->getSegment(1) == '' ? ucfirst($uri->getHost()) : ucfirst($uri->getSegment(1));
}
?>
<title><?= $title ?></title>