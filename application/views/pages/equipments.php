<div class="page-body">
  <div class="container">
    <div class="section-title">
      <h3>Equipments</h3>
    </div>
    <a href="<?=base_url()?>home" class="mb-3">Back to Home</a>
    <div class="row mb-2">
      <div class="col-md-10">

      </div>
      <div class="col-md-2">
        <button id="btn-add-equipment" class="btn btn-success btn-block">+ New</button>
      </div>
    </div>
    
    <div class="section-body">
      <div class="mb-3">
      </div>
      <table id="table-equipments" class="table table-hover dt-responsive" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Equipment ID #</th>
            <th>Model Number</th>
            <th>Equipment Type</th>
            <th>Designation</th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Equipment ID #</th>
            <th>Model Number</th>
            <th>Equipment Type</th>
            <th>Designation</th>
            <th>Action</th>
          </tr>
        </tfoot>
      </table>

    </div>
  </div>
</div>

<!--ADD PRODUCT -->
  <div class="modal fade" id="addEquipmentModal" tabindex="-1" role="dialog" aria-labelledby="addEquipmentModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content" id="modalAdd">
              <div class="modal-header">            
                <h4 class="modal-title">Add Equipment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <form id="addProd">
                <div class="modal-body">
                    <div class="form-group">
                      <label>Model Number</label>
                      <input type="text" name="modelNumber" id="modelNumber" class="form-control" required/>
                    </div>

                    <div class="form-group">
                      <div class="">
                          <label>Equipment Type</label>
                          <select class="custom-select custom-select-md" id="equipmentType" name="equipmentType">
                          </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="">
                          <label>Designation</label>
                          <select class="custom-select custom-select-md" id="designation" name="designation">
                          </select>
                      </div>
                    </div>

                </div> <!-- end modal-body -->

                <div class="modal-footer">
                  <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                  <button id="btn-submit-add-equipment" class="btn btn-info" >Add</button>
                </div>

              </form>
         
          </div> <!-- end modal-content -->
      </div> <!-- end modal-dialog -->
  </div> <!-- end modal -->


  <!--UPDATE PRODUCT -->
  <div class="modal fade" id="updateEquipmentModal" tabindex="-1" role="dialog" aria-labelledby="updateEquipmentModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content" id="modalAdd">
              <div class="modal-header">            
                <h4 class="modal-title">Update Equipment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <form id="addProd">
                <div class="modal-body">
                  <input type="hidden" id="equipmentIdUpdate" name="equipmentIdUpdate" value="" />
                    <div class="form-group">
                      <label>Model Number</label>
                      <input type="text" name="modelNumberUpdate" id="modelNumberUpdate" class="form-control" required/>
                    </div>

                    <div class="form-group">
                      <div class="">
                          <label>Equipment Type</label>
                          <select class="custom-select custom-select-md" id="equipmentTypeUpdate" name="equipmentTypeUpdate">
                          </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="">
                          <label>Designation</label>
                          <select class="custom-select custom-select-md" id="designationUpdate" name="designationUpdate">
                          </select>
                      </div>
                    </div>

                </div> <!-- end modal-body -->

                <div class="modal-footer">
                  <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                  <button id="btn-submit-update-equipment" class="btn btn-info" >Update</button>
                </div>

              </form>
         
          </div> <!-- end modal-content -->
      </div> <!-- end modal-dialog -->
  </div> <!-- end modal -->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content" id="modalDelete">
              <div class="modal-header">            
                <h4 class="modal-title">Are you sure you want to delete this equipment?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <input type="hidden" id="deleteId" name="deleteId" value="" />

              <div class="modal-footer">
                
                <button id="btn-delete" class="btn btn-danger"  >Yes</button>
                  <input type="button" class="btn btn-primary" data-dismiss="modal" value="Cancel">
                </div>
         
          </div> <!-- end modal-content -->
      </div> <!-- end modal-dialog -->
  </div> <!-- end modal -->

  <div class="modal fade modal-fade-in-scale-up" id="viewEquipmentModal" aria-hidden="true" aria-labelledby="exampleModalTitle"
role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">View Equipment Details <b id="equipment_id_details" ></b></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">

          <div id="details-body">

          </div>
        </div>

      </div>
    </div>
</div>


