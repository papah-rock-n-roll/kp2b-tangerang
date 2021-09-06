<?= $this->extend('public/partials/index') ?>

<?= $this->section('link') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css">
<?= \App\Libraries\Link::style()->datatable4 ?>
<?= \App\Libraries\Link::style()->datatableResponsive4 ?>
<?= \App\Libraries\Link::style()->datatableBtn4 ?>
<?= \App\Libraries\Link::style()->chartjs ?>
<style>
  #viewDiv {padding:0;margin:0;height:calc(100vh - 68px);width:100%;position:relative;}
  #feature-node{position:relative;top:0;width:100%;height:100%}
  .esri-view .esri-view-user-storage{overflow:inherit !important;}
  .visible {display:block !important;}
  .loading {position:absolute;top:15px;left:60px;background-color:#929292;color:white;display:none;padding:5px 8px;border-radius:3px;opacity:0.9;}
</style>
<?= \App\Libraries\Link::style()->arcgis ?>
<?= \App\Libraries\Link::style()->select2 ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div id="viewDiv">
  <div id="loadingDiv" class="loading align-items-center">
    <div class="spinner-border spinner-border-sm" role="status"></div>
    <span class="text-sm"> Updating Maps...</span>
  </div>
  <div id="feature-node" class="control-sidebar control-sidebar-light"><div id="info-container" class="p-3"></div></div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
<?= \App\Libraries\Link::script()->datatable ?>
<?= \App\Libraries\Link::script()->datatable4 ?>
<?= \App\Libraries\Link::script()->datatableResponsive ?>
<?= \App\Libraries\Link::script()->datatableResponsive4 ?>
<?= \App\Libraries\Link::script()->datatableBtn ?>
<?= \App\Libraries\Link::script()->datatableBtn4 ?>
<?= \App\Libraries\Link::script()->btnFlash ?>
<?= \App\Libraries\Link::script()->jszip ?>
<?= \App\Libraries\Link::script()->pdfmake ?>
<?= \App\Libraries\Link::script()->vfsFont ?>
<?= \App\Libraries\Link::script()->html5Btn ?>
<?= \App\Libraries\Link::script()->btnPrint ?>
<?= \App\Libraries\Link::script()->btncolVis ?>
<?= \App\Libraries\Link::script()->chartjs ?>
<?= \App\Libraries\Link::script()->chartjslabel ?>

<?= \App\Libraries\Link::script()->select2 ?>
<?= \App\Libraries\Link::script()->arcgis ?>

<script>

  const ps = new PerfectScrollbar('#feature-node');

  require([
    "esri/Map",
    "esri/views/MapView",
    "esri/layers/GeoJSONLayer",
    "esri/layers/GroupLayer",
    "esri/smartMapping/renderers/type",
    "esri/smartMapping/renderers/color",
    "esri/widgets/LayerList",
    "esri/widgets/Track",
    "esri/widgets/Expand",
    "esri/widgets/BasemapGallery",
    "esri/widgets/Fullscreen",
    "esri/widgets/Search",
    "esri/widgets/Legend",
    "esri/widgets/Feature",
    "esri/core/watchUtils",
    "dojo/dom-construct",
    "dojo/dom",
    "dojo/on",
    "dojo/dom-class",
    "dojo/domReady!"
  ], function (Map, MapView, GeoJSONLayer, GroupLayer, typeRendererCreator, colorRendererCreator, LayerList, Track, Expand, BasemapGallery, Fullscreen, Search, Legend, Feature, watchUtils, domConstruct, dom, on, domClass) {

    const url = "<?= $url ?>";
    const url_kec = "<?= $url_kec ?>";
    const url_desa = "<?= $url_desa ?>";
    const url_obs = "<?= $url_obs ?>";
    const url_datalayer = "<?= $url_datalayer ?>";
    const url_info = "<?= $url_info ?>";
    let editor, features;
    var geojsonLayer, geojsonDesa, geojsonKec, geojsonKp2b, geojsonSawah;
    var layerAdd, dataAdd;
    var legendSymbol = [], defLabel = [];
    var dataHead = ["Kode petak","Nama responden","Nama Kelompok Tani","Nama kecamatan","Nama desa/kelurahan","Landuse",
    "Status lahan","Luas petak (m<sup>2</sup>)","NIK pemilik","Nama pemilik","Nama penggarap","Tipe irigasi",
    "Jarak dari sungai (m)","Jarak dari irigasi primer (m)","Lembaga pengelola air","Intensitas tanam","Index pertanaman (IP)",
    "Pola tanam","Permasalahan OPT","Permasalahan air","Permasalahan saprotan","Permasalahan lain",
    "Panen terbanyak (kuintal)","Bulan panen terbanyak","Panen terkecil (kuintal)","Bulan panen terkecil",
    "Penjualan panen","Surveyor","Update"];
    var copyright = "Dinas Pertanian dan Ketahanan Pangan Kabupaten Tangerang";

    const template = {
      title: "Kode Petak: {FID}",
      content: getDetail
    };

    const templateKec = {
      title: "Kode Kecamatan: {FID}",
      content: "{LABEL}"
    };

    const templateDesa = {
      title: "Kode Desa: {FID}",
      content: "{LABEL}"
    };

    const templateKp2b = {
      title: "OBJECT ID: {FID}",
      content: "{LABEL}"
    };

    <!-- Get Form observation -->
    function getDetail(feature) {
      var obscode = feature.graphic.attributes.FID;
      var div = document.createElement("div");

      $.ajax({
        type : 'GET',
        dataType: "html",
        url : url_obs + '?obscode=' + obscode,
        success : function(response){
          var dataObs = JSON.parse(response);
          var divContent = '<table class="esri-widget__table"><tbody>';
          for (var i = 0; i < dataHead.length; i++) {
            divContent += '<tr><th class="esri-feature-fields__field-header">' + dataHead[i] + '</th> \
            <td class="esri-feature-fields__field-data">' + Object.values(dataObs)[i] + '</td></tr>';
          }
          divContent += '</tbody></table>';
          divContent += '<p class="mt-3 text-xs">Update terakhir oleh: ' + dataObs.username + '.<br>Tanggal ' + dataObs.timestamp + '</p>';
          div.innerHTML = divContent;
        }
      });

      return div;
    }

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

    const lStatus = [
      {
        value: "Milik",
        symbol: createSymbol("#28a745"),
        label: "Milik"
      },
      {
        value: "Sewa",
        symbol: createSymbol("#ffc107"),
        label: "Sewa"
      },
      {
        value: "Garap",
        symbol: createSymbol("#dc3545"),
        label: "Garap"
      },
      {
        value: "Lainnya",
        symbol: createSymbol("#17a2b8"),
        label: "Lainnya"
      }
    ];

    const lLanduse = [
      {
        value: "Sawah",
        symbol: createSymbol("#28a745"),
        label: "Sawah"
      }
    ];

    const indxnlant = [
      {
        value: "100",
        symbol: createSymbol("#943126"),
        label: "IP 100"
      },
      {
        value: "200",
        symbol: createSymbol("#B7950B"),
        label: "IP 200"
      },
      {
        value: "300",
        symbol: createSymbol("#1E8449"),
        label: "IP 300"
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
        },
        collapseEnabled: false
      }
    });

    <!-- Tombol Full Screen -->
    view.ui.add(
      new Fullscreen({
        view: view,
        element: viewDiv
      }), "top-left"
    );

    <!-- Tombol Geo location -->
    view.ui.add(
      new Track({
        view: view,
        useHeadingEnabled: false,
        goToLocationEnabled: false
      }), "top-left"
    );

    <!-- From Pencarian -->
    var searchWidget = new Search({
      view: view,
      includeDefaultSources: false
    });
    view.ui.add(searchWidget, "top-right");

    <!-- Tombol Basemap -->
    const basemapGallery = new BasemapGallery({
      view: view,
      container: document.createElement("div")
    });

    view.ui.add(
      new Expand({
        view: view,
        content: basemapGallery,
        expandTooltip: "Change basemap",
      }),
      "bottom-left"
    );

    <!-- Tombol Legenda -->
    const legend = new Expand({
      content: new Legend({
        view: view
      }),
      view: view,
      expandIconClass: "esri-icon-legend",
      expandTooltip: "Legend"
    });
    view.ui.add(legend, "bottom-left");

    <!-- Sidebar Info -->
    const graphic = {
      popupTemplate: {
        title: "Informasi Data",
        content: "Belum ada informasi. Silahkan pilih jenis data pada panel layer data."
      }
    };
    const feature = new Feature({
      container: "info-container",
      graphic: graphic,
      map: view.map,
      spatialReference: view.spatialReference
    });

    <!-- Tombol Info -->
    var infoBtn = document.createElement('div');
    infoBtn.className = "esri-icon-description esri-widget--button esri-widget esri-interactive";
    infoBtn.setAttribute("data-widget", "control-sidebar");
    infoBtn.addEventListener('click', function(evt){
      console.log("clicked");
    });
    view.ui.add(infoBtn, "top-right");

    <!-- Action layer petak -->
    function defineActions(event) {
      var item = event.item;

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

    view.watch('updating', function(evt){
      if(evt === true){
        domClass.add('loadingDiv', 'visible');
      }else{
        domClass.remove('loadingDiv', 'visible');
      }
    });

    view.when(function () {
      var popup = view.popup;

      <!-- Function Format char to Title Case -->
      function toTitleCase(str) {
          return str.replace(
              /\w\S*/g,
              function(txt) {
                  return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
              }
          );
      }

      <!-- get List Kecamatan -->
      $.ajax({
        url : url_kec,
        type : 'GET',
        success : function(response){
          var dataKec = response;

          var kecDom = '<div class="form-group input-group-sm" id="dataLayer"> \
            <label>Pilih jenis data</label> \
            <select class="form-control" id="layerData"> \
              <option value="areantatus">Status lahan</option> \
              <option value="landuse">Landuse</option> \
              <option value="desclanduse">Detail Landuse</option> \
              <option value="indxnlant">Index Pertanaman</option> \
              <option value="farmname">Kelompok Tani</option> \
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

          layerAdd = new Expand({
            view: view,
            expanded: false,
            expandIconClass: "esri-icon-maps",
            expandTooltip: "Layer Petak",
            content: node
           });

          view.ui.add(layerAdd, "top-left");

          legendSymbol = lStatus;
          defLabel = "Null Data";

          watchUtils.whenTrueOnce(layerAdd, 'expanded', function(){

            on(dom.byId("layerKec"), 'change', function(){
              if(this.value == ''){$("#desaForm").hide();}else{$("#desaForm").show();}
              getDesa(this.value);
            });

            on(dom.byId("applyLayer"), 'click', function(){
              updateLayer( $("#layerData").val(), $("#layerKec").val(), $("#layerDesa").val() );
            });

          });

          <!-- Layer list data layer -->
          var layerDom = '<div class="form-group input-group-sm" id="otherlayer"> \
            <label>Pilih layer data</label> \
            <div class="form-check"> <input class="form-check-input" type="checkbox" id="kec" name="kec" value="Batas Kecamatan"> <label for="kec" class="form-check-label">Batas Kecamatan</label> </div> \
            <div class="form-check"> <input class="form-check-input" type="checkbox" id="desa" name="desa" value="Batas Desa"> <label for="desa" class="form-check-label">Batas Desa</label> </div> \
            <div class="form-check"> <input class="form-check-input" type="checkbox" id="kp2b" name="kp2b" value="Batas KP2B"> <label for="kp2b" class="form-check-label">Batas KP2B</label> </div> \
          </div>';

          var nodeLayer = domConstruct.create("div", {
            className: "esri-layer-list esri-widget esri-widget--panel",
            innerHTML: layerDom
          });

          dataAdd = new Expand({
            view: view,
            expanded: false,
            expandIconClass: "esri-icon-collection",
            expandTooltip: "Layer Collection",
            content: nodeLayer
           });

          view.ui.add(dataAdd, "top-left");

          watchUtils.whenTrueOnce(dataAdd, 'expanded', function(){

            on(dom.byId("kec"), 'change', function(){
              if (this.checked) {
                getDataLayer($(this).attr("id"), $(this).attr("value"));
              } else {
                map.layers.remove(geojsonKec);
              }
            });

            on(dom.byId("desa"), 'change', function(){
              if (this.checked) {
                getDataLayer($(this).attr("id"), $(this).attr("value"));
              } else {
                map.layers.remove(geojsonDesa);
              }
            });

            on(dom.byId("kp2b"), 'change', function(){
              if (this.checked) {
                getDataLayer($(this).attr("id"), $(this).attr("value"));
              } else {
                map.layers.remove(geojsonKp2b);
              }
            });

          });

        }
      });

      <!-- Layer list widget -->
      var layerList = new LayerList({
        view: view,
        id: "layerList",
        selectionEnabled: true,
        listItemCreatedFunction: defineActions
      });

      view.ui.add(
        new Expand({
          view: view,
          content: layerList,
          expandTooltip: "Layer list"
        }),
        "top-left"
      );

      layerList.on("trigger-action", function (event) {
        var item = event.item.layer;
        var id = event.action.id;

        if (id === "full-extent") {
          view.goTo(item.fullExtent).catch(function (error) {
            if (error.name != "AbortError") {
              console.error(error);
            }
          });
        } else if (id === "increase-opacity") {
          if (item.opacity < 1) {
            item.opacity += 0.25;
          }
        } else if (id === "decrease-opacity") {
          if (item.opacity > 0) {
            item.opacity -= 0.25;
          }
        }
      });

      <!-- get List Desa -->
      function getDesa(sdcode = ''){
        $.ajax({
          url : url_desa + '?sdcode=' + sdcode,
          type : 'GET',
          success : function(response){
            var dataDesa = JSON.parse(response);
            var desaDom = '<option value="">Semua desa</option>';
            for (var i = 0; i < dataDesa.length; i++) {
              var optDesa = '<option value="' + dataDesa[i].vlcode + '"> ' + toTitleCase(dataDesa[i].vlname) + ' </option>';
              desaDom = desaDom + optDesa;
            }
            $('#layerDesa').html(desaDom);
          }
        });
      }

      <!-- update search layer source -->
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

      <!-- Update layers -->
      function renderLayers(data) {
        switch(data) {

          case 'areantatus':
            defLabel = "No Data";
            var typeParams = {
              layer: geojsonLayer,
              view: view,
              field: data,
              legendOptions: {
                title: $('#layerData option:selected').text()
              },
              defaultSymbol: createSymbol("grey"),
              defaultLabel: defLabel,
              sortBy: "value",
              numTypes: -1,
              defaultSymbolEnabled: false,
              visualVariables: [
                {
                  type: "size",
                  valueExpression: "$view.scale",
                  target: "outline",
                  stops: [
                    { size: 0.5, value: 15000 },
                    { size: 0.3, value: 30000 },
                    { size: 0, value: 50000 }
                  ]
                }
              ]
            };
            typeRendererCreator.createRenderer(typeParams)
            .then(function (response) {
              geojsonLayer.renderer = response.renderer;
            }).catch(function (error) {
              console.error("there was an error: ", error);
            });
          break;

          case 'landuse':
            legendSymbol = lLanduse;
            defLabel = "Non Sawah";
            var renderer = {
              type: "unique-value",
              field: data,
              legendOptions: {
                title: $('#layerData option:selected').text()
              },
              uniqueValueInfos: legendSymbol,
              defaultSymbol: createSymbol("grey"),
              defaultLabel: defLabel,
              visualVariables: [
                {
                  type: "size",
                  valueExpression: "$view.scale",
                  target: "outline",
                  stops: [
                    { size: 0.5, value: 15000 },
                    { size: 0.3, value: 30000 },
                    { size: 0, value: 50000 }
                  ]
                }
              ]
            };
            geojsonLayer.renderer = renderer;
          break;

            case 'desclanduse':
              defLabel = "No Data";
              var typeParams = {
                layer: geojsonLayer,
                view: view,
                field: data,
                legendOptions: {
                  title: $('#layerData option:selected').text()
                },
                defaultSymbol: createSymbol("grey"),
                defaultLabel: defLabel,
                sortBy: "value",
                numTypes: -1,
                defaultSymbolEnabled: false,
                visualVariables: [
                  {
                    type: "size",
                    valueExpression: "$view.scale",
                    target: "outline",
                    stops: [
                      { size: 0.5, value: 15000 },
                      { size: 0.3, value: 30000 },
                      { size: 0, value: 50000 }
                    ]
                  }
                ]
              };
              typeRendererCreator.createRenderer(typeParams)
              .then(function (response) {
                geojsonLayer.renderer = response.renderer;
              }).catch(function (error) {
                console.error("there was an error: ", error);
              });
            break;

          case 'indxnlant':
            legendSymbol = indxnlant;
            defLabel = "Non Sawah";
            var renderer = {
              type: "unique-value",
              field: data,
              legendOptions: {
                title: $('#layerData option:selected').text()
              },
              uniqueValueInfos: legendSymbol,
              defaultSymbol: createSymbol("grey"),
              defaultLabel: defLabel,
              visualVariables: [
                {
                  type: "size",
                  valueExpression: "$view.scale",
                  target: "outline",
                  stops: [
                    { size: 0.5, value: 15000 },
                    { size: 0.3, value: 30000 },
                    { size: 0, value: 50000 }
                  ]
                }
              ]
            };
            geojsonLayer.renderer = renderer;
          break;

          case 'farmname':
            var typeParams = {
              layer: geojsonLayer,
              view: view,
              field: data,
              legendOptions: {
                title: $('#layerData option:selected').text()
              },
              sortBy: "value",
              numTypes: -1,
              defaultSymbolEnabled: false,
              visualVariables: [
                {
                  type: "size",
                  valueExpression: "$view.scale",
                  target: "outline",
                  stops: [
                    { size: 0.5, value: 15000 },
                    { size: 0.3, value: 30000 },
                    { size: 0, value: 50000 }
                  ]
                }
              ]
            };
            typeRendererCreator.createRenderer(typeParams)
            .then(function (response) {
              geojsonLayer.renderer = response.renderer;
            }).catch(function (error) {
              console.error("there was an error: ", error);
            });
          break;

        };
      }

      <!-- Get information -->
      function getInfo(data, kec, desa) {
        var div = document.createElement("div");
        $.ajax({
          type : 'GET',
          dataType: "json",
          beforeSend: function(){
            $("#info-container .esri-feature__main-container").html('<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
          },
          url : url_info + '?type=' + data + '&sdcode=' + kec + '&vlcode=' + desa,
          success : function(obj, textstatus){

            var titleC = $("#info-container .esri-feature__title");
            var mainC = $("#info-container .esri-feature__main-container");
            var titleInfo = $('#layerData option:selected').text();

            if (!("error" in obj)) {

              mainC.html('<table id="table-result" class="table table-sm table-striped table-bordered" width="100%"><thead>' +
                  '<tr><th class="align-middle" rowspan="2">'+titleInfo+'</th><th class="align-middle" rowspan="2">Jumlah Petak</th><th class="align-middle" rowspan="2">Luas Petak (ha)</th><th class="align-middle" colspan="3">Produktivitas (ton/ha)</th></tr>' +
                  '<tr><th class="align-middle">Min</th><th class="align-middle">Max</th><th class="align-middle">Avg</th></tr>' +
              '</thead></table>');

              var opt = [];
              columns = [
                { "data": "field" },
                { "data": "petak", render: $.fn.dataTable.render.number( '.', ',', 0 ) },
                { "data": "luas", render: $.fn.dataTable.render.number( '.', ',', 2 ) },
                { "data": "min", render: $.fn.dataTable.render.number( '.', ',', 2 ) },
                { "data": "max", render: $.fn.dataTable.render.number( '.', ',', 2 ) },
                { "data": "avg", render: $.fn.dataTable.render.number( '.', ',', 2 ) }
              ];
              columnDefs =  [
                { targets: 1, className: 'text-right' },
                { targets: 2, className: 'text-right' },
                { targets: 3, className: 'text-right' },
                { targets: 4, className: 'text-right' },
                { targets: 5, className: 'text-right' }
              ];
              order = [0, 'asc'];
              opt.push(columns);
              opt.push(columnDefs);
              opt.push(order);

              var dataTable = $("#table-result").DataTable( {
                data: obj,
                "searching": false,
                "paging": false,
                "info": false,
                "responsive": false,
                "autoWidth": false,
                "columns": opt[0],
                "columnDefs": opt[1],
                "order": opt[3]
              });

              titleC.html(titleInfo);

            } else {

              mainC.html('<h6 class="text-center">Data belum tersedia</h6>');

            }

          },
          error: function (obj, textstatus) {

            mainC.html('<h6 class="text-center">Data belum tersedia</h6>');

          }
        });

      }

      function updateLayer(data, kec, desa){
        map.layers.remove(geojsonLayer);
        popup.close();

        geojsonLayer = new GeoJSONLayer({
          url: url + "/info?table=v_observations&fid=obscode&shape=obsshape&fields=" + data + "&sdcode=" + kec + "&vlcode=" + desa,
          copyright: copyright,
          title: "Petak sawah",
          opacity: .75,
          popupTemplate: template
        });

        renderLayers(data);
        getInfo(data, kec, desa);

        geojsonLayer.queryExtent().then(function(results){
          view.goTo(results.extent);
        });
        map.add(geojsonLayer);
        updateSearchSource();
        layerAdd.collapse();
      }

      <!-- get data layer -->
      function getDataLayer(idLayers, titleLayers){

        const rendererKec = {
          type: "simple",
          symbol: {
            type: "simple-fill",
            color: "rgba(255, 255, 255, 0)",
            outline: {
              color: "black",
              width: 1,
              style: "long-dash-dot-dot"
            }
          },
          field: "LABEL",
          legendOptions: titleLayers
        };

        const rendererDesa = {
          type: "simple",
          symbol: {
            type: "simple-fill",
            color: "rgba(255, 255, 255, 0)",
            style: "solid",
            outline: {
              color: "black",
              width: 0.5,
              style: "dot"
            }
          },
          field: "LABEL",
          legendOptions: titleLayers
        };

        const rendererKp2b = {
          type: "unique-value",
          field: "LABEL",
          defaultSymbol: { type: "simple-fill" },
          defaultLabel: "Lainnya",
          uniqueValueInfos: [{
            value: "KP2B",
            symbol: {
              type: "simple-fill",
              color: "green",
              style: "solid",
              outline: {
                color: "white",
                width: 0.5
              }
            }
          },{
            value: "Agropolitan",
            symbol: {
              type: "simple-fill",
              color: "rgba(0, 123, 255, 1)",
              style: "solid",
              outline: {
                color: "white",
                width: 0.5
              }
            }
          }],
          legendOptions: titleLayers
        };

        popup.close();

        <!-- Layer Kecamatan -->
        if (idLayers == "kec") {
          geojsonKec = new GeoJSONLayer({
            url: url_datalayer + '?datalayer=' + idLayers,
            copyright: copyright,
            popupTemplate: templateKec,
            renderer: rendererKec,
            title: titleLayers,
            opacity: .75
          });
          map.add(geojsonKec);
        };

        <!-- Layer Desa -->
        if (idLayers == "desa") {
          geojsonDesa = new GeoJSONLayer({
            url: url_datalayer + '?datalayer=' + idLayers,
            copyright: copyright,
            popupTemplate: templateDesa,
            renderer: rendererDesa,
            title: titleLayers,
            opacity: .75
          });
          map.add(geojsonDesa);
        };

        <!-- Layer KP2B -->
        if (idLayers == "kp2b") {
          geojsonKp2b = new GeoJSONLayer({
            url: url_datalayer + '?datalayer=' + idLayers,
            copyright: copyright,
            popupTemplate: templateKp2b,
            renderer: rendererKp2b,
            title: titleLayers,
            opacity: .75
          });
          map.add(geojsonKp2b);
        };

        dataAdd.collapse();

      }

    });

  });
</script>
<?= $this->endSection() ?>
