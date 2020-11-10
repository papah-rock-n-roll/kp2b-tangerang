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

    <?php echo form_open() ?>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Your Session has been Block</p>
        
          <div class="alert alert-danger">
            <h5><i class="icon fas fa-times-circle"></i> Alert!</h5>
            Terimakasih <br> Silahkan di coba lagi <br>
            <small> Di Hari Berikutnya</small>
          </div>

        <div class="input-group mb-3">
          <?php
          $email = [
            'type'  => 'email',
            'class' => 'form-control',
            'placeholder' => 'Enter Your Email',
            'disabled' => ''
          ];
          echo form_input($email); 
          ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <?php
          $password = [
            'type'  => 'password',
            'class' => 'form-control',
            'placeholder' => 'Password',
            'disabled' => ''
          ];
          echo form_input($password); 
          ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
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