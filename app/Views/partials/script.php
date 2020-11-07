<?= \App\Libraries\Link::script()->jquery ?>
<?= \App\Libraries\Link::script()->bootstrap ?>
<?= \App\Libraries\Link::script()->adminlte ?>

<script type="text/javascript">
<?php if(session()->has('privilage')) : ?>
<?= session('privilage')->disable ?>
<?= PHP_EOL ?>
<?php endif ?>
</script>