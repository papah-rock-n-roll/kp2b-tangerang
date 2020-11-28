<?php
$uri = service('uri');
$adminpanel = $uri->getSegment(1);
$urisegment = $uri->getSegment(2);

if($urisegment == 'dashboard')
  $menus = array();
else $menus = session('privilage')->menus[$urisegment];
?>

<aside class="main-sidebar sidebar-dark-primary">
  <a href="#" class="brand-link">
    <img src="<?= base_url('themes/dist/img/logo.png') ?>" alt="Logo" class="brand-image">
    <span class="brand-text font-weight-light"><?= session('privilage')->rolename ?></span>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url('uploads/users/'. session('privilage')->image) ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <?php $name = str_word_count(session('privilage')->name, 1) ?>
        <a href="#" class="d-block"><?= count($name) < 2 ? $name[0] : $name[0] .' '. $name[1] ?></a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?= base_url($adminpanel.'/dashboard') ?>" class="nav-link <?= $urisegment == 'dashboard' ? 'active': '' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <?php if($urisegment == 'dashboard') : ?>
          <li class="nav-header"><?= ucfirst($urisegment) ?></li>
        <?php else: ?>
          <li class="nav-header"><?= ucfirst($urisegment) ?></li>
            <?php foreach ($menus as $k => $v) : ?>
            <li class="nav-item">
              <a href="<?= base_url($adminpanel.'/'.$urisegment.'/'.$k) ?>" class="nav-link">
                <i class="nav-icon far fa-circle text-default"></i>
                <p class="text"><?= ucwords($v) ?></p>
              </a>
            </li>
            <?php endforeach ?>
        <?php endif ?>
      </ul>
    </nav>
  </div>
</aside>