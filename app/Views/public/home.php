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
    "esri/widgets/Editor",
    "esri/widgets/BasemapGallery",
    "esri/widgets/Fullscreen",
    "dojo/dom-construct",
    "dojo/dom",
    "dojo/on",
    "esri/core/watchUtils"
  ], function (Map, GeoJSONLayer, MapView, LayerList, Locate, Expand, Editor, BasemapGallery, Fullscreen, domConstruct, dom, on, watchUtils) {

    const url = "<?= $url ?>";
    const url_kec = "<?= $url_kec ?>";
    let editor, features;
    var dataKec = [];
    var kecDom = '';

    const editThisAction = {
      title: "Edit feature",
      id: "edit-this",
      className: "esri-icon-edit"
    };

    const template = {
      title: "Detail Petak : {KODE}",
      content: "Kode Petak: {KODE}<br>Kelompok Tani: {POKTAN}",
      actions: [editThisAction]
    };

    const renderer = {
      type: "simple",
      field: "POKTAN",
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
      zoom: 12,
      map: map
    });

    view.when(function () {
      var layerList = new LayerList({
        view: view
      });

      var lsExpand = new Expand({
        view: view,
        content: layerList
      });

      view.ui.add(lsExpand, "top-left");

      editor = new Editor({
        view: view,
        container: document.createElement("div"),
        layerInfos: [{
          title: "Detail Petak : {KODE}",
          layer: geojsonLayer,
          fieldConfig: [{
            name: "KODE",
            label: "Kode petak",
            editable: false
          },{
            name: "POKTAN",
            label: "Nama Kelompok Tani",
            hint: "Pilih atau isikan nama kelompok tani"
          }],
          addEnabled: false,
          deleteEnabled: false
        }]
      });

      function editThis() {
        if (!editor.viewModel.activeWorkFlow) {
          view.popup.visible = false;

          editor.startUpdateWorkflowAtFeatureEdit(
            view.popup.selectedFeature
          );
          view.ui.add(editor, "top-right");
          view.popup.spinnerEnabled = false;
        }

        setTimeout(function () {
          let arrComp = editor.domNode.getElementsByClassName(
            "esri-editor__back-button esri-interactive"
          );
          if (arrComp.length === 1) {
            arrComp[0].setAttribute(
              "title",
              "Cancel edits, return to popup"
            );
            arrComp[0].addEventListener("click", function (evt) {
              evt.preventDefault();
              view.ui.remove(editor);
              view.popup.open({
              features: features
              });
            });
          }
        }, 150);
      }

      view.popup.on("trigger-action", function (event) {
        if (event.action.id === "edit-this") {
          editThis();
        }
      });
    });

    view.popup.watch("visible", function (event) {
      if (editor.viewModel.state === "editing-existing-feature") {
        view.popup.close();
      } else {
        features = view.popup.features;
      }
    });

    geojsonLayer.on("apply-edits", function () {
      view.ui.remove(editor);

      features.forEach(function (feature) {
        feature.popupTemplate = template;
      });

      if (features) {
        view.popup.open({
          features: features
        });
      }

      editor.viewModel.cancelWorkflow();
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

    $.ajax({
      async : false,
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

    const addAttach = new Expand({
      view: view,
      expanded: false,
      expandTooltip: "Tambah layer petak sawah",
      content: node
     });

    view.ui.add(addAttach, "top-left");

    const basemapGallery = new BasemapGallery({
      source: {
        query: {
          id: '702026e41f6641fb85da88efe79dc166'
        }
      },
      view: view,
      container: document.createElement("div")
    });

    var bgExpand = new Expand({
      view: view,
      content: basemapGallery
    });

    view.ui.add(bgExpand, 'bottom-left');

  });
</script>
<?= $this->endSection() ?>
