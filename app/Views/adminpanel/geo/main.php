<?= $this->extend('partials/index') ?>
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

<!-- ESRI SCRIPT -->
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
    "dojo/dom-construct",
    "dojo/dom",
    "dojo/on",
    "esri/core/watchUtils"
  ], function (Map, MapView, GeoJSONLayer, GroupLayer, LayerList, Track, Expand, BasemapGallery, Fullscreen, Search, Editor, domConstruct, dom, on, watchUtils) {

    const url = "<?= $url ?>";
    const url_kec = "<?= $url_kec ?>";
    const url_desa = "<?= $url_desa ?>";
    const url_obs = "<?= $url_obs ?>";
    const url_edtObs = "<?= $url_edtObs ?>";
    const url_edtPlt = "<?= $url_edtPlt ?>";
    const url_obsDet = "<?= $url_obsDet ?>";
    let editor, features;
    var dataKec = [], dataDesa = [];
    var geojsonLayer;
    var dataHead = ["Kode petak","Nama responden","Nama Kelompok Tani","Nama kecamatan","Nama desa","Landuse",
    "Status lahan","Luas petak (m<sup>2</sup>)","NIK pemilik","Nama pemilik","Nama penggarap","Tipe irigasi",
    "Jarak dari sungai (m)","Jarak dari irigasi primer (m)","Lembaga pengelola air","Intensitas tanam","Index pertanaman (IP)",
    "Pola tanam","Permasalahan OPT","Permasalahan air","Permasalahan saprotan","Permasalahan lain",
    "Panen terbanyak (kuintal)","Bulan panen terbanyak","Panen terkecil (kuintal)","Bulan panen terkecil",
    "Penjualan panen","Surveyor","Update"]

    const editAttributes = {
      title: "Edit attributes",
      id: "edit-this",
      className: "esri-icon-edit"
    };

    const editCalendar = {
      title: "Edit kalender tanam",
      id: "edit-cal",
      className: "esri-icon-calendar"
    };

    const template = {
      title: "Kode Petak: {FID}",
      actions: [editCalendar],
      content: getDetail
    };

    function getDetail (feature) {
      var obscode = feature.graphic.attributes.FID;
      var div = document.createElement("div");

      $.ajax({
        async : false,
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        type : 'GET',
        dataType: "html",
        url : url_obsDet + '/' + obscode,
        success : function(response){
          div.innerHTML = response;
        },
        error: function(result){
          div.innerHTML = result;
        },
        fail: function(status) {
          div.innerHTML = status;
        }
      });

      return div;

    }

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

    const labelClass = {
      symbol: {
        type: "text",
        color: "yellow",
        font: {
          size: 9,
          weight: "lighter"
        }
      },
      labelPlacement: "above-center",
      labelExpressionInfo: {
        expression: "$feature.FID"
      }
    };

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

      var track = new Track({
        view: view,
        useHeadingEnabled: false,
        goToLocationEnabled: false
      });
      view.ui.add(track, "top-left");

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

      view.popup.on("trigger-action", function (event) {
        if (event.action.id === "edit-this") {
          var attributes = popup.viewModel.selectedFeature.attributes;
          var id = attributes.FID;
          view.popup.close();
          $('#modal_petak').modal('show');
          //window.location.href = url_edtObs + "/" + id;
        }else if (event.action.id === "edit-cal") {
            var attributes = popup.viewModel.selectedFeature.attributes;
            var id = attributes.FID;
            window.location.href = url_edtPlt + "/" + id;
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
      function updateLayer(kec, desa){
        map.layers.removeAll();
        popup.close();
        geojsonLayer = new GeoJSONLayer({
          url: url + "/info?table=v_observations&fid=obscode&shape=obsshape&sdcode=" + kec + "&vlcode=" + desa,
          copyright: "Dinas Pertanian Kab. Tangerang",
          popupTemplate: template,
          labelingInfo: [labelClass],
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

    view.popup.watch("visible", function (popUpStatusChange) {
      if (popUpStatusChange == true) {
        setTimeout(function() {
          var flg = 0;

          $('.select2').select2({
            dropdownParent: $('#viewDiv')
          });

          $(".select2-input").select2({
            tags: true,
            dropdownParent: $('#viewDiv')
          });

          $(".select2-multi").select2({
            tags: true,
            dropdownParent: $('#viewDiv')
          });

          $(".select2-ownercultivator").select2({
            ajax: {
              url: "/api/owners",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  q: params.term,
                  page: params.page
                };
              },
              processResults: function (data, params) {
                params.page = params.page || 1;

                var items = [];
                $.each(data.results, function (k,v) {
                  items.push({
                    'id': v.ownerid,
                    'text': v.ownername,
                    'items': {
                      'ownername': v.ownername,
                      'ownernik': v.ownernik ,
                      },
                  });
                });

                return {
                  results: items,
                  pagination: {
                    more: (params.page * 10) < data.total_count
                  }
                };
              },
              cache: true
            },
            dropdownParent: $('#viewDiv'),
            escapeMarkup: function (markup) { return markup; },
            placeholder: 'Cari.. pilih',
            minimumInputLength: 1,
            templateResult: formatDataOwnerCultivator,
            templateSelection: formatDataSelection
          }).on("select2:open", () => {
            $(".select2-results:not(:has(a))")
              .prepend('<div class="select2-results__option"><div class="wrapper">' +
                '<a href="#" class="btn btn-block btn-sm btn-primary" data-toggle="modal" data-target="#modal_create">+ Tambah pemilik/penggarap</a>' +
              '</div></div>')
          });

          $('#modal_create').on('shown.bs.modal', function () {
            $(".select2-ownercultivator").select2("close");
          });

          function formatDataOwnerCultivator (data) {
            if (data.loading) return data.text;

            var markup = $(
              '<optgroup label="'+ data.items.ownername +'">' +
                '<option class="nik"></option>' +
              '</optgroup>');

            markup.find(".nik").text(data.items.ownernik);

            return markup;
          }

          $(".select2-farmer").select2({
            ajax: {
              url: "/api/farmer",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  q: params.term,
                  page: params.page
                };
              },
              processResults: function (data, params) {
                params.page = params.page || 1;

                var items = [];
                $.each(data.results, function (k,v) {
                  items.push({
                    'id': v.farmcode,
                    'text': v.farmname,
                    'items': {
                      'farmname': v.farmname,
                      'farmhead': v.farmhead ,
                      },
                  });
                });

                return {
                  results: items,
                  pagination: {
                    more: (params.page * 10) < data.total_count
                  }
                };
              },
              cache: true
            },
            dropdownParent: $('#viewDiv'),
            escapeMarkup: function (markup) { return markup; },
            placeholder: 'Pilih poktan',
            minimumInputLength: 1,
            templateResult: formatDataFarmer,
            templateSelection: formatDataSelection
          }).on("select2:open", () => {
            $(".select2-results:not(:has(a))")
              .prepend('<div class="select2-results__option"><div class="wrapper">' +
                '<a href="#" class="btn btn-block btn-sm btn-primary" data-toggle="modal" data-target="#modal_poktan">+ Tambah kelompok tani</a>' +
              '</div></div>')
          });

          $('#modal_poktan').on('shown.bs.modal', function () {
            $(".select2-farmer").select2("close");
          });

          function formatDataFarmer(data) {
            if (data.loading) return data.text;

            var markup = $(
              '<optgroup label="'+ data.items.farmname +'">' +
                '<option class="farmhead"></option>' +
              '</optgroup>');

            markup.find(".farmhead").text(data.items.farmhead);

            return markup;
          }

          $(".select2-subdist").select2({
            ajax: {
              url: "/api/subdist",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  q: params.term,
                  page: params.page
                };
              },
              processResults: function (data, params) {
                params.page = params.page || 1;

                var items = [];
                $.each(data.results, function (k,v) {
                  items.push({
                    'id': v.vlcode,
                    'text': v.vlname,
                    'items': {
                      'vlname': v.vlname,
                      'sdname': v.sdname ,
                      },
                  });
                });

                return {
                  results: items,
                  pagination: {
                    more: (params.page * 10) < data.total_count
                  }
                };
              },
              cache: true
            },
            dropdownParent: $('#viewDiv'),
            escapeMarkup: function (markup) { return markup; },
            placeholder: 'Pilih desa',
            minimumInputLength: 1,
            templateResult: formatDataSubdist,
            templateSelection: formatDataSelection
          });


          function formatDataSubdist(data) {
            if (data.loading) return data.text;

            var markup = $(
              '<optgroup label="'+ data.items.vlname +'">' +
                '<option class="sdname"></option>' +
              '</optgroup>');

            markup.find(".sdname").text(data.items.sdname);

            return markup;
          }

          $(".select2-respo").select2({
            ajax: {
              url: "/api/respondens",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  q: params.term,
                  page: params.page
                };
              },
              processResults: function (data, params) {
                params.page = params.page || 1;

                var items = [];
                $.each(data.results, function (k,v) {
                  items.push({
                    'id': v.respid,
                    'text': v.respname,
                    'items': {
                      'respname': v.respname,
                      'mobileno': v.mobileno ,
                      },
                  });
                });

                return {
                  results: items,
                  pagination: {
                    more: (params.page * 10) < data.total_count
                  }
                };
              },
              cache: true
            },
            dropdownParent: $('#viewDiv'),
            escapeMarkup: function (markup) { return markup; },
            placeholder: 'Pilih responden',
            minimumInputLength: 1,
            templateResult: formatDataRespo,
            templateSelection: formatDataSelection
          }).on("select2:open", () => {
            $(".select2-results:not(:has(a))")
              .prepend('<div class="select2-results__option"><div class="wrapper">' +
                '<a href="#" class="btn btn-block btn-sm btn-primary" data-toggle="modal" data-target="#modal_respo">+ Tambah responden</a>' +
              '</div></div>')
          });

          $('#modal_respo').on('shown.bs.modal', function () {
            $(".select2-respo").select2("close");
          });

          function formatDataRespo(data) {
            if (data.loading) return data.text;

            var markup = $(
              '<optgroup label="'+ data.items.respname +'">' +
                '<option class="mobileno"></option>' +
              '</optgroup>');

            markup.find(".mobileno").text(data.items.mobileno);

            return markup;
          }

          function formatDataSelection (data) {
            return data.text;
          }
        }, 1000);
      }
    });

  });
</script>

<?= $this->endSection() ?>
