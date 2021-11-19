<div class="page-body">
  <div class="container">
    <div class="section-title">
      <h3>Equipment Type</h3>
    </div>
    <a href="<?=base_url()?>home" class="mb-3">Back to Home</a>
    <div class="row mb-2">
      <div class="col-md-10">

      </div>
      <div class="col-md-2">
        <button id="btn-add-equipment-type" class="btn btn-success btn-block">+ New</button>
      </div>
    </div>
    
    <div class="section-body">
      <div class="mb-3">
      </div>
      <table id="table-equipment-types" class="table table-hover dt-responsive" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Equipment Type ID #</th>
            <th>Equipment Type</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Equipment Type ID #</th>
            <th>Equipment Type</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </tfoot>
      </table>

    </div>
  </div>
</div>


<div class="modal fade modal-fade-in-scale-up" id="add-equipment-type-modal" aria-hidden="true" aria-labelledby="exampleModalTitle"
role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Equipment Type</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form [formGroup]="myForm" name="myForm" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="container">
            <font color='red'><span id="error_message"></span></font>
            <div class="form-group">
            <label for="label">Equipment Type</label>
            <input type="text" class="form-control" formControlName="label" placeholder="X-Ray" id="equipment_type" name="equipment_type" required />
          </div>

          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control"
              formControlName="description" id="description" name="description" required  />
          </div>
<!-- 
          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" min="1" class="form-control" formControlName="quantity" id="quantity" name="quantity" required />
          </div> -->


          </div>
        </div>
        <div class="modal-footer">
          <button id="btn-submit-equipment-type" class="btn btn-success col-6" >
            Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade modal-fade-in-scale-up" id="update-equipment-type-modal" aria-hidden="true" aria-labelledby="exampleModalTitle"
role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Equipment Type</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form [formGroup]="myForm" name="myForm" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="container">
            <input type="hidden" name="equipmentTypeIdUpdate" id="equipmentTypeIdUpdate" value=""  />
            <font color='red'><span id="error_message"></span></font>
            <div class="form-group">
            <label for="label">Equipment Type</label>
            <input type="text" class="form-control" formControlName="label" placeholder="X-Ray" id="equipment_type_update" name="equipment_type_update" required />
          </div>

          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control"
              formControlName="description" id="descriptionUpdate" name="descriptionUpdate" required  />
          </div>
<!-- 
          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" min="1" class="form-control" formControlName="quantity" id="quantity" name="quantity" required />
          </div> -->


          </div>
        </div>
        <div class="modal-footer">
          <button id="btn-submit-update-equipment-type" class="btn btn-success col-6" >
            Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content" id="modalDelete">
              <div class="modal-header">            
                <h4 class="modal-title">Are you sure you want to delete this equipment type?</h4>
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

<script type="text/javascript">
  $('#equipment-type a').removeClass('nav-color');
  $('#equipment-type a').addClass('nav-active');
  var equipment_types;
  $ ( document ).ready(function() {
      equipment_types = $("#table-equipment-types").DataTable({
          ajax: {
            url: "<?=base_url()?>ajax/get-equipment-types",
            type: 'GET',
            dataSrc: ''
          },
          responsive:true,
          columnDefs: [

              {
              "targets": 0,
              "data" : "equipment_type_id"
              },
              {
              "targets": 1,
              "data" : "equipment_type"
              },
              {
              "targets": 2,
              "data" : "description"
              },
              // {
              // "targets": 3,
              // "data" : "quantity"
              // },
              {
              "targets": 3,
               "render": function ( data, type, row ) {
                      var html = "";
                      html += "<button class='btn btn-warning  btn-sm btn-cancel updateEquipmentTypeBtn mr-2' equipmentTypeID='" + row['equipment_type_id'] + "'><i class='fas fa-pencil-alt'></i>  Update</button>";
                      html += "<button class='btn btn-danger btn-sm btn-cancel deleteBtn mr-2' equipmentTypeID='" + row['equipment_type_id'] + "'><i class='fas fa-trash-alt'></i> Delete</button>";

                      return html;
                    } 
              },
              ]
        });

      $(document).on('click', '#btn-add-equipment-type', function() {
          $('#add-equipment-type-modal').modal('show');
          $('#equipment_type').val('');
          $('#description').val('');
          $('#quantity').val('');
      });


    $(document).on('click', '#btn-submit-equipment-type', function() {

      var isValid = true;

      if( $('#equipment_type').val() === "" || $('#description').val() === "" || $('#quantity').val() === "") {
        $('#error_message').text('Please complete all required fields.');
        isValid = false;
      }

      if( isValid ) {
          $.ajax({
          url: '<?=base_url()?>ajax/add-equipment-type',
          type: 'POST',
          data: {
            equipment_type: $('#equipment_type').val(),
            description : $('#description').val(),
            quantity: $('#quantity').val()
          },
          success:function(data) {
            console.log(data);
            var result = JSON.parse(data);

          }
        });
      }
    });


    $(document).on('click', '.updateEquipmentTypeBtn', function() {
          var equipmentTypeID = $(this).attr('equipmentTypeID');

          $.ajax({
                url: '<?=base_url()?>ajax/get-equipment-type',
                type: 'GET',
                data: {
                  equipment_type_id: equipmentTypeID
                },
             //  processData:false,
             // contentType:false,
             // cache:false,
             // async:false,
              success:function(data) {
                var result = JSON.parse(data)[0];
                $('#equipment_type_update').val(result.equipment_type);
                $('#descriptionUpdate').val(result.description);
                $('#equipmentTypeIdUpdate').val(result.equipment_type_id);
                $('#update-equipment-type-modal').modal('show');
              }
            });
          
      });

    $(document).on('click', '#btn-submit-update-equipment-type', function() {
      var isValid = true;

      if( $('#equipment_type_update').val() === "" || $('#descriptionUpdate').val() === ""   ) {
        $('#error_message').text('Please complete all required fields.');
        isValid = false;
      }

      if( isValid ) {
          $.ajax({

          url: '<?=base_url()?>ajax/update-equipment-type',
          type: 'POST',
          data: {
              equipment_type: $('#equipment_type_update').val(),
              description: $('#descriptionUpdate').val(),
              equipment_type_id : $('#equipmentTypeIdUpdate').val(),
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
          $('#deleteId').val($(this).attr('equipmentTypeID'));
      });


      $(document).on('click', '#btn-delete', function() {
          var deleteId = $('#deleteId').val();
          $.ajax({
            url: '<?=base_url()?>ajax/delete-equipment-type',
            type: 'POST',
            data: {
              equipment_type_id: deleteId
            },
          success:function(data) {
            var result = JSON.parse(data);
            $('#deleteModal').modal('hide');
            equipment_types.ajax.reload();
          },
          error:function(data) {
            console.log(data);
          }
        });

      });


});

</script>