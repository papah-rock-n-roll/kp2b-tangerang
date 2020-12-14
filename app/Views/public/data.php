<?= $this->extend('public/partials/index') ?>

<?= $this->section('link') ?>
<?= \App\Libraries\Link::style()->datatable4 ?>
<?= \App\Libraries\Link::style()->datatableResponsive4 ?>
<?= \App\Libraries\Link::style()->datatableBtn4 ?>
<?= \App\Libraries\Link::style()->chartjs ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container py-4 text-sm">
  <h3>Cari data petak sawah</h3>
  <p>Pilih jenis data yang tersedia pada kolom jenis data. Data dapat dipilih berdasarkan administratif kabupaten,
    kecamatan maupun desa. Selain data tabular data juga ditampilkan secara grafik.</p>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Query Data</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group input-group-sm">
            <label for="data">Pilih Jenis Data</label>
            <select class="custom-select rounded-0" id="data">
              <option value="lj">Luas dan jumlah petak sawah</option>
              <option value="pp">Jumlah petani dan penggarap</option>
              <option value="sa">Summary data administratif</option>
              <option value="kt">Kelompok Tani</option>
              <option value="kt">Kalender tanam</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group input-group-sm">
            <label for="data">Level data</label>
            <select class="custom-select rounded-0" id="level">
              <option value="">Kabupaten Tangerang</option>
              <?php foreach($kec as $value) : ?>
                <option value="<?= $value->sdcode ?>"><?= $value->sdname ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group input-group-sm">
            <label for="data">Group Data</label>
            <select class="custom-select rounded-0" id="group">
              <option value="0">Kecamatan</option>
              <option value="1">Desa</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary btn-sm float-right" id="buildResult">Apply</button>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Query Result</h3>
    </div>
    <div class="card-body result">
      <h6 class="text-center">Hasil pencarian akan ditampilkan disini</h6>
    </div>
  </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
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

