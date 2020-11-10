<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<?= $this->include('partials/head') ?>
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="/"><b><strong>KP2B</strong> Tangerang</b></a>
    </div>

    <?php echo form_open($action) ?>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Register to create your account</p>

        <div class="input-group mb-3">
          <?php
            $usernik = [
              'type'  => 'text',
              'class' => $validation->hasError('usernik') ? 'form-control is-invalid' : 'form-control',
              'name'  => 'usernik',
              'value' => old('usernik') == null ? '' : old('usernik'),
              'placeholder' => 'Enter Your NIK'
            ];
            echo form_input($usernik); 
          ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-address-card"></span>
            </div>
          </div>
          <div class="invalid-feedback">
          <?= $validation->getError('usernik') ?>
          </div>
        </div>
        <div class="input-group mb-3">
          <?php
            $name = [
              'type'  => 'text',
              'class' => $validation->hasError('name') ? 'form-control is-invalid' : 'form-control',
              'name'  => 'name',
              'value' => old('name') == null ? '' : old('name'),
              'placeholder' => 'Enter Your Name'
            ];
            echo form_input($name); 
          ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          <div class="invalid-feedback">
          <?= $validation->getError('name') ?>
          </div>
        </div>
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
        <div class="input-group mb-3">
          <?php
          $confirm_password = [
            'type'  => 'password',
            'class' => $validation->hasError('confirm_password') ? 'form-control is-invalid' : 'form-control',
            'name'  => 'confirm_password',
            'value' => '',
            'placeholder' => 'Retype Password'
          ];
          echo form_input($confirm_password); 
          ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <div class="invalid-feedback">
          <?= $validation->getError('confirm_password') ?>
          </div>
        </div>

        <div class="row mb-2">  
          <div class="col-12">
            <button type="submit" class="btn btn-success btn-block">Register</button>
          </div>  
        </div>

        <div class="dropdown-divider"></div>
        <div class="row mt-3">
          <div class="col-12">            
            <button type="button" class="btn btn-default btn-block" onclick="window.location.href='<?= esc($cancel) ?>'">Cancel</button>
          </div>
        </div>

      </div>
    </div>
    <?php echo form_close() ?>

  </div>
<?= $this->include('partials/script') ?>
</body>
</html>