<div class="page-body">
  <div class="container">
    <div class="section-title">
      <h3>Designations</h3>
    </div>
    <a href="<?=base_url()?>home" class="mb-3">Back to Home</a>
    <div class="row mb-2">
      <div class="col-md-10">

      </div>
      <div class="col-md-2">
        <button id="btn-add-designation" class="btn btn-success btn-block">+ New</button>
      </div>
    </div>
    
    <div class="section-body">
      <div class="mb-3">
      </div>
      <table id="table-designations" class="table table-hover dt-responsive" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Designation ID #</th>
            <th>Designation</th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Designation ID #</th>
            <th>Designation</th>
            <th>Action</th>
          </tr>
        </tfoot>
      </table>

    </div>
  </div>
</div>

<!--ADD PRODUCT -->
  <div class="modal fade" id="addDesignationModal" tabindex="-1" role="dialog" aria-labelledby="addDesignationModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content" id="modalAdd">
              <div class="modal-header">            
                <h4 class="modal-title">Add Designation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <form id="addProd">
                <div class="modal-body">
                    <div class="form-group">
                      <label>Designation Name</label>
                      <input type="text" name="designationName" id="designationName" class="form-control" required/>
                    </div>


                <div class="modal-footer">
                  <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                  <button id="btn-submit-add-designation" class="btn btn-info" >Add</button>
                </div>

                </div>
              </form>
         
          </div> <!-- end modal-content -->
      </div> <!-- end modal-dialog -->
  </div> <!-- end modal -->

  <div class="modal fade" id="updateDesignationModal" tabindex="-1" role="dialog" aria-labelledby="updateDesignationModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content" id="modalAdd">
              <div class="modal-header">            
                <h4 class="modal-title">Update Designation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <form id="addProd">
                <div class="modal-body">
                  <input type="hidden" name="designationIdUpdate" id="designationIdUpdate" value=""  />
                    <div class="form-group">
                      <label>Designation Name</label>
                      <input type="text" name="designationNameUpdate" id="designationNameUpdate" class="form-control" required/>
                    </div>


                <div class="modal-footer">
                  <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                  <button id="btn-submit-update-designation" class="btn btn-info" >Save</button>
                </div>

                </div>
              </form>
         
          </div> <!-- end modal-content -->
      </div> <!-- end modal-dialog -->
  </div> <!-- end modal -->



<div class="modal fade" id="deleteDesignationModal" tabindex="-1" role="dialog" aria-labelledby="deleteDesignationModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content" id="modalDelete">
              <div class="modal-header">            
                <h4 class="modal-title">Are you sure you want to delete this designation?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              

              <div class="modal-footer">
                <input type="hidden" id="designationDelete" value="" />
                <button id="btn-delete-designation" class="btn btn-danger"  >Yes</button>
                  <input type="button" class="btn btn-primary" data-dismiss="modal" value="Cancel">
                </div>
         
          </div> <!-- end modal-content -->
      </div> <!-- end modal-dialog -->
  </div> <!-- end modal -->



<script type="text/javascript">
   $('#designations a').removeClass('nav-color');
  $('#designations a').addClass('nav-active');
  $ ( document ).ready(function() {
      designations = $("#table-designations").DataTable({
          ajax: {
            url: "<?=base_url()?>ajax/get-designations",
            type: 'GET',
            dataSrc: ''
          },
          responsive:true,
          columnDefs: [
              {
              "targets": 0,
              "data" : "designation_id"
              },

              {
                "targets": 1,
                "data" : "designation_name"
              },
              {
                "targets": 2,
                 "render": function ( data, type, row ) {
                        var html = "";
                        html += "<button class='btn btn-warning btn-sm btn-cancel updateDesignationBtn mr-2'  designationID='" + row['designation_id'] + "'><i class='fas fa-pencil-alt'></i> Update</button>";
                        html += "<button class='btn btn-danger btn-sm btn-cancel deleteDesignationBtn' designationID='" + row['designation_id'] + "'><i class='fas fa-trash-alt'></i> Delete</button>";
                        return html;
                      } 
              },
              ]
        });

      

      $(document).on('click', '.deleteDesignationBtn', function() {
        $('#deleteDesignationModal').modal('show');
          $('#designationDelete').val($(this).attr('designationID'));
      });


      $(document).on('click', '#btn-delete-designation', function() {
          var designation_id = $('#designationDelete').val();
          $.ajax({
            url: '<?=base_url()?>ajax/delete-designation',
            type: 'POST',
            data: {
              designation_id: designation_id
            },
          success:function(data) {
            var result = JSON.parse(data);
            $('#deleteDesignationModal').modal('hide');
            designations.ajax.reload();
          },
          error:function(data) {
            console.log(data);
          }
        });

      });


    $(document).on('click', '#btn-add-designation', function() {
          $('#addDesignationModal').modal('show');
          $('#designationName').val('');
      });
 

    $(document).on('click', '#btn-submit-add-designation', function() {

      var isValid = true;

      if( $('#designationName').val() === ""  ) {
        $('#error_message').text('Please complete all required fields.');
        isValid = false;
      }

      if( isValid ) {
        $.ajax({
          url: '<?=base_url()?>ajax/add-designation',
          type: 'POST',
          data: {
            designation_name: $('#designationName').val()
          },
          success:function(data) {
            console.log(data);
            var result = JSON.parse(data);

            // alert('Designation successfully added!');

          },
          error:function(error) {
            console.log(error);
            console.log('error');
          }
        });
      }

    });


   $(document).on('click', '.updateDesignationBtn', function() {
          var designationID = $(this).attr('designationID');

          $.ajax({
                url: '<?=base_url()?>ajax/get-designation',
                type: 'GET',
                data: {
                  designation_id: designationID
                },
             //  processData:false,
             // contentType:false,
             // cache:false,
             // async:false,
              success:function(data) {
                var result = JSON.parse(data)[0];
                $('#designationNameUpdate').val(result.designation_name);
                $('#designationIdUpdate').val(result.designation_id);
                $('#updateDesignationModal').modal('show');
              }
            });
          
      });

    $(document).on('click', '#btn-submit-update-designation', function() {
      var isValid = true;

      if( $('#designationNameUpdate').val() === ""  ) {
        $('#error_message').text('Please complete all required fields.');
        isValid = false;
      }

      if( isValid ) {
          $.ajax({

          url: '<?=base_url()?>ajax/update-designation',
          type: 'POST',
          data: {
              designation_name: $('#designationNameUpdate').val(),
              designation_id : $('#designationIdUpdate').val()
          },
          success:function(data) {
            console.log(data);

          },
          error:function(data) {
            console.log(data);
            // alert('error');
          }
        });
      }
    });


});

</script>
