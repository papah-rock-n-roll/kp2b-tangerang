<?= \App\Libraries\Link::script()->jquery ?>
<?= \App\Libraries\Link::script()->bootstrap ?>
<?= \App\Libraries\Link::script()->adminlte ?>

<?php if(session()->has('privilage')) : ?>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
<?= session('privilage')->disable ?>
<?= PHP_EOL ?>
});
</script>
<?php endif ?>