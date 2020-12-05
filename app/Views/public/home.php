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
    "esri/views/MapView",
    "esri/layers/GeoJSONLayer",
    "esri/layers/GroupLayer",
    "esri/widgets/LayerList",
    "esri/widgets/Track",
    "esri/widgets/Expand",
    "esri/widgets/BasemapGallery",
    "esri/widgets/Fullscreen",
    "esri/widgets/Search",
    "esri/widgets/Editor",
    "esri/widgets/Legend",
    "dojo/dom-construct",
    "dojo/dom",
    "dojo/on",
    "esri/core/watchUtils"
  ], function (Map, MapView, GeoJSONLayer, GroupLayer, LayerList, Track, Expand, BasemapGallery, Fullscreen, Search, Editor, Legend, domConstruct, dom, on, watchUtils) {

    const url = "<?= $url ?>";
    const url_kec = "<?= $url_kec ?>";
    const url_desa = "<?= $url_desa ?>";
    const url_obs = "<?= $url_obs ?>";
    let editor, features;
    var dataKec = [], dataDesa = [], dataObs = [];
    var geojsonLayer;
    var legendSymbol = [], defSymbol = [];
    var dataHead = ["Kode petak","Nama responden","Nama Kelompok Tani","Nama kecamatan","Nama desa","Landuse",
    "Status lahan","Luas petak (m<sup>2</sup>)","NIK pemilik","Nama pemilik","Nama penggarap","Tipe irigasi",
    "Jarak dari sungai (m)","Jarak dari irigasi primer (m)","Lembaga pengelola air","Intensitas tanam","Index pertanaman (IP)",
    "Pola tanam","Permasalahan OPT","Permasalahan air","Permasalahan saprotan","Permasalahan lain",
    "Panen terbanyak (kuintal)","Bulan panen terbanyak","Panen terkecil (kuintal)","Bulan panen terkecil",
    "Penjualan panen","Surveyor","Update"];

    function createSymbol(color) {
      return {
        type: "simple-fill",
        color: color ? color : [0,0,0,0],
        outline: {
          width: 0.5,
          color: [255,255,255,0.5],
        }
      };
    }

    const template = {
      title: "Kode Petak: {FID}",
      content: getDetail
    };

    const lLanduse = [
      {
        value: "Sawah",
        symbol: createSymbol("#28a745"),
        label: "Sawah"
      }
    ];

    const lStatus = [
      {
        value: "MILIK",
        symbol: createSymbol("#28a745"),
        label: "Milik"
      },
      {
        value: "SEWA",
        symbol: createSymbol("#ffc107"),
        label: "Sewa"
      },
      {
        value: "GARAP",
        symbol: createSymbol("#dc3545"),
        label: "Garap"
      },
      {
        value: "LAINNYA",
        symbol: createSymbol("#17a2b8"),
        label: "Lainnya"
      }
    ];

    const map = new Map({
      basemap: "gray-vector"
    });

    const view = new MapView({
      container: "viewDiv",
      center: [106.518852, -6.120213],
      zoom: 10,
      map: map,
      popup: {
        dockOptions: {
          position: "bottom-right"
        }
      }
    });

    function getDetail(feature) {
      var obscode = feature.graphic.attributes.FID;
      $.ajax({
        async : false,
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        url : url_obs + '?obscode=' + obscode,
        type : 'GET',
        success : function(response){
          dataObs = JSON.parse(response);
        }
      });
      var div = document.createElement("div");
      var divContent = '<table class="esri-widget__table"><tbody>';
      for (var i = 0; i < dataHead.length; i++) {
        divContent += '<tr><th class="esri-feature-fields__field-header">' + dataHead[i] + '</th> \
        <td class="esri-feature-fields__field-data">' + Object.values(dataObs)[i] + '</td></tr>';
      }
      divContent += '</tbody></table>';
      divContent += '<p class="mt-3">Update terkahir oleh: ' + dataObs.username + '. Tanggal ' + dataObs.timestamp + '</p>';
      div.innerHTML = divContent;
      return div;
    }

    // Function action layer petak
    function defineActions(event) {
      var item = event.item;

      if (item.title === "Petak sawah") {
        item.actionsSections = [
          [{
            title: "Go to full extent",
            className: "esri-icon-zoom-out-fixed",
            id: "full-extent"
          }],
          [{
            title: "Increase opacity",
            className: "esri-icon-up",
            id: "increase-opacity"
          },{
            title: "Decrease opacity",
            className: "esri-icon-down",
            id: "decrease-opacity"
          }]
        ];
      }
    }

    view.when(function () {
      var popup = view.popup;

      // Function Format char to Title Case
      function toTitleCase(str) {
          return str.replace(
              /\w\S*/g,
              function(txt) {
                  return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
              }
          );
      }

      // Tombol Geolocation
      view.ui.add(
        new Track({
          view: view,
          useHeadingEnabled: false,
          goToLocationEnabled: false
        }), "top-left"
      );

      // Tombol Legenda
      const legend = new Expand({
        content: new Legend({
          view: view
        }),
        view: view
      });
      view.ui.add(legend, "top-left");

      // From Pencarian
      var searchWidget = new Search({
        view: view,
        includeDefaultSources: false
      });
      view.ui.add(searchWidget, "top-right");

      // Tombol Full Screen
      view.ui.add(
        new Fullscreen({
          view: view,
          element: viewDiv
        }), "top-right"
      );

      // Tombol Basemap
      const basemapGallery = new BasemapGallery({
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

      $.ajax({
        async : false,
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        url : url_kec,
        type : 'GET',
        success : function(response){
          dataKec = JSON.parse(response);
        }
      });

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

      // update search layer source
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
      function updateLayer(data, kec, desa){
        map.layers.removeAll();
        popup.close();

        const renderer = {
          type: "unique-value",
          field: $('#layerData option:selected').val(),
          legendOptions: {
            title: $('#layerData option:selected').text()
          },
          uniqueValueInfos: legendSymbol,
          defaultSymbol: createSymbol("grey"),
          defaultLabel: defSymbol
        };

        geojsonLayer = new GeoJSONLayer({
          url: url + "/info?table=v_observations&fid=obscode&shape=obsshape&fields=" + data + "&sdcode=" + kec + "&vlcode=" + desa,
          copyright: "Dinas Pertanian Kab. Tangerang",
          popupTemplate: template,
          renderer: renderer,
          title: "Petak sawah",
          opacity: .75
        });
        geojsonLayer.queryExtent().then(function(results){
          view.goTo(results.extent);
        });
        map.add(geojsonLayer);
        updateSearchSource();
        layerAdd.collapse();
      }

      var kecDom = '<div class="form-group input-group-sm" id="dataLayer"> \
        <label>Pilih jenis data</label> \
        <select class="form-control" id="layerData"> \
          <option value="areantatus">Status lahan</option> \
            <option value="landuse">Landuse</option> \
        </select> \
      </div> \
      <div class="form-group input-group-sm" id="kecForm"> \
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
      <div class="form-group input-group-sm" id="layerForm"><button id="applyLayer" type="submit" class="btn btn-block btn-sm btn-primary">Apply</button></div>';

      var node = domConstruct.create("div", {
        className: "esri-layer-list esri-widget esri-widget--panel",
        innerHTML: kecDom
      });

      const layerAdd = new Expand({
        view: view,
        expanded: false,
        expandIconClass: "esri-icon-collection",
        expandTooltip: "Add layer",
        content: node
       });

      view.ui.add(layerAdd, "top-left");

      legendSymbol = lStatus;
      defSymbol = "Null Data";

      watchUtils.whenTrueOnce(layerAdd, 'expanded', function(){

        on(dom.byId("layerData"), 'change', function(){
          switch($('#layerData option:selected').val()) {

            case 'areantatus':
              legendSymbol = lStatus;
              defSymbol = "Null Data";
            break;

            case 'landuse':
              legendSymbol = lLanduse;
              defSymbol = "Non Sawah";
            break;

          }
        });

        on(dom.byId("layerKec"), 'change', function(){
          if(this.value == ''){$("#desaForm").hide();}else{$("#desaForm").show();}
          getDesa(this.value);
        });

        on(dom.byId("applyLayer"), 'click', function(){
          updateLayer($("#layerData").val(), $("#layerKec").val(), $("#layerDesa").val());
        });

      });

      var layerList = new LayerList({
        view: view,
        listItemCreatedFunction: defineActions
      });

      view.ui.add(
        new Expand({
          view: view,
          content: layerList
        }),
        "top-left"
      );

      layerList.on("trigger-action", function (event) {

        var id = event.action.id;

        if (id === "full-extent") {
          view.goTo(geojsonLayer.fullExtent).catch(function (error) {
            if (error.name != "AbortError") {
              console.error(error);
            }
          });
        } else if (id === "increase-opacity") {
          if (geojsonLayer.opacity < 1) {
            geojsonLayer.opacity += 0.25;
          }
        } else if (id === "decrease-opacity") {
          if (geojsonLayer.opacity > 0) {
            geojsonLayer.opacity -= 0.25;
          }
        }
      });

    });

  });
</script>
<?= $this->endSection() ?>