<script>

  $(document).ready(function() {

    function number_format(num, dec) {
      return (
        parseFloat(num)
          .toFixed(dec)
          .replace('.', ',')
          .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
      )
    }

    var dynamicColors = function() {
      var r = Math.floor(Math.random() * 255);
      var g = Math.floor(Math.random() * 255);
      var b = Math.floor(Math.random() * 255);
      return "rgb(" + r + "," + g + "," + b + ")";
    };

    function domTable(dataType) {

      switch (dataType){

        case 'lj':
          htmlDiv = '<div class="row"><div class="col-md-12"><table id="table-result" class="table table-striped table-bordered" width="100%"><thead>' +
              '<tr><th rowspan="2" class="align-middle">Kode</th><th rowspan="2" class="align-middle">Kecamatan</th><th colspan="2" class="text-center">Luas</th><th colspan="2" class="text-center">Jumlah Petak</th></tr>' +
              '<tr><th>Sawah</th><th>Non Sawah</th><th>Sawah</th><th>Non Sawah</th></tr>' +
          '</thead></table></div></div>';
          return htmlDiv;
        break;

        case 'pp':
          htmlDiv = '<div class="row"><div class="col-md-12"><table id="table-result" class="table table-striped table-bordered" width="100%"><thead><tr>' +
              '<th>Kode</th>' +
              '<th>Administratif</th>' +
              '<th>Petani Pemilik</th>' +
              '<th>Petani Penggarap</th>' +
              '<th>Tidak teridentifikasi</th>' +
          '</tr></thead></table></div></div>';
          return htmlDiv;
        break;

        default:
          return "Create Table failed.";

      }

    }

    function domChart(dataType, dataGroup) {

      switch (dataType){

        case 'lj':
          htmlDiv = '<div class="row mb-5">' +
            '<div class="col-md-6 contLuas"><canvas id="chartLuas"></canvas></div>' +
            '<div class="col-md-6 contLuas"><canvas id="ChartJumlah"></canvas></div>' +
          '</div>';
          return htmlDiv;
        break;

        case 'pp':
          htmlDiv = '<div class="row mb-5">' +
            '<div class="col-lg-6 contPP"><canvas id="chartPP"></canvas></div>' +
          '</div>';
          return htmlDiv;
        break;

        default:
          return "Create Chart failed.";

      }

    }

    function optTable(dataType) {
      var opt = [];

      switch (dataType){

        case 'lj':
          columns = [
            { "data": "code" },
            { "data": "label" },
            { "data": "luas1", render: $.fn.dataTable.render.number( '.', ',', 2 ) },
            { "data": "jmlh1", render: $.fn.dataTable.render.number( '.', ',', 0 ) },
            { "data": "luas2", render: $.fn.dataTable.render.number( '.', ',', 2 ) },
            { "data": "jmlh2", render: $.fn.dataTable.render.number( '.', ',', 0 ) }
          ];
          columnDefs =  [
            { targets: 2, className: 'text-right' },
            { targets: 3, className: 'text-right' },
            { targets: 4, className: 'text-right' },
            { targets: 5, className: 'text-right' }
          ];
          order = [0, 'asc'];
          opt.push(columns);
          opt.push(columnDefs);
          opt.push(order);
          return opt;
        break;

        case 'pp':
          columns = [
            { "data": "code" },
            { "data": "label" },
            { "data": "pemilik", render: $.fn.dataTable.render.number( '.', ',', 0 ) },
            { "data": "penggarap", render: $.fn.dataTable.render.number( '.', ',', 0 ) },
            { "data": "kosong", render: $.fn.dataTable.render.number( '.', ',', 0 ) }
          ];
          columnDefs =  [
            { targets: 2, className: 'text-right' },
            { targets: 3, className: 'text-right' },
            { targets: 4, className: 'text-right' }
          ];
          order = [0, 'asc'];
          opt.push(columns);
          opt.push(columnDefs);
          opt.push(order);
          return opt;
        break;

        default:
          return opt;

      }

    }

    function optChart(chartType, dataGroup, obj) {
      var opt = [];

      switch (chartType){

        case 'luas':

          var labels = obj.map(function(e) {
            return e.label;
          });

          var dataSource = obj.map(function(e) {
            return e.luas;
          });

          if( dataGroup == 0 ){

            var type = 'pie';

            var legend = {
              position: "right",
              labels: {
                boxWidth: 15
              }
            }

            var coloR = [];
            for (var i in dataSource) {
              coloR.push(dynamicColors());
            }

            var tooltips = {callbacks: {
              label: function(tooltipItem, data) {
                let label = data.labels[tooltipItem.index];
                let val = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                let sum = 0;
                let dataArr = data.datasets[0].data;
                dataArr.map(data => {
                  sum = sum + parseInt(data);
                });
                let percentage = number_format((val * 100 / sum), 2) + "%";
                return label + ': ' + number_format(val, 2) + ' ha (' + percentage + ')';
              }
            }};

            var label = {
              value: {
                align: 'end',
                textAlign: 'center',
                formatter: function(value, ctx) {
                  let val_number = number_format(value, 2);
                  let sum = 0;
                  let dataArr = ctx.chart.data.datasets[0].data;
                  dataArr.map(data => {
                    sum = sum + parseInt(data);
                  });
                  let percentage = number_format((value * 100 / sum), 2) + "%";
                  return val_number + " ha\n(" + percentage + ")";
                }
              }
            };

            $(".contLuas").css("height", '300px');

          }else{

            var type = 'horizontalBar';

            var legend = {
              position: "bottom",
              labels: {
                boxWidth: 15
              }
            }

            var coloR = "#28a745";

            var tooltips = {callbacks: {
              label: function(tooltipItem, data) {
                let label = data.datasets[tooltipItem.datasetIndex].label;
                let val = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                return label + ': ' + number_format(val, 2) + ' ha';
              }
            }};

            var label = {
              value: {
                align: 'end',
                textAlign: 'center',
                formatter: function(value, ctx) {
                  let val_number = number_format(value, 2);
                  return val_number + " ha";
                }
              }
            };

            $(".contLuas").css("height", (100 + (obj.length * 25)) + 'px');

          }

          var title = "Luas petak sawah";

          var data = {
            labels: labels,
            datasets: [{
              label: title,
              data: dataSource,
              backgroundColor: coloR,
              borderColor: 'rgba(255, 255, 255)'
            }]
          };

          opt.push(type);
          opt.push(data);
          opt.push(title);
          opt.push(legend);
          opt.push(tooltips);
          opt.push(label);

          return opt;

        break;

        case 'jumlah':

          var labels = obj.map(function(e) {
            return e.label;
          });

          var dataSource = obj.map(function(e) {
            return e.jumlah;
          });

          if( dataGroup == 0 ){

            var type = 'pie';

            var legend = {
              position: "right",
              labels: {
                boxWidth: 15
              }
            }

            var coloR = [];
            for (var i in dataSource) {
              coloR.push(dynamicColors());
            }

            var tooltips = {callbacks: {
              label: function(tooltipItem, data) {
                let label = data.labels[tooltipItem.index];
                let val = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                let sum = 0;
                let dataArr = data.datasets[0].data;
                dataArr.map(data => {
                  sum = sum + parseInt(data);
                });
                let percentage = number_format((val * 100 / sum), 2) + "%";
                return label + ': ' + number_format(val, 0) + ' (' + percentage + ')';
              }
            }};

            var label = {
              value: {
                align: 'end',
                textAlign: 'center',
                formatter: function(value, ctx) {
                  let val_number = number_format(value, 0);
                  let sum = 0;
                  let dataArr = ctx.chart.data.datasets[0].data;
                  dataArr.map(data => {
                    sum = sum + parseInt(data);
                  });
                  let percentage = number_format((value * 100 / sum), 2) + "%";
                  return val_number + "\n(" + percentage + ")";
                }
              }
            };

            $(".contLuas").css("height", '300px');

          }else{

            var type = 'horizontalBar';

            var legend = {
              position: "bottom",
              labels: {
                boxWidth: 15
              }
            }

            var coloR = "#28a745";

            var tooltips = {callbacks: {
              label: function(tooltipItem, data) {
                let label = data.datasets[tooltipItem.datasetIndex].label;
                let val = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                return label + ': ' + number_format(val, 0);
              }
            }};

            var label = {
              value: {
                align: 'end',
                textAlign: 'center',
                formatter: function(value, ctx) {
                  let val_number = number_format(value, 0);
                  return val_number;
                }
              }
            };

            $(".contLuas").css("height", (100 + (obj.length * 25)) + 'px');

          }

          var title = "Jumlah petak sawah";

          var data = {
            labels: labels,
            datasets: [{
              label: title,
              data: dataSource,
              backgroundColor: coloR,
              borderColor: 'rgba(255, 255, 255)'
            }]
          };

          opt.push(type);
          opt.push(data);
          opt.push(title);
          opt.push(legend);
          opt.push(tooltips);
          opt.push(label);

          return opt;

        break;

        case 'pp':

          var title = "Jumlah petani";

          var type = 'horizontalBar';

          var legend = {
            position: "bottom",
            labels: {
              boxWidth: 15
            }
          }

          var labels = obj.map(function(e) {
            return e.label;
          });

          var dataPemilik = obj.map(function(e) {
            return e.pemilik;
          });

          var dataPenggarap = obj.map(function(e) {
            return e.penggarap;
          });

          var dataNull = obj.map(function(e) {
            return e.kosong;
          });

          var coloR = [];
          for (var i in dataSource) {
            coloR.push(dynamicColors());
          }

          var data = {
            labels: labels,
            datasets: [{
              label: "Petani Pemilik",
              data: dataPemilik,
              backgroundColor: "#28a745",
              borderColor: 'rgba(255, 255, 255)'
            },{
              label: "Petani Penggarap",
              data: dataPenggarap,
              backgroundColor: "#ffc107",
              borderColor: 'rgba(255, 255, 255)'
            },{
              label: "Tidak teridentifikasi",
              data: dataNull,
              backgroundColor: "#adb5bd",
              borderColor: 'rgba(255, 255, 255)'
            }]
          };

          var tooltips = {callbacks: {
            label: function(tooltipItem, data) {
              let label = data.datasets[tooltipItem.datasetIndex].label;
              let val = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
              return label + ': ' + number_format(val, 0);
            }
          }};

          var label = {
            value: {
              align: 'end',
              textAlign: 'center',
              formatter: function(value, ctx) {
                let val_number = number_format(value, 0);
                return val_number;
              }
            }
          };

          $(".contPP").css("height", (100 + (obj.length * 90)) + 'px');

          opt.push(type);
          opt.push(data);
          opt.push(title);
          opt.push(legend);
          opt.push(tooltips);
          opt.push(label);

          return opt;

        break;

        default:
          return opt;

      }
    }

    function createChart(id, opt){

      var ctx = document.getElementById(id).getContext("2d");
      var myChart = new Chart(ctx, {
        type: opt[0],
        data: opt[1],
        options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: opt[2],
            fontSize: 16
          },
          legend: opt[3],
          tooltips: opt[4],
          plugins: {
            datalabels: {
              color: '#fff',
              backgroundColor: 'rgba(50, 50, 50, 0.5)',
              borderRadius: 2,
              labels: opt[5]
            }
          }
        }
      });

    }

    function buildChart(dataType, dataGroup, obj){
      switch (dataType){

        case 'lj':
          opt = optChart('luas', dataGroup, obj);
          createChart('chartLuas', opt);

          opt = optChart('jumlah', dataGroup, obj);
          createChart('ChartJumlah', opt);
        break;

        case 'pp':
          opt = optChart('pp', dataGroup, obj);
          createChart('chartPP', opt);
        break;

        default:
          alert("Build chart failed");

      }
    }

    function buildResult(dataType, dataLevel, dataGroup) {

      $.ajax({
        type : "GET",
        url : "<?php echo base_url('api/report/'); ?>/" + dataType,
        data : {
          "sdcode" : dataLevel,
          "group" : dataGroup
        },
        dataType: "json",
        beforeSend: function(){
          $(".result").html('<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
        },
        success : function(obj, textstatus){

          if (!("error" in obj)) {

            <!-- Chart -->
            $('.result').html(domChart(dataType, dataGroup));
            buildChart(dataType, dataGroup, obj);

            <!-- Data Table -->
            $('.result').append(domTable(dataType));
            var opt = optTable(dataType);
            $("#table-result").DataTable( {
              data: obj,
              dom: "<'row'<'col-sm-12 col-md-6'lB><'col-sm-12 col-md-6'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
              buttons: [{
                "extend": 'collection',
                "text": 'Export',
        				"className": 'btn btn-default btn-sm',
        				"buttons": [
        					{ "extend": "excel", "text": "Excel" },
        					{ "extend": "csv", "text": "CSV" },
        					{ "extend": "pdf", "text": "PDF" }
        				],
        				"dropup": false
        			}],
              "responsive": true,
              "autoWidth": false,
              "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
              "columns": opt[0],
              "columnDefs": opt[1],
              "order": opt[3]
            }).buttons().container().addClass('ml-2 mb-1').appendTo('#table-result_filter');

          }
          else {
            $(".result").html('<h6 class="text-center">Report belum tersedia</h6>');
          }

        },
        error: function (obj, textstatus) {
          $(".result").html('<h6 class="text-center">Report belum tersedia</h6>');
        }
      });
    }

    $( "#level" ).change(function() {
      if($(this).val() == ''){
        $( "#group" ).html('<option value="0">Kecamatan</option><option value="1">Desa</option>');
      }else{
        $( "#group" ).html('<option value="1">Desa</option>');
      }
    });

    $("#buildResult").click(function(){
      dataType = $('#data option:selected').val();
      dataLevel = $('#level option:selected').val();
      dataGroup = $('#group option:selected').val();
      buildResult(dataType, dataLevel, dataGroup);
    });

  });

</script>

<?= $this->endSection() ?>
