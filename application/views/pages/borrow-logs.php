<div class="page-body">
  <div class="container">
    <div class="section-title">
      <h3 id="print_title">Borrow Logs</h3>
    </div>
    <a href="<?=base_url()?>home" class="mb-3">Back to Home</a>
    <div class="row mb-2">
      <div class="col-md-10">

      </div>
      <div class="col-md-2">
         <!--  <a href="<?=base_url()?>home" class="mb-3">Clear filters</a> -->
      </div>
    </div>
    
    <div class="section-body mb-5">
      <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-2 form-group">
            <label for="status">Status </label>
            <select class="form-control required-input" name="status_filter" id="status_filter" data-parsley-required="true">
              <option value="-1">Select status</option>
                <option value="Borrowed">Borrowed</option>
                <option value="Returned">Returned</option>
              </select>
          </div>

          <div class="col-md-3 form-group">
            <label for="borrowed_by_filter">Borrowed by </label>
            <select class="form-control required-input" name="borrowed_by_filter" id="borrowed_by_filter" data-parsley-required="true">
                <option value=""></option>
              </select>
          </div>

          <div class="col-md-3 form-group">
            <label for="designation_filter">Designation </label>
            <select class="form-control required-input" name="designation_filter" id="designation_filter" data-parsley-required="true">
                <option value=""></option>
              </select>
          </div>

          <div class="col-md-2 form-group">
            <label for="date_borrowed_filter">Date Borrowed </label>
            <input type="date" class="form-control" name="date_borrowed_filter" id="date_borrowed_filter" />
          </div>
      </div>
      <div class="mb-3">
      </div>


      <table id="table-borrow-logs" class="table table-hover dt-responsive"  cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Model Number</th>
            <th>Equipment Type</th>
            <th>Borrowed Designation</th>
            <th>Status</th>
            <th>Purpose</th>
            <th>Date Borrowed</th>
            <th>Date Returned</th>
            <th>Borrowed By</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Model Number</th>
            <th>Equipment Type</th>
            <th>Borrowed Designation</th>
            <th>Status</th>
            <th>Purpose</th>
            <th>Date Borrowed</th>
            <th>Date Returned</th>
            <th>Borrowed By</th>
          </tr>
        </tfoot>
      </table>

    </div>

    <div class="mb-5"></div>
    <div class="mb-5"></div>

  </div>
</div>




