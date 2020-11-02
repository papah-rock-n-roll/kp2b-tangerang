<?= $this->extend('public/partials/index') ?>

<?= $this->section('link') ?>
<style>html, body, #viewDiv {padding:0;margin:0;height:calc(100vh - 57px);width:100%;}</style>
<?= \App\Libraries\Link::style()->arcgis ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div id="viewDiv"></div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= \App\Libraries\Link::script()->arcgis ?>
<script>
  require([
    "esri/Map",
    "esri/layers/GeoJSONLayer",
    "esri/views/MapView",
    "esri/widgets/LayerList",
    "esri/widgets/Locate",
    "esri/widgets/Expand",
    "esri/widgets/BasemapGallery",
    "esri/widgets/Fullscreen",
    "esri/widgets/Search",
    "dojo/dom-construct",
    "dojo/dom",
    "dojo/on",
    "esri/core/watchUtils"
  ], function (Map, GeoJSONLayer, MapView, LayerList, Locate, Expand, BasemapGallery, Fullscreen, Search, domConstruct, dom, on, watchUtils) {

    const url = "<?= $url ?>";
    const url_kec = "<?= $url_kec ?>";
    let editor, features;
    var dataKec = [];
    var kecDom = '';

    const template = {
      title: "Kode Petak: {FID}"
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

    const geojsonLayer = new GeoJSONLayer({
      url: url,
      copyright: "Dinas Pertanian Kab. Tangerang",
      popupTemplate: template,
      renderer: renderer,
      title: "Kecamatan Sukadiri"
    });

    const map = new Map({
      basemap: "gray-vector",
      layers: [geojsonLayer]
    });

    const view = new MapView({
      container: "viewDiv",
      center: [106.518852, -6.120213],
      zoom: 11,
      map: map
    });

    view.when(function () {
      var searchWidget = new Search({
        view: view,
        includeDefaultSources: false,
        sources: [
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
        ]
      });

      view.ui.add(searchWidget, {
        position: "top-right"
      });

      var layerList = new LayerList({
        view: view
      });

      view.ui.add(
        new Expand({
          view: view,
          content: layerList
        }),
        "top-left"
      );

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

    for (var i = 0; i < dataKec.length; i++) {
      var opt = '<div class="checkbox"><label><input type="checkbox" value="' + dataKec[i].sdcode + '"> ' + dataKec[i].sdname + ' </label></div>';
      kecDom = kecDom + opt;
  	}

    var node = domConstruct.create("div", {
      className: "esri-layer-list esri-widget esri-widget--panel",
      innerHTML: kecDom
    });

    view.ui.add(
      new Expand({
        view: view,
        expanded: false,
        expandTooltip: "Tambah layer petak sawah",
        content: node
      }),
      "top-left"
    );

  });
</script>
<?= $this->endSection() ?>
