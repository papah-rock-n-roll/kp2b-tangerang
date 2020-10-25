<?php $uri = service('uri') ?>
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
        <a href="#" class="d-block"><?= 'test' //session('username') ?></a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="/1" class="nav-link <?php echo $uri->getSegment(1) == '1' ? 'active': '' ?>">
            <i class="nav-icon fas fa-tags"></i>
            <p>1</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/2" class="nav-link <?php echo $uri->getSegment(1) == '2' ? 'active': '' ?>">
            <i class="nav-icon fas fa-tags"></i>
            <p>2</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/3" class="nav-link <?php echo $uri->getSegment(1) == '3' ? 'active': '' ?>">
            <i class="nav-icon fas fa-tags"></i>
            <p>3</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/4" class="nav-link <?php echo $uri->getSegment(1) == '4' ? 'active': '' ?>">
            <i class="nav-icon fas fa-tags"></i>
            <p>4</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>