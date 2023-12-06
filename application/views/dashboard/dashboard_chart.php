<style>
.content-wrapper{
  min-height: 800px !important; 
}

.bg-yellow {
    background-color: #f39c12 !important;
}

.bg-yellow, .bg-yellow>a {
    color: #fff !important;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>  

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
          <div class="col-md-6">
            <!-- DONUT CHART -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">E-Document Chart <span class="pill_button"> <?php echo $this_month; ?> </span></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card ">
              <div class="card-header">
                <h3 class="card-title">E-Document Line Chart <span class="pill_button"> <?php echo $this_year; ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="lineChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>       
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
        
        <div class="row">
          <div class="col-md-6">
            <!-- Announcement -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Latest Announcement</h3>

                <div class="card-tools">
                    <a href="" class="btn btn-primary btn-xs">Read More <i class="fa fa-arrow-circle-right"></i></a>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
              </div>
              <div class="card-body row">
                <div class="timeline">
                    <!-- timeline time label -->
                    <div class="time-label">
                        <span class="bg-red">
                            <?php echo $announcement->row('docdate'); ?>
                        </span>
                    </div>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <div>
                        <i class="fas fa-envelope bg-blue"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><?php echo $announcement->row('title'); ?></h3>

                            <div class="timeline-body">
                                <?php echo $announcement->row('content'); ?>
                            </div>
                        </div>
                    </div>
                    <!-- END timeline item -->
                    <!-- timeline item -->
                    <div>
                        <i class="fas fa-clock bg-gray"></i>
                    </div>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <!-- Quick Acknowledge buttons -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Quick Acknowledgements</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
              </div>
              <div class="card-body">
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
$(document).ready(function() {
  var get_einvoice_count = "<?php echo $get_einvoice_query; ?>";
  var get_ecn_count = "<?php echo $get_ecn_query; ?>";
  var get_einvoice_year = <?php echo $get_einvoice_year; ?>;
  var get_ecn_year = <?php echo $get_ecn_year; ?>;
  // alert(get_einvoice_count); die;

  //-------------
  //- DONUT CHART -
  //-------------
  var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
  var donutData        = {
    labels: [
        'E-Invoice',
        'E-CN'
    ],
    datasets: [
      {
        data: [get_einvoice_count,get_ecn_count],
        backgroundColor : ['#00a65a', '#f56954'],
      }
    ]
  }
  var donutOptions     = {
    maintainAspectRatio : false,
    responsive : true,
  }
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  new Chart(donutChartCanvas, {
    type: 'doughnut',
    data: donutData,
    options: donutOptions
  })

  //-------------
  //- LINE CHART -
  //-------------
  var e_document_labels = [
    <?php foreach ($get_einvoice_year_query as $key) {
      echo " ' ". $key['month_code']." ' , ";
    } ?>
  ];

  var current_config = {
    type: 'line',
    data: {
      labels: e_document_labels,
      datasets: [
        {
          label: "E-Invoice",
          backgroundColor     : 'transparent',
          borderColor         : '#00a65a',
          data: [
            <?php foreach ($get_einvoice_year_query as $key) {
              echo $key['count_doc'].',';
            } ?>
          ],
          fill: true,
        },
        {
          label: "E-CN",
          backgroundColor     : 'transparent',
          borderColor: '#f56954',
          data: [
            <?php foreach ($get_ecn_year_query as $key) {
              echo $key['count_doc'].',';
            } ?>
          ],
          fill: true,
        },
      ]
    },
    options: {
      responsive: true,
      title: {
        display: false,
      },
      tooltips: {
        mode: 'index',
        intersect: false,
        callbacks: {
          label: function(tooltipItem, data) {
            var datasetLabel = data.datasets[tooltipItem.datasetIndex].label;
            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
            return datasetLabel + ': ' + value;
          }
        }
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Month'
          }
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Document'
          },
          ticks: {
          beginAtZero: true,
          userCallback: function(label, index, labels) {
              // when the floored value is the same as the value we have a whole number
              if (Math.floor(label) === label) {
                  return label;
              }
            }
          }
        }]
      }
    }
  };

  var current_ctx = document.getElementById("lineChart").getContext("2d");
  window.myLine = new Chart(current_ctx, current_config);

});
</script>
  