<script type="text/javascript">
   $('#equipments a').removeClass('nav-color');
  $('#equipments a').addClass('nav-active');

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
            var designation = $('#designation');
            var designationUpdate = $('#designationUpdate');
            designation.empty();
            designationUpdate.empty();
            $.each(JSON.parse(data), function (val, text) {
              designation.append($('<option></option>').attr("value", text.designation_id)
                  .text(text.designation_name));
              designationUpdate.append($('<option></option>').attr("value", text.designation_id)
                  .text(text.designation_name));
            })
          }
        });
  }

  $ ( document ).ready(function() {

      
    getEquipmentTypes();
    getDesignations();
        

      equipments = $("#table-equipments").DataTable({
          ajax: {
            url: "<?=base_url()?>ajax/get-equipments",
            type: 'GET',
            dataSrc: ''
          },
          responsive:true,
          columnDefs: [
              {
              "targets": 0,
              "data" : "equipment_id"
              },
              {
                "targets": 1,
                "data" : "model_number"
              },
              {
                "targets": 2,
                "data" : "equipment_type"
              },
              {
                "targets": 3,
                "data" : "designation_name"
              },
              {
                "targets": 4,
                 "render": function ( data, type, row ) {
                        var html = "";
                        html += "<button class='btn btn-primary btn-sm btn-cancel viewEquipmentBtn mr-2'  equipmentID='" + row['equipment_id'] + "'><i class='fas fa-eye'></i> View</button>";
                        html += "<button class='btn btn-warning btn-sm btn-cancel updateEquipmentBtn mr-2'  equipmentID='" + row['equipment_id'] + "'><i class='fas fa-pencil-alt'></i> Update</button>";
                        html += "<button class='btn btn-danger btn-sm btn-cancel deleteBtn' equipmentID='" + row['equipment_id'] + "'><i class='fas fa-trash-alt'></i> Delete</button>";
                        return html;
                      } 
              },
              ]
        });  

      

    $(document).on('click', '#btn-add-equipment', function() {
          $('#addEquipmentModal').modal('show');
          $('#modelNumber').val('');
          // $('#equipmentType').val('');
          // $('#designation').val('');
      });
 

    $(document).on('click', '#btn-submit-add-equipment', function() {

      var isValid = true;

      if( $('#modelNumber').val() === "" || $('#equipmentType').val() === "" || $('#designation').val() === ""  ) {
        $('#error_message').text('Please complete all required fields.');
        isValid = false;
      }

      if( isValid ) {
        $.ajax({
          url: '<?=base_url()?>ajax/add-equipment',
          type: 'POST',
          data: {
            model_number: $('#modelNumber').val(),
            equipment_type_id : $('#equipmentType').val(),
            designation_id: $('#designation').val()
          },
         //  processData:false,
         // contentType:false,
         // cache:false,
         // async:false,
          success:function(data) {
            console.log(data);
            var result = JSON.parse(data);
            // alert(result);

          },
          error:function(error) {
            console.log(error);
            console.log('error');
            // alert(error);
          }
        });
      }

    });


   $(document).on('click', '.updateEquipmentBtn', function() {
          var equipmentID = $(this).attr('equipmentID');
          getEquipmentTypes();
          getDesignations();
          var valid = false;

          $.ajax({
                url: '<?=base_url()?>ajax/get-equipment',
                type: 'GET',
                data: {
                  equipment_id: equipmentID
                },
             //  processData:false,
             // contentType:false,
             // cache:false,
             // async:false,
              success:function(data) {
                var result = JSON.parse(data)[0];
                $('#equipmentIdUpdate').val(result.equipment_id);
                $('#modelNumberUpdate').val(result.model_number);
                $('#equipmentTypeUpdate').val(result.equipment_type);
                $('#designationUpdate').val(result.designation_name);
                $('#updateEquipmentModal').modal('show');
              }
            });
          
      });

    $(document).on('click', '#btn-submit-update-equipment', function() {
      var isValid = true;

      if( $('#modelNumberUpdate').val() === "" || $('#equipmentTypeUpdate').val() === "" || $('#designationUpdate').val() === ""  ) {
        $('#error_message').text('Please complete all required fields.');
        isValid = false;
      }

      if( isValid ) {
          $.ajax({
          url: '<?=base_url()?>ajax/update-equipment',
          type: 'POST',
          data: {
            equipment_id: $('#equipmentIdUpdate').val(),
              model_number: $('#modelNumberUpdate').val(),
              equipment_type_id : $('#equipmentTypeUpdate').val(),
              designation_id: $('#designationUpdate').val()
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

     $(document).on('click', '.deleteBtn', function() {
        $('#deleteModal').modal('show');
          $('#deleteId').val($(this).attr('equipmentID'));
      });


      $(document).on('click', '#btn-delete', function() {
          var deleteId = $('#deleteId').val();
          $.ajax({
            url: '<?=base_url()?>ajax/delete-equipment',
            type: 'POST',
            data: {
              equipment_id: deleteId
            },
          success:function(data) {
            var result = JSON.parse(data);
            $('#deleteModal').modal('hide');
            equipments.ajax.reload();
          },
          error:function(data) {
            console.log(data);
          }
        });

      });


      $(document).on('click', '.viewEquipmentBtn', function() {
        var equipmentID = $(this).attr('equipmentID');
        var detailsBody = $('#details-body' );

        detailsBody.empty();

        $('#equipment_id_details').text(equipmentID);

        $.ajax({
          url     : '<?=base_url()?>ajax/get-equipment-details',
          type    : 'GET',
          data    : {equipment_id: equipmentID},
          success : function (data) {
            console.log(equipmentID);
            var result = JSON.parse(data)[0];
            
              if( result.qr_code_path ) {
                  detailsBody.append(`<h6 class="mt-1">QR Code</h6><hr>
                  <div class="row">
                  <div class="col-md-12">
                    <a href="<?=base_url()?>assets/qrcodeci/images/`+ result.qr_code_path +`" download>
                        <img src="<?=base_url()?>assets/qrcodeci/images/`+ result.qr_code_path +`" width="200" height="200" />
                    </a>
                  </div>
                  </div>
                  `);
              }


              $('#viewEquipmentModal').modal('show');
            },
            error   : function (errors) {
              console.log(errors);
            }
          });
    });


    function validateImageType(file){
      var fileName = file.value;
      var idxDot = fileName.lastIndexOf(".") + 1;
      var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
      if (extFile=="jpg" || extFile=="jpeg" || extFile=="png" || extFile == "gif"  ){
          
      }else{
          clearInputFile(file);
          alert("Only image files are allowed!");
          
      }   
  }

   function clearInputFile(f){
        if(f.value){
            try{
                f.value = ''; //for IE11, latest Chrome/Firefox/Opera...
            }catch(err){
            }
            if(f.value){ //for IE5 ~ IE10
                var form = document.createElement('form'), ref = f.nextSibling;
                form.appendChild(f);
                form.reset();
                ref.parentNode.insertBefore(f,ref);
            }
        }
    }

});

</script>
