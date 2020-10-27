<?php
$uri = service('uri');
$title = $uri->getSegment(2) == '' ? ucfirst($uri->getSegment(1)) : ucfirst($uri->getSegment(2));
?>
<h1 class="m-0 text-dark"><?= $title ?></h1>