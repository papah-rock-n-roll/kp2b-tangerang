<?= \App\Libraries\Link::script()->jquery ?>
<?= \App\Libraries\Link::script()->bootstrap ?>
<?= \App\Libraries\Link::script()->adminlte ?>

<script type="text/javascript">
<?php if(session()->has('privilage')) : ?>
  <?php foreach (session('privilage')->acts as $v) : ?>
    <?= '$(".tmb-'.$v.'").remove();' ?>
  <?php endforeach ?>
<?php endif ?>
</script>