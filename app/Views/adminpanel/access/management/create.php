<?= $this->extend('partials/index') ?>
<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Create User</h5>
      </div>

      <?php echo form_open_multipart($action) ?>
      <div class="card-body">

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="">Name</label>
              <?php
              $name = [
                'class' => $validation->hasError('name') ? 'form-control is-invalid' : 'form-control',
                'name' => 'name',
                'minlength' => '3',
                'placeholder' => 'Enter your name',
                'value' => old('name'),
                'required' => ''
              ];
              echo form_input($name);
              ?>
              <div class="invalid-feedback">
              <?= $validation->getError('name') ?>
              </div>
            </div>
            <div class="form-group">
              <label for="">NIK</label>
              <?php
              $nik = [
                'class' => $validation->hasError('usernik') ? 'form-control is-invalid' : 'form-control',
                'name' => 'usernik',
                'minlength' => '3',
                'placeholder' => 'Enter your NIK',
                'value' => old('usernik'),
                'required' => ''
              ];
              echo form_input($nik);
              ?>
              <div class="invalid-feedback">
              <?= $validation->getError('usernik') ?>
              </div>
            </div>
            <div class="form-group">
              <label for="">Phone</label>
              <?php
              $phone = [
                'class' => $validation->hasError('phone') ? 'form-control is-invalid' : 'form-control',
                'name' => 'phone',
                'minlength' => '1',
                'placeholder' => 'Enter your phone number',
                'value' => old('phone'),
                'required' => ''
              ];
              echo form_input($phone);
              ?>
              <div class="invalid-feedback">
              <?= $validation->getError('phone') ?>
              </div>
            </div>
            <div class="form-group">
              <label for="">Email</label>
              <?php
              $email = [
                'class' => $validation->hasError('email') ? 'form-control is-invalid' : 'form-control',
                'type' => 'email',
                'name' => 'email',
                'placeholder' => 'Enter your email',
                'value' => old('email'),
                'required' => ''
              ];
              echo form_input($email);
              ?>
              <div class="invalid-feedback">
              <?= $validation->getError('email') ?>
              </div>
            </div>
            <div class="form-group">
              <label for="">Password</label>
              <?php
              $password = [
                'class' => $validation->hasError('password') ? 'form-control is-invalid' : 'form-control',
                'type' => 'input',
                'name' => 'password',
                'minlength' => '6',
                'placeholder' => 'Enter your password',
                'value' => old('password'),
                'required' => ''
              ];
              echo form_input($password);
              ?>
              <div class="invalid-feedback">
              <?= $validation->getError('password') ?>
              </div>
            </div>
            
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="">Role</label>
              <?php
              $selected = old('roleid') == null ? '' : old('roleid');
              echo form_dropdown('roleid', $roles, $selected, ['class' => 'custom-select', 'required' => '']);
              ?>
            </div>
            <div class="form-group">
              <label for="">Status</label>
              <select name="sts" class="custom-select" required>
                <option value="">Choose Status</option>
                <option <?= old('sts') == 'Active' ? 'selected' : '' ?> value = "Active">Active</option>
                <option <?= old('sts') == 'Inactive' ? 'selected' : '' ?> value = "Inactive">Inactive</option>
              </select>
            </div>
            <div class="form-group">
             <label for="">Image</label>
              <div class="custom-file">
                <?php $custom = $validation->hasError('image') ? 'custom-file-label form-control is-invalid' : 'custom-file-label form-control' ?>
                <label class="<?= $custom ?>" for="image">Choose file</label>
                <?php
                $image = [
                  'id' => 'image',
                  'class' => 'custom-file-input',
                  'name' => 'image',
                  'accept' => '.jpg,.jpeg,.png,.gif',
                  'onchange' => 'thumbnail()',
                ];
                echo form_upload($image);
                ?>
                <div class="invalid-feedback">
                <?= $validation->getError('image') ?>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div>
                <img src="/uploads/users/default.png" alt="Thumbnail" class="img-fluid">
              </div>
            </div>

          </div>
        </div>

      </div>   
      <div class="card-footer">
        <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= esc($back) ?>'">Back</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      <?php echo form_close() ?>

    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?php
if(! empty(session()->getFlashdata('success'))) {
  $toast = [
  'class' => 'bg-success',
  'autohide' => 'true',
  'delay' => '5000',
  'title' => 'Create Product',
  'subtitle' => '',
  'body' => session()->getFlashdata('success'),
  'icon' => 'icon fas fa-file-alt',
  'image' => '',
  'imageAlt' => '',
  ];
  echo view('events/toasts', $toast);
}
?>
<script>
function thumbnail() {

  const image = document.querySelector('#image');
  const imageLabel = document.querySelector('.custom-file-label');
  const imageThumbnail = document.querySelector('.img-fluid');

  imageLabel.textContent = image.files[0].name;

  const imageFile = new FileReader();
  imageFile.readAsDataURL(image.files[0]);

  imageFile.onload = function(e) {
    imageThumbnail.src = e.target.result;
  }
}
</script>
<?= $this->endSection() ?>