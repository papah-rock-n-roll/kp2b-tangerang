<script type="text/javascript">
const chart = document.getElementById("<?= esc($id) ?>").getContext('2d');
let areaChart = new Chart(chart, {
  type: "<?= esc($type) ?>",
  data: {
    labels: <?= json_encode($labels) ?>,
    datasets: [
      {
        label: "<?= esc($title) ?>",
        data: <?= json_encode($values) ?>,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 253, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 255, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)',
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 253, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 255, 255, 1)',
          'rgba(255, 159, 64, 1)',
        ],
        borderWidth: 1
      }
    ]
  },
  options: {
    scales: {
      xAxes: [{
        display: true,
        scaleLabel: {
          display: true,
          labelString: "<?= esc($xlabels) ?>"
        }
      }],
      yAxes: [{
        display: true,
        scaleLabel: {
          display: true,
          labelString: "<?= esc($ylabels) ?>"
        },
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});
</script>