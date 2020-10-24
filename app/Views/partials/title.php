<?php
$uri = service('uri');
$title = $uri->getSegment(1) == '' ? ucfirst($uri->getAuthority(true)) : ucfirst($uri->getSegment(1));
?>
<h1 class="m-0 text-dark"><?= $title ?></h1>