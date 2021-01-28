<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0" />
<title>geobuf test(canvas)</title>
<script src="https://unpkg.com/pbf@3.0.5/dist/pbf.js" ></script>
<script src="https://unpkg.com/geobuf@3.0.2/dist/geobuf.js" ></script>
</head>

<body>
<div id="map"></div>

<?= $this->include('public/partials/script') ?>
<?= $this->renderSection('script') ?>

<script>
  $.ajax({
    type : 'GET',
    dataType: "json",
    url : "https://kp2b-tangerang.ga/api/geo/info?table=v_observations&fid=obscode&shape=obsshape&fields=landuse&sdcode=360308&vlcode=3603081002",
    complete : function(response){
      var buffer = geobuf.encode(response, new Pbf());
      var geojson = geobuf.decode(new Pbf(buffer));
      console.log(geojson.responseText);
    }
  });
</script>
</body>
</html>