<script type="text/javascript">
  $('#logs-anchor').removeClass('nav-color');
  $('#logs-anchor').addClass('nav-active');
  $('#borrowLogs').removeClass('nav-color');
  $('#borrowLogs').addClass('nav-active');
  var borrowLogs;


  $ ( document ).ready(function() {

        getDesignations();
        getBorrowedBy();
        getBorrowLogs();


        $(document).on('change', '#status_filter', function() {
            var status_filter = $(this).val();
            borrowLogs.destroy();
            getBorrowLogs();
        });

        $(document).on('change', '#borrowed_by_filter', function() {
            var borrowed_by_filter = $(this).val();
            borrowLogs.destroy();
            getBorrowLogs();
        });

        $(document).on('change', '#designation_filter', function() {
            var designation_filter = $(this).val();
            borrowLogs.destroy();
            getBorrowLogs();
        });

        $(document).on('change', '#date_borrowed_filter', function() {
            var date_borrowed_filter = $(this).val();
            borrowLogs.destroy();
            getBorrowLogs();
        });

});

  function getBorrowLogs() {
    var designation_id = $('#designation_filter').val() ? $('#designation_filter').val() : "-1" ;
    var status = $('#status_filter').val() ? $('#status_filter').val() : "-1";
    var user_id = $('#borrowed_by_filter').val() ? $('#borrowed_by_filter').val() : "-1";
    var date_borrowed = $('#date_borrowed_filter').val() ? $('#date_borrowed_filter').val() : "-1";

    
    borrowLogs = $("#table-borrow-logs").DataTable({
          ajax: {
            url: "<?=base_url()?>ajax/get-borrow-logs",
            type: 'GET',
            data: { 
                designation: designation_id,
                status: status,
                borrowed_by: user_id,
                date_borrowed: date_borrowed
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
                var title = "Borrow Logs";

                if( status != "-1" || user_id != "-1" || designation_id != "-1" || date_borrowed != "-1") {
                    title += " with";
                }

                if( status != "-1" ) {
                    title += " a status of " +  $('#status_filter option:selected').text();
                }

                if( user_id != "-1" ) {
                    if( status != "-1" ) {
                      title += ", ";
                    }

                    title += " a name of " + $('#borrowed_by_filter option:selected').text();
                }

                if( designation_id != "-1" ) {
                    if( status != "-1" || user_id != "-1" ) {
                      title += ", ";
                    }

                    title += " a designation of " + $('#designation_filter option:selected').text();
                }

                if( date_borrowed != "-1" ) {
                    if( status != "-1" || user_id != "-1" || designation_id != "-1" ) {
                      title += ", ";
                    }

                    title += " a borrowed date of " + $('#date_borrowed_filter').val();
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
                var title = "Borrow Logs";

                if( status != "-1" || user_id != "-1" || designation_id != "-1" || date_borrowed != "-1") {
                    title += " with";
                }

                if( status != "-1" ) {
                    title += " a status of " +  $('#status_filter option:selected').text();
                }

                if( user_id != "-1" ) {
                    if( status != "-1" ) {
                      title += ", ";
                    }

                    title += " a name of " + $('#borrowed_by_filter option:selected').text();
                }

                if( designation_id != "-1" ) {
                    if( status != "-1" || user_id != "-1" ) {
                      title += ", ";
                    }

                    title += " a designation of " + $('#designation_filter option:selected').text();
                }

                if( date_borrowed != "-1" ) {
                    if( status != "-1" || user_id != "-1" || designation_id != "-1" ) {
                      title += ", ";
                    }

                    title += " a borrowed date of " + $('#date_borrowed_filter').val();
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
                var title = "Borrow Logs";

                if( status != "-1" || user_id != "-1" || designation_id != "-1" || date_borrowed != "-1") {
                    title += " with";
                }

                if( status != "-1" ) {
                    title += " a status of " +  $('#status_filter option:selected').text();
                }

                if( user_id != "-1" ) {
                    if( status != "-1" ) {
                      title += ", ";
                    }

                    title += " a name of " + $('#borrowed_by_filter option:selected').text();
                }

                if( designation_id != "-1" ) {
                    if( status != "-1" || user_id != "-1" ) {
                      title += ", ";
                    }

                    title += " a designation of " + $('#designation_filter option:selected').text();
                }

                if( date_borrowed != "-1" ) {
                    if( status != "-1" || user_id != "-1" || designation_id != "-1" ) {
                      title += ", ";
                    }

                    title += " a borrowed date of " + $('#date_borrowed_filter').val();
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
                "data" : "borrowed_designation"
              },
              {
                "targets": 3,
                 "render": function ( data, type, row ) {
                      return row['date_returned'] !== 'N/A' ? "Returned" : "Borrowed";
                  } 
              },
              {
                "targets": 4,
                "data" : "purpose"
              },
              {
                "targets": 5,
                "data" : "date_borrowed"
              },
              {
                "targets": 6,
                "data" : "date_returned"
              },
              {
                "targets": 7,
                "data" : "borrowed_by"
              }

              ]
        });  
  }

  function getEquipmentTypes() {
    $.ajax({
          url: "<?=base_url()?>ajax/get-equipment-types",
          type: 'GET',
          success: function (data) {
            var equipmentType = $('#equipmentType');
            var equipmentTypeUpdate = $('#equipmentTypeUpdate');
            equipmentType.empty();
            equipmentTypeUpdate.empty();
            $.each(JSON.parse(data), function (val, text) {
              equipmentType.append($('<option></option>').attr("value", text.equipment_type_id)
                  .text(text.equipment_type));
              equipmentTypeUpdate.append($('<option></option>').attr("value", text.equipment_type_id)
                  .text(text.equipment_type));
            })
          }
        });
  }

  function getDesignations() {
    $.ajax({
          url: "<?=base_url()?>ajax/get-designations",
          type: 'GET',
          success: function (data) {
            var designation = $('#designation_filter');
            designation.empty();
            designation.append($('<option></option>').attr("value", "-1")
                  .text("Select Designation"));

            $.each(JSON.parse(data), function (val, text) {
              designation.append($('<option></option>').attr("value", text.designation_id)
                  .text(text.designation_name));
            })
          }
        });
  }

  function getBorrowedBy() {
    $.ajax({
          url: "<?=base_url()?>ajax/get-all-users",
          type: 'GET',
          success: function (data) {
            var borrowedBy = $('#borrowed_by_filter');
            borrowedBy.empty();
            borrowedBy.append($('<option></option>').attr("value", "-1")
                  .text("Select User"));

            $.each(JSON.parse(data), function (val, text) {
              borrowedBy.append($('<option></option>').attr("value", text.user_id)
                  .text(text.first_name + ' ' + text.last_name));
            })
          }
        });
  }

</script>
