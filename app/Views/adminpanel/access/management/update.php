<?= $this->extend('partials/index') ?>
<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Update User</h5>
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
                'value' => old('name') == null ? $v['name'] : old('name'),
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
                'value' => old('usernik') == null ? $v['usernik'] : old('usernik'),
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
                'value' => old('phone') == null ? $v['phone'] : old('phone'),
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
                'value' => old('email') == null ? $v['email'] : old('email'),
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
                'type' => 'text',
                'name' => 'password',
                'minlength' => '6',
                'placeholder' => 'Enter your password',
                'value' => old('realpassword') == null ? $v['realpassword'] : old('realpassword'),
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
              $selected = old('roleid') == null ? $v['roleid'] : old('roleid');
              echo form_dropdown('roleid', $roles, $selected, ['class' => 'custom-select', 'required' => '']);
              ?>
            </div>
            <div class="form-group">
              <label for="">Status</label>
              <select name="sts" class="custom-select" required>
                <option value="">Choose Status</option>
                <?php $status = old('sts') == null ? $v['sts'] : old('sts') ?>
                <option <?= $status == 'Active' ? 'selected' : '' ?> value="Active">Active</option>
                <option <?= $status == 'Inactive' ? 'selected' : '' ?> value="Inactive">Inactive</option>
            </select>
            </div>
            <div class="form-group">
             <label for="">Image</label>
              <?php 
                $scr = site_url('uploads/users/'); 
                $img = $v['image'] == 'default.png' ? 'default.png' : $v['image'];
              ?>
              <input type="hidden" name="oldimage" value="<?= $img ?>">
              <div class="custom-file">
                <?php echo form_label($img, 'image', ['class' => $validation->hasError('image') ? 'custom-file-label form-control is-invalid' : 'custom-file-label form-control']); ?>
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
                <img src="<?= $scr . $img ?>" alt="Thumbnail" class="img-fluid" style="height:128px;width:128px">
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
  'class' => 'bg-info',
  'autohide' => 'true',
  'delay' => '5000',
  'title' => 'Update',
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