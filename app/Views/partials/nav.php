<?php 
$uri = service('uri');
$adminpanel = $uri->getSegment(1);
$nav = array_keys(session('privilage')->menus);
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <?php foreach ($nav as $v): ?>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url($adminpanel.'/'.$v)?>" class="nav-link"><?= ucfirst($v) ?></a>
      </li>
    <?php endforeach ?>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="fas fa-th-large"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <?php foreach ($nav as $v): ?>
          <a href="<?= base_url($adminpanel.'/'.$v)?>" class="dropdown-item"> <?= ucfirst($v) ?></a>
        <?php endforeach ?>
        <div class="dropdown-divider"></div>
        <a href="/logout" class="dropdown-item">Logout<i class="float-right fas fa-lock p-1"></i></a>
      </div>
    </li>
  </ul>
</nav>