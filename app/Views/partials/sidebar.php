<?php 
$uri = service('uri');
$urisegment = $uri->getSegment(2);

$panel = 'administrator';
$modules['menus'] = session('menus');

if($urisegment == 'dashboard') {
  $menus = array();
}
else
{
  $menus = array_values($modules['menus'][$urisegment]);
}
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="/" class="brand-link">
    <img src="<?php echo base_url('themes/dist') ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">KP2B</span>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url('themes/dist') ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= session('name') ?></a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="/dashboard" class="nav-link <?= $urisegment == 'dashboard' ? 'active': '' ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <?php if($urisegment == 'dashboard') : ?>
          <li class="nav-header"><?= ucfirst($urisegment) ?></li>
        <?php else: ?>
          <li class="nav-header"><?= ucfirst($urisegment) ?></li>
            <?php foreach ($menus as $v) : ?>
            <li class="nav-item">
              <a href="<?= base_url($panel.'/'.$v) ?>" class="nav-link">
                <i class="nav-icon far fa-circle text-default"></i>
                <p class="text"><?= ucfirst($v) ?></p>
              </a>
            </li>
            <?php endforeach ?>
        <?php endif ?>
      </ul>
    </nav>
  </div>
</aside>