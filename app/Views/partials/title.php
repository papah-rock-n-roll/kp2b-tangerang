<?php
$uri = service('uri');
if ($uri->getTotalSegments() > 2) 
{
  $title = $uri->getSegment(3) == '' ? ucfirst($uri->getSegment(2)) : ucfirst($uri->getSegment(3));
}
else
{
  $title = $uri->getSegment(2) == '' ? ucfirst($uri->getSegment(1)) : ucfirst($uri->getSegment(2));
}
?>
<h1 class="m-0 text-dark"><?= $title ?></h1>