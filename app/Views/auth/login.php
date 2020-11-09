<!DOCTYPE html>
<html lang="en">
<head>
<?= $this->include('partials/head') ?>
</head>
<body class="hold-transition login-page">

  <div class="login-box">
    <div class="login-logo">
      <a href="/"><b><strong>KP2B</strong> Tangerang</b></a>
      <?php echo form_open($action) ?>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        
        <?php if($error = session()->getFlashdata('errors')) : ?>
          <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
            <?php echo esc($error); ?>
          </div>
        <?php endif ?>

        <?php if($success_register = session()->getFlashdata('success_register')) : ?>
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-success text-center">
                <?php echo $success_register; ?>
              </div>
            </div>
          </div>
        <?php endif ?>

        <div class="input-group mb-3">
          <?php
          $email = [
            'type'  => 'email',
            'class' => $validation->hasError('email') ? 'form-control is-invalid' : 'form-control',
            'name'  => 'email',
            'value' => old('email') == null ? '' : old('email'),
            'placeholder' => 'Enter Your Email'
          ];
          echo form_input($email); 
          ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          <div class="invalid-feedback">
          <?= $validation->getError('email') ?>
          </div>
        </div>
        <div class="input-group mb-3">
          <?php
          $password = [
            'type'  => 'password',
            'class' => $validation->hasError('password') ? 'form-control is-invalid' : 'form-control',
            'name'  => 'password',
            'value' => '',
            'placeholder' => 'Password'
          ];
          echo form_input($password); 
          ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <div class="invalid-feedback">
          <?= $validation->getError('password') ?>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>

        <div class="row mb-2">  
          <div class="col-12">
            <button type="button" class="btn btn-success btn-block" onclick="window.location.href='<?= esc($register)  ?>'">Register</button>
          </div>  
        </div>

        <div class="dropdown-divider"></div>
        <div class="row mt-3">
          <div class="col-12">            
            <button type="button" class="btn btn-default btn-block" onclick="window.location.href='/'">Back</button>
          </div>
        </div>
      </div>

      </div>
    </div>
    <?php echo form_close() ?>

  </div>
  
<?= $this->include('partials/script') ?>
</body>
</html>