<div class="mb-3 card card-widget widget-user-2">
  <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header bg-warning">
    <div class="widget-user-image">
      <img class="img-circle elevation-2" src="<?= site_url('uploads/users/' . $image) ?>" alt="User Avatar">
    </div>
    <!-- /.widget-user-image -->
    <h3 class="widget-user-username"><?= esc($name) ?></h3>
    <h5 class="widget-user-desc"><?= esc($rolename) == null ? '<small class="badge badge-danger">New Register</small>' : esc($rolename) ?></h5>
  </div>
  <div class="card-body p-0">
    <ul class="nav flex-column">
      <li class="nav-item">
        <p class="nav-link">
          Observations <span class="float-right badge bg-primary p-2"><?= $observations ?></span>
          <br><?= $usernik ?>
        </p>
      </li>
    </ul>
  </div>
</div>