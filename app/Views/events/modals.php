<div class="modal fade" id="<?= esc($id) ?>">
  <div class="modal-dialog <?= esc($size) ?>">
    <div class="modal-content <?= esc($class) ?>">
      <div class="modal-header">
        <h4 class="modal-title"><?= $title ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><?= $bodytext ?></p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-default" onclick="window.location.href='<?= esc($action) ?>'">Confirm</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->