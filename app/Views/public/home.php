<?= $this->extend('public/partials/index') ?>

<?= $this->section('link') ?>
<style>html, body, #viewDiv {padding:0;margin:0;height:calc(100vh - 57px);width:100%;}</style>
<?= \App\Libraries\Link::style()->arcgis ?>
<?= \App\Libraries\Link::style()->select2 ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div id="viewDiv"></div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= \App\Libraries\Link::script()->select2 ?>
<?= \App\Libraries\Link::script()->arcgis ?>
<script>
  require([
    "esri/Map",
    "esri/layers/GeoJSONLayer",
    "esri/views/MapView",
    "esri/widgets/Locate",
    "esri/widgets/Expand",
    "esri/widgets/BasemapGallery",
    "esri/widgets/Fullscreen",
    "esri/widgets/Search",
    "esri/widgets/Editor",
    "dojo/dom-construct",
    "dojo/dom",
    "dojo/on",
    "esri/core/watchUtils"
  ], function (Map, GeoJSONLayer, MapView, Locate, Expand, BasemapGallery, Fullscreen, Search, Editor, domConstruct, dom, on, watchUtils) {

    const url = "<?= $url ?>";
    const url_kec = "<?= $url_kec ?>";
    const url_desa = "<?= $url_desa ?>";
    let editor, features;
    var dataKec = [], dataDesa = [];
    var geojsonLayer;

    const editThisAction = {
      title: "View details",
      id: "view-this",
      className: "esri-icon-description"
    };

    const template = {
      title: "Kode Petak: {FID}",
      actions: [editThisAction]
    };

    const renderer = {
      type: "simple",
      field: "FID",
      symbol: {
        type: "simple-fill",
        color: "green",
        outline: {
          color: "white"
        }
      }
    };

    const map = new Map({
      basemap: "gray-vector"
    });

    const view = new MapView({
      container: "viewDiv",
      center: [106.518852, -6.120213],
      zoom: 10,
      map: map
    });

    view.when(function () {
      var popup = view.popup;
      var searchWidget = new Search({
        view: view,
        includeDefaultSources: false
      });

      view.ui.add(searchWidget, {
        position: "top-right"
      });

      view.ui.add(
        new Fullscreen({
          view: view,
          element: viewDiv
        }),
        "top-right"
      );

      view.ui.add(
        new Locate({
          view: view,
          element: viewDiv
        }),
        "top-right"
      );

      const basemapGallery = new BasemapGallery({
        source: {
          query: {
            id: '702026e41f6641fb85da88efe79dc166'
          }
        },
        view: view,
        container: document.createElement("div")
      });

      view.ui.add(
        new Expand({
          view: view,
          content: basemapGallery
        }),
        "bottom-left"
      );

      view.popup.on("trigger-action", function (event) {
        if (event.action.id === "view-this") {
          alert("Detail");
        }
      });

      $.ajax({
        async : false,
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        url : url_kec,
        type : 'GET',
        success : function(response){
          dataKec = JSON.parse(response);
        }
      });

      // Format char to Title Case
    	function toTitleCase(str) {
          return str.replace(
              /\w\S*/g,
              function(txt) {
                  return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
              }
          );
      }

      // get List Desa
      function getDesa(sdcode = ''){
        $.ajax({
          async : false,
          headers: {'X-Requested-With': 'XMLHttpRequest'},
          url : url_desa + '?sdcode=' + sdcode,
          type : 'GET',
          success : function(response){
            dataDesa = JSON.parse(response);
          }
        });
        var desaDom = '<option value="">Semua desa</option>';
        for (var i = 0; i < dataDesa.length; i++) {
          var optDesa = '<option value="' + dataDesa[i].vlcode + '"> ' + toTitleCase(dataDesa[i].vlname) + ' </option>';
          desaDom = desaDom + optDesa;
        }
        $('#layerDesa').html(desaDom);
      }

      function updateSearchSource(){
        const sources = [
          {
            layer: geojsonLayer,
            searchFields: ["FID"],
            suggestionTemplate: "Kode Petak: {FID}",
            displayField: "FID",
            exactMatch: false,
            outFields: ["FID"],
            name: "Kode petak",
            placeholder: "Cari kode petak"
          }
        ];
        searchWidget.sources = sources;
      }

      // Update layers
      function updateLayer(kec, desa){
        map.layers.removeAll();
        popup.close();
        geojsonLayer = new GeoJSONLayer({
          url: url + "/info?table=v_observations&fid=obscode&shape=obsshape&sdcode=" + kec + "&vlcode=" + desa,
          copyright: "Dinas Pertanian Kab. Tangerang",
          popupTemplate: template,
          renderer: renderer,
          title: "Petak LP2B"
        });
        geojsonLayer.queryExtent().then(function(results){
          view.goTo(results.extent);
        });
        map.add(geojsonLayer);
        updateSearchSource();
        layerAdd.collapse();
      }

      var kecDom = '<div class="form-group input-group-sm" id="kecForm"> \
        <label>Pilih kecamatan</label> \
        <select class="form-control" id="layerKec"> \
          <option value="">Semua kecamatan</option>';
          for (var i = 0; i < dataKec.length; i++) {
            var opt = '<option value="' + dataKec[i].sdcode + '"> ' + toTitleCase(dataKec[i].sdname) + ' </option>';
            kecDom = kecDom + opt;
        	}
        kecDom = kecDom + '</select> \
      </div> \
      <div class="form-group input-group-sm" id="desaForm" style="display: none;"> \
        <label>Pilih desa</label> \
        <select class="form-control" id="layerDesa"> \
          <option value="">Semua desa</option> \
        </select> \
      </div> \
      <div class="form-group input-group-sm" id="layerForm"><button id="applyLayer" type="submit" class="btn btn-primary btn-xs">Apply</button></div>';

      var node = domConstruct.create("div", {
        className: "esri-layer-list esri-widget esri-widget--panel",
        innerHTML: kecDom
      });

      const layerAdd = new Expand({
        view: view,
        expanded: false,
        expandIconClass: "esri-icon-layers",
        expandTooltip: "Add layer",
        content: node
       });

      view.ui.add(layerAdd, "top-left");

      watchUtils.whenTrueOnce(layerAdd, 'expanded', function(){
        on(dom.byId("layerKec"), 'change', function(){
          if(this.value == ''){$("#desaForm").hide();}else{$("#desaForm").show();}
          getDesa(this.value);
        });
        on(dom.byId("applyLayer"), 'click', function(){
          updateLayer($("#layerKec").val(), $("#layerDesa").val());
        });
      });

    });

  });
</script>
<?= $this->endSection() ?>
