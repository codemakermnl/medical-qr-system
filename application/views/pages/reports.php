<div class="page-body">
  <div class="container">
    <div class="section-title">
      <h3>Reports</h3>
    </div>
    <a href="<?=base_url()?>home" class="mb-3">Back to Home</a>
    <div class="row mb-2">
      <div class="col-md-10">

      </div>
    </div>
    
    <div class="section-body">
      <div class="mb-3">
      </div>
      <table id="table-reports" class="table table-hover dt-responsive" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Model Number</th>
            <th>Equipment Type</th>
            <th>Report Description</th>
            <th>Date Reported</th>
            <th>Reported By</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Model Number</th>
            <th>Equipment Type</th>
            <th>Report Description</th>
            <th>Date Reported</th>
            <th>Reported By</th>
          </tr>
        </tfoot>
      </table>

    </div>
  </div>
</div>




<script type="text/javascript">
   $('#reports a').removeClass('nav-color');
  $('#reports a').addClass('nav-active');


  $ ( document ).ready(function() {
        

     var reports = $("#table-reports").DataTable({
          ajax: {
            url: "<?=base_url()?>ajax/get-reports",
            type: 'GET',
            dataSrc: ''
          },
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
                "data" : "date_reported"
              },
              {
                "targets": 4,
                "data" : "reported_by"
              }

              ]
        });  


});

</script>
