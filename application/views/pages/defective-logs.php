<div class="page-body">
  <div class="container">
    <div class="section-title">
      <h3 id="print_title">Defective Logs</h3>
    </div>
    <a href="<?=base_url()?>home" class="mb-3">Back to Home</a>
    <div class="row mb-2">
      <div class="col-md-10">

      </div>
    </div>
    
    <div class="section-body">
      <div class="row">
          <div class="col-md-9"></div>
          <div class="col-md-3 form-group">
            <label for="status">Status </label>
            <select class="form-control required-input" name="status_filter" id="status_filter" data-parsley-required="true">
              <option value="-1">Select status</option>
                <option value="Fixed">Fixed</option>
                <option value="Under Repair">Under Repair</option>
              </select>
          </div>

      </div>
      <div class="mb-3">
      </div>
      <table id="table-defective-logs" class="table table-hover dt-responsive" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Model Number</th>
            <th>Equipment Type</th>
            <th>Defect Description</th>
            <th>Status</th>
            <th>Cause</th>
            <th>Fix</th>
            <th>Date of Defect</th>
            <th>Date Fixed</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Model Number</th>
            <th>Equipment Type</th>
            <th>Defect Description</th>
            <th>Status</th>
            <th>Cause</th>
            <th>Fix</th>
            <th>Date of Defect</th>
            <th>Date Fixed</th>
          </tr>
        </tfoot>
      </table>

    </div>
  </div>
</div>




<script type="text/javascript">
  $('#logs-anchor').removeClass('nav-color');
  $('#logs-anchor').addClass('nav-active');
  $('#defectiveLogs').removeClass('nav-color');
  $('#defectiveLogs').addClass('nav-active');
  var defectiveLogs;

  $ ( document ).ready(function() {
      getDefectiveLogs();

      $(document).on('change', '#status_filter', function() {
            var status_filter = $(this).val();
            defectiveLogs.destroy();
            getDefectiveLogs();
      });

  });


  function getDefectiveLogs() {
    var status = $('#status_filter').val() ? $('#status_filter').val() : "-1";
    defectiveLogs = $("#table-defective-logs").DataTable({
          ajax: {
            url: "<?=base_url()?>ajax/get-defect-logs",
            type: 'GET',
            data: {
              status: status
            },
            dataSrc: ''
          },
          dom: "<'row'<'col-md-6'B><'col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
          lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'All']
          ],
          buttons: [{
              extend: 'print',
              text: '<i class="fas fa-print fa-1x"></i> Print',
              messageTop: function() {
                var title = "Defective Logs";

                if( status != "-1" ) {
                    title += " with";
                }

                if( status != "-1" ) {
                    title += " a status of " +  $('#status_filter option:selected').text();
                }

                return title;
              },
              filename: function() {
                return $('#print_title').text().trim();
              },
            },
            {
              extend: 'pdf',
              text: '<i class="fas fa-file-pdf fa-1x" aria-hidden="true"></i> PDF',
              messageTop: function() {
                var title = "Defective Logs";

                if( status != "-1" ) {
                    title += " with";
                }

                if( status != "-1" ) {
                    title += " a status of " +  $('#status_filter option:selected').text();
                }

                return title;
              },
              filename: function() {
                return $('#print_title').text().trim() + ' PDF';
              },

            },
            {
              extend: 'excel',
              text: '<i class="fas fa-file-excel" aria-hidden="true"></i> Excel',
              messageTop: function() {
                var title = "Defective Logs";

                if( status != "-1" ) {
                    title += " with";
                }

                if( status != "-1" ) {
                    title += " a status of " +  $('#status_filter option:selected').text();
                }

                return title;
              },
              filename: function() {
                return $('#print_title').text().trim() + ' Excel' ;
              },
            },
            'pageLength'
          ],
          responsive:true,
          columnDefs: [
              // {
              // "targets": 0,
              // "data" : "equipment_id"
              // },
              {
                "targets": 0,
                "data" : "model_number"
              },
              {
                "targets": 1,
                "data" : "equipment_type"
              },
              {
                "targets": 2,
                "data" : "defect_description"
              },
              {
                "targets": 3,
                "render": function ( data, type, row ) {
                    return row['date_fixed'] == 'N/A' ? "<span class='badge-pill badge-danger'>Under Repair</span>" : "<span class='badge-pill badge-success'>Fixed</span>"  ;
                } 
              },
              {
                "targets": 4,
                "data" : "cause"
              },
              {
                "targets": 5,
                "data" : "fix"
              },
              {
                "targets": 6,
                "data" : "defective_date"
              },
              {
                "targets": 7,
                "data" : "date_fixed"
              }

              ]
        });  
  }

</script>
