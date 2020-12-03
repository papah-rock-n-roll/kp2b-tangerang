<?= $this->extend('partials/index') ?>
<?= $this->section('link') ?>
<style>html, body, #viewDiv {padding:0;margin:0;height:calc(100vh - 57px);width:100%;}</style>
<?= \App\Libraries\Link::style()->arcgis ?>
<?= \App\Libraries\Link::style()->select2 ?>
<?= \App\Libraries\Link::style()->toastr ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div id="viewDiv" class="viewDiv">
  <div class="modal fade" id="modal_plantdates">
    <div class="modal-dialog modal-lg">
      <div class="modal-content"></div>
    </div>
  </div>
  <?php
    $modals = [
      'id' => 'modal_create',
      'size' => 'modal-md',
      'class' => 'bg-default',
      'title' => 'Tambah data pemilik / penggarap'
      ];
    echo view('adminpanel/data/observation/modals', $modals);

    $modals = [
      'id' => 'modal_poktan',
      'size' => 'modal-md',
      'class' => 'bg-default',
      'title' => 'Tambah data poktan'
      ];
    echo view('adminpanel/data/observation/modals_poktan', $modals);

    $modals = [
      'id' => 'modal_respo',
      'size' => 'modal-md',
      'class' => 'bg-default',
      'title' => 'Tambah responden'
      ];
    echo view('adminpanel/data/observation/modals_responden', $modals);
  ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= \App\Libraries\Link::script()->select2 ?>
<?= \App\Libraries\Link::script()->jqueryvalidation ?>
<?= \App\Libraries\Link::script()->toastr ?>
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
    const url_pldDet = "<?= $url_pldDet ?>";
    let editor, features;
    var geojsonLayer;
    var layerAdd;
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

    <!-- Get Form observation -->
    function getDetail (feature) {
      var obscode = feature.graphic.attributes.FID;
      var div = document.createElement("div");

      $.ajax({
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
        },
        collapseEnabled: false
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

      <!-- Popup Action -->
      view.popup.on("trigger-action", function (event) {
        var attributes = popup.viewModel.selectedFeature.attributes;
        var id = attributes.FID;
        if (event.action.id === "edit-cal") {
          var div = document.createElement("div");
          $.ajax({
            type : 'GET',
            dataType: "html",
            url : url_pldDet + '/' + id,
            success : function(response){
              div.innerHTML = response;

              $('#modal_plantdates').find(".modal-content").html(div);
              $('#modal_plantdates').modal('show');
              $('select.select2').select2();

              var valplant = $("#plantform").validate({
                rules: {
                  growceason: {
                    required: true,
                    number: true,
                    min: 1,
                    max: 5
                  },
                  monthgrow: {
                    required: true
                  },
                  monthharvest: {
                    required: true
                  }
                },
                messages: {
                  growceason: {
                      required: "Masukkan urutan musim tanam.",
                      number: "Wajib diisi angka.",
                      min: "Minimal 1 musim tanam.",
                      max: "Maksimal 5 musim tanam."
                   },
                   monthgrow: {
                     required: "Pilih bulan tanam."
                   },
                   monthharvest: {
                     required: "Pilih bulan panen."
                   }
                },
                errorElement: "div",
                errorClass: "invalid-feedback",
                highlight: function(element, errorClass) {
                    $(element).removeClass(errorClass).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                  $(element).removeClass('is-invalid');
                },
                submitHandler:function(form){
                  $("#modal_plantdates").find(".overlay").addClass('d-flex');
                  $.ajax({
                      url: form.action,
                      type: form.method,
                      data: $(form).serialize(),
                      success: function(response) {
                        valplant.resetForm();
                        form.reset();
                        $('#modal_plantdates').modal('hide');
                        toastr.info('Data musim tanam berhasil diupdate');
                      },
                      fail: function(xhr, textStatus, errorThrown){
                         alert(textStatus);
                      },
                      error: function(xhr, textStatus, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        var errMsg;
                        $.each(err.errors, function(key, val) {
                            var errMsg = val + '<br>';
                        });
                        toastr.error('<strong>' + xhr.status + ': ' + err.message + '</strong><br>' + errMsg );
                        $("#modal_plantdates").find(".overlay").removeClass('d-flex');
                      }
                  });
                  return false;
                }
              });

            },
            error: function(result){
              div.innerHTML = result;
            },
            fail: function(status) {
              div.innerHTML = status;
            }
          });
        }
      });

      <!-- Format char to Title Case -->
    	function toTitleCase(str) {
        return str.replace(
          /\w\S*/g,
          function(txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
          }
        );
      }

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

      <!-- get List Kecamatan -->
      $.ajax({
        url : url_kec,
        type : 'GET',
        success : function(response){
          dataKec = JSON.parse(response);

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

          layerAdd = new Expand({
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
        }
      });

      watchUtils.when(view.popup, "selectedFeature", function() {
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
            $("#modal_create").find(".overlay").removeClass('d-flex');
            $("#ownerform").trigger("reset");
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
              url: "/api/farmers",
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
            $("#modal_poktan").find(".overlay").removeClass('d-flex');
            $("#farmerform").trigger("reset");
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
            $(this).find(".overlay").removeClass('d-flex');
            $("#respform").trigger("reset");
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

          <!-- Update observation -->
          var valobs = $("#obsform").validate({
            errorElement: "div",
            errorClass: "invalid-feedback",
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
            },
            submitHandler:function(form){
              $("#obsform").find(".overlay").addClass('d-flex');
              $.ajax({
                  url: form.action,
                  type: form.method,
                  data: $(form).serialize(),
                  success: function(response) {
                    valowner.resetForm();
                    form.reset();
                    toastr.info('Data petak berhasil diupdate');
                    $("#obsform").find(".overlay").removeClass('d-flex');
                  },
                  fail: function(xhr, textStatus, errorThrown){
                     alert(textStatus);
                  },
                  error: function(xhr, textStatus, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    var errMsg;
                    $.each(err.errors, function(key, val) {
                        var errMsg = val + '<br>';
                    });
                    toastr.error('<strong>' + xhr.status + ': ' + err.message + '</strong><br>' + errMsg );
                    $("#obsform").find(".overlay").removeClass('d-flex');
                  }
              });
              return false;
            }
          });

        }, 1000);
      });

    });

  });

  $(document).ready(function() {

    var valowner = $("#ownerform").validate({
      rules: {
        ownernik: {
          required: true,
          minlength: 3,
          maxlength: 30,
          remote: {
            url: "<?= $url_nik ?>",
            type: "get",
            data: {
              ownernik: function() {
                return $("#ownernik").val();
              }
            }
          }
        },
        ownername: {
          required: true,
          minlength: 3,
          maxlength: 30
        },
        owneraddress: {
          minlength: 3,
          maxlength: 255
        }
      },
      messages: {
        ownernik: {
            required: "Silahkan masukkan nik pemilik/penggarap.",
            remote: "NIK sudah ada.",
            minlength: "Minimal 3 karakter.",
            maxlength: "Maksimal 30 karakter."
         },
         ownername: {
           required: "Silahkan masukkan nama pemilik/penggarap.",
           minlength: "Minimal 3 karakter.",
           maxlength: "Maksimal 30 karakter."
         },
         owneraddress: {
           minlength: "Minimal 3 karakter.",
           maxlength: "Maksimal 255 karakter."
         }
      },
      errorElement: "div",
      errorClass: "invalid-feedback",
      highlight: function(element, errorClass) {
          $(element).removeClass(errorClass).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler:function(form){
        $("#modal_create").find(".overlay").addClass('d-flex');
        $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            success: function(response) {
              valowner.resetForm();
              form.reset();
              $('#modal_create').modal('hide');
              toastr.info('Data pemilik/penggarap berhasil ditambahkan');
            },
            fail: function(xhr, textStatus, errorThrown){
               alert(textStatus);
            },
            error: function(xhr, textStatus, error) {
              var err = eval("(" + xhr.responseText + ")");
              var errMsg;
              $.each(err.errors, function(key, val) {
                  var errMsg = val + '<br>';
              });
              toastr.error('<strong>' + xhr.status + ': ' + err.message + '</strong><br>' + errMsg );
              $("#modal_create").find(".overlay").removeClass('d-flex');
            }
        });
        return false;
      }
    });

    var valfarmer = $("#farmerform").validate({
      rules: {
        farmname: {
          required: true,
          minlength: 3,
          maxlength: 50,
          remote: {
            url: "<?= $url_farmname ?>",
            type: "get",
            data: {
              farmname: function() {
                return $("#farmname").val();
              }
            }
          }
        },
        farmhead: {
          required: true,
          minlength: 3,
          maxlength: 25
        },
        farmmobile: {
          minlength: 3,
          maxlength: 15
        }
      },
      messages: {
        farmname: {
            required: "Silahkan masukkan nama poktan.",
            remote: "Nama poktan sudah ada.",
            minlength: "Minimal 3 karakter.",
            maxlength: "Maksimal 50 karakter."
         },
         farmhead: {
           required: "Silahkan masukkan nama ketua poktan.",
           minlength: "Minimal 3 karakter.",
           maxlength: "Maksimal 25 karakter."
         },
         farmmobile: {
           minlength: "Minimal 3 karakter.",
           maxlength: "Maksimal 15 karakter."
         }
      },
      errorElement: "div",
      errorClass: "invalid-feedback",
      highlight: function(element, errorClass) {
          $(element).removeClass(errorClass).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler:function(form){
        $("#modal_poktan").find(".overlay").addClass('d-flex');
        $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            success: function(response) {
              valfarmer.resetForm();
              form.reset();
              $('#modal_poktan').modal('hide');
              toastr.info('Data poktan berhasil ditambahkan');
            },
            fail: function(xhr, textStatus, errorThrown){
               alert(textStatus);
            },
            error: function(xhr, textStatus, error) {
              var err = eval("(" + xhr.responseText + ")");
              var errMsg;
              $.each(err.errors, function(key, val) {
                  var errMsg = val + '<br>';
              });
              toastr.error('<strong>' + xhr.status + ': ' + err.message + '</strong><br>' + errMsg );
              $("#modal_poktan").find(".overlay").removeClass('d-flex');
            }
        });
        return false;
      }
    });

    var valfarmer = $("#respform").validate({
      rules: {
        respname: {
          required: true,
          minlength: 3,
          maxlength: 30,
          remote: {
            url: "<?= $url_respname ?>",
            type: "get",
            data: {
              respname: function() {
                return $("#respname").val();
              }
            }
          }
        },
        mobileno: {
          minlength: 3,
          maxlength: 15
        }
      },
      messages: {
        respname: {
            required: "Silahkan masukkan nama responden.",
            remote: "Responden sudah ada.",
            minlength: "Minimal 3 karakter.",
            maxlength: "Maksimal 30 karakter."
         },
         mobileno: {
           remote: "Responden sudah ada.",
           minlength: "Minimal 3 karakter.",
           maxlength: "Maksimal 15 karakter."
         }
      },
      errorElement: "div",
      errorClass: "invalid-feedback",
      highlight: function(element, errorClass) {
          $(element).removeClass(errorClass).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler:function(form){
        $("#modal_respo").find(".overlay").addClass('d-flex');
        $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            success: function(response) {
              valfarmer.resetForm();
              form.reset();
              $('#modal_respo').modal('hide');
              toastr.info('Data responden berhasil ditambahkan');
            },
            fail: function(xhr, textStatus, errorThrown){
               alert(textStatus);
            },
            error: function(xhr, textStatus, error) {
              var err = eval("(" + xhr.responseText + ")");
              var errMsg;
              $.each(err.errors, function(key, val) {
                  errMsg = val + '<br>';
              });
              toastr.error('<strong>' + xhr.status + ': ' + err.message + '</strong><br>' + errMsg );
              $("#modal_respo").find(".overlay").removeClass('d-flex');
            }
        });
        return false;
      }
    });

  });
</script>

<?= $this->endSection() ?>
