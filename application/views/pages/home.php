<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>HOME</h3>

			<div class="row">
				<div class="col-lg-4 col-6">
					<!-- small box -->
					<div class="small-box bg-info">
						<div class="inner">
							<h3 id="total_equipments">0</h3>

							<p>Total Equipments</p>
						</div>
						<div class="icon">
							<i class="fas fa-briefcase-medical"></i>
						</div>
						<a href="<?=base_url()?>equipments" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-4 col-6">
					<!-- small box -->
					<div class="small-box bg-success">
						<div class="inner">
							<h3 id="total_borrows">0</h3>

							<p>Total Borrows Today</p>
						</div>
						<div class="icon">
							<i class="fas fa-hand-holding"></i>
						</div>
						<!-- <p class="small-box-footer">&nbsp;</p> -->
						<!-- <a href="<?=base_url()?>admin-products" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
						<a href="<?=base_url()?>borrowLogs" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-4 col-6">
					<!-- small box -->
					<div class="small-box bg-warning">
						<div class="inner">
							<h3 id="total_returns">0</h3>

							<p>Total Returns Today</p>
						</div>
						<div class="icon">
							<i class="fas fa-hand-holding fa-flip-horizontal"></i>
						</div>
						<a href="<?=base_url()?>borrowLogs" class="small-box-footer">More info <i class="fas fa-arrow-circle-right "></i></a>
					</div>
				</div>
				
			</div>
			<!-- /.row -->

			<div class="card mt-3">
				<div class="card-header">
					<h5 class="card-title">
						<i class="fas fa-chart-pie mr-1"></i>
						Number of Borrowed Equipments
					</h5>
					<div class="card-tools">
						<ul class="nav nav-pills ml-auto">
							<li class="nav-item">
								<a class="nav-link active" href="" data-toggle="tab" id="weeklyBorrows" >This Week</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="" data-toggle="tab" id="monthlyBorrows"  >Month</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href=""  data-toggle="tab" id="yearlyBorrows">Year</a>
							</li>
						</ul>
					</div>
				</div><!-- /.card-header -->
				<div class="card-body">
					<div class="tab-content p-0">
						<!-- Morris chart - Sales -->
						<div class="chart tab-pane active" id="revenue-chart"
						style="position: relative; height: auto;"></div>
						<canvas id="myChart" style="max-height: 400px;" ></canvas>
					</div>
				</div>
			</div><!-- /.card-body -->

			<div class="col-lg-12" style="margin-bottom: 100px;">
				
			</div>

		</div>
	</div>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	$(document).ready(function() {
		$('#admin-home a').removeClass('nav-color');
		$('#admin-home a').addClass('nav-active');

		const ctx = document.getElementById('myChart');
          const myChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: [],
                  datasets: [{
                      label: '',
                      data: [],
                      backgroundColor: 'rgba(255, 99, 132, 1)',
                      borderColor: 'rgba(255, 99, 132, 1)',
                      borderWidth: 1
                  }]
              },
              options: {
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          });

        function changeChart( color, label, data, labels ) {
              $('document').ready(function(){
                  myChart.data.datasets[0].backgroundColor = color;
                  myChart.data.datasets[0].borderColor = color;
                  myChart.data.datasets[0].label = label;
                  myChart.data.datasets[0].data = data;
                  myChart.data.labels = labels;
                  myChart.update();
              });
          }


      //  onclick="changeChart('rgba(255, 99, 132, 1)', 'Red', [12, 19, 3, 5, 2, 3])"
          $( '#weeklyBorrows' ).click( function() {
              weeklyBorrows();
          } );

          $('#monthlyBorrows').click(function() {
                $.ajax({
                    url: "<?=base_url()?>ajax/get-monthly-borrows",
                    type: 'GET',
                    success: function (data) {
                      var result = JSON.parse(data);
                      var data = [];
                      var labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                      for( var i = 0; i < result.length; i++ ) {
                          if( result[i][0].total ) {
                            data.push( parseInt(result[i][0].total) );
                          }else {
                            data.push(0);
                          }
                      }

                      console.log(data);

                      changeChart('rgba(255, 99, 132, 1)', "This Month's Borrows", data, labels);
                    }
             });
          });

          $('#yearlyBorrows').click(function() {
                $.ajax({
                    url: "<?=base_url()?>ajax/get-yearly-borrows",
                    type: 'GET',
                    success: function (data) {
                      var result = JSON.parse(data);
                      var data = [];
                      var labels = [];

                      for( var i = 0; i < result.length; i++ ) {
                          labels.push( result[i][0].year );
                          if( result[i][0].total ) {
                            data.push( parseInt(result[i][0].total) );
                          }else {
                            data.push(0);
                          }
                      }

                      console.log(data);

                      changeChart('rgba(99, 255, 99, 1)', "This Year's Borrows", data, labels);
                    }
             });
          });
          weeklyBorrows();


          function weeklyBorrows() {
              $.ajax({
              url: "<?=base_url()?>ajax/get-weekly-borrows",
              type: 'GET',
              success: function (data) {
                var result = JSON.parse(data);
                var data = [];
                var labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

                for( var i = 0; i < result.length; i++ ) {
                    if( result[i][0].total ) {
                      data.push( parseFloat(result[i][0].total) );
                    }else {
                      data.push(0);
                    }
                }

                console.log(data);

                changeChart('rgba(99, 99, 255, 1)', "This Week's Borrows", data, labels);
              }
           });
          }

          $.ajax({
			    url: "<?=base_url()?>ajax/get-totals",
			    type: 'GET',
			    success: function (data) {
			      var total_equipments = $('#total_equipments');
			      var total_borrows = $('#total_borrows');
			      var total_returns = $('#total_returns');

			      var text = JSON.parse(data);
			      console.log(text);

				    total_equipments.text(text.total_equipments);
			        total_borrows.text(text.total_borrows);
			        total_returns.text(text.total_returns);

		    }
		  });
	});
</script>