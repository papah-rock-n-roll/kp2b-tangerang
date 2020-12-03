<?= $this->extend('partials/index') ?>
<?= $this->section('content') ?>
<div class="row">

  <div class="col-md-6"><!-- LEFT col-md-6 -->
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <p>User Agent</p>
        </div>
        <?php $ua = json_decode($v['useragent'], true) ?>

        <h3 class="profile-username text-center"><?= $ua['ip'] ?></h3>
        <p class="text-muted text-center"><?= $ua['st'] ?></p>

        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Platform</b> <a class="float-right"><?= $ua['pf'] ?></a>
          </li>
          <li class="list-group-item">
            <b>Browser</b> <a class="float-right"><?= $ua['bw'] ?></a>
          </li>
          <li class="list-group-item">
            <b>Robot</b> <a class="float-right"><?= $ua['rb'] ?></a>
          </li>
          <li class="list-group-item">
            <b>Mobile</b> <a class="float-right"><?= $ua['mb'] ?></a>
          </li>
        </ul>

        <a href="<?= $back ?>" class="btn btn-primary btn-block"><b>Okay</b></a>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <p>Remote Address</p>
        </div>
        <?php $ra = json_decode($v['remoteaddr'], true) ?>

        <h3 class="profile-username text-center"><?= $ra['ct'] ?></h3>
        <p class="text-muted text-center">lat: <?= $ra['lat'] ?> - lon: <?= $ra['lon'] ?></p>
        <p class="text-muted text-center"><?= $ra['isp'] ?></p>

        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>OS</b>
          </li>
          <?php foreach ($ra['os'] as $osK => $osV) : ?> 
          <li class="list-group-item">
            <?= $osK ?> <a class="float-right"><?= $osV ?></a>
          </li>
          <?php endforeach ?>
        </ul>

        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Device</b>
          </li>
          <?php foreach ($ra['device'] as $dcK => $dcV) : ?> 
          <li class="list-group-item">
            <?= $dcK ?> <a class="float-right"><?= $dcV ?></a>
          </li>
          <?php endforeach ?>
        </ul>

        <a href="<?= $back ?>" class="btn btn-primary btn-block"><b>Okay</b></a>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </div>

  <div class="col-md-6"><!-- RIGHT col-md-6 -->
    
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-rounded"
            src="<?= base_url('uploads/users/'.$v['image']) ?>"
            alt="User profile picture">
        </div>
        <h6 class="profile-username text-center">
          <?= $v['name'] ?><br>
          <small><?= $v['email'] ?></small>
        </h6>

        <p class="text-muted text-center">
          <?= $v['table'] ?><br>
          <span class="badge badge-primary"><?= strtoupper($v['watch']) ?> </span> - <span class="badge badge-warning">ID <?= $v['dataid'] ?></span><br>
          <?= $v['timestamp'] ?>
        </p>

        <?php $desc = json_decode($v['description'], true) ?>

        <ul class="list-group list-group-unbordered mb-3">
          <?php foreach ($desc as $descK => $descV) : ?>

            <?php if(!empty($descV)) : ?>

              <?php if(is_array($descV)) : ?>

                <li class="list-group-item">
                  <b><?= ucfirst($descK) ?></b>
                </li>

                <?php foreach ($descV as $arrK => $arrV) : ?>

                  <?php if(is_array($arrV)) : ?>
                    <li class="list-group-item">
                      <?= $arrK ?> <a class="float-right"><?= implode(', ', $arrV) ?></a>
                    </li>
                  <?php else: ?>
                  <li class="list-group-item">
                    <?= $arrK ?> <a class="float-right"><?= $arrV ?></a>
                  </li>
                  <?php endif ?>

                <?php endforeach ?>

              <?php else : ?> 

                <li class="list-group-item">
                  <b><?= ucfirst($descK) ?></b>
                </li>
                <?php foreach ($descV as $nK => $nV) : ?> 

                  <?php if(is_array($nV)) : ?>
                  <li class="list-group-item">
                    <?= $nK ?> <a class="float-right"><?= implode(', ', $nV) ?></a>
                  </li>
                  <?php else : ?>
                  <li class="list-group-item">
                    <?= $nK ?> <a class="float-right"><?= $nV ?></a>
                  </li>
                  <?php endif ?>

                <?php endforeach ?>

              <?php endif ?>
            <?php endif ?>
          <?php endforeach ?>
        </ul>

        <a href="<?= $back ?>" class="btn btn-primary btn-block"><b>Okay</b></a>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </div>

</div>
<?= $this->endSection() ?>