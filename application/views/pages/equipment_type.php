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
            <th>Equipment ID #</th>
            <th>Equipment Type</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Equipment ID #</th>
            <th>Equipment Type</th>
            <th>Description</th>
            <th>Quantity</th>
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
        <button type="button" class="close" aria-label="Close"
         (click)="activeModal.dismiss('Cross click')">
        </button>
      </div>
      <form [formGroup]="myForm" name="myForm" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="container">
            <font color='red'><span id="error_message"></span></font>
            <div class="form-group">
            <label for="label">Equipment Type</label>
            <input type="text" 
              class="form-control"
              formControlName="label" placeholder="X-Ray" id="equipment_type" name="equipment_type" required />
          </div>

          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control"
              formControlName="description" id="description" name="description" required  />
          </div>

          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" min="1" class="form-control" formControlName="quantity" id="quantity" name="quantity" required />
          </div>


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
              {
              "targets": 3,
              "data" : "quantity"
              },
              {
              "targets": 4,
               "render": function ( data, type, row ) {
                      var html = "";
                      html += "<button class='btn btn-primary  btn-cancel updateBtn mr-2' equipmentTypeID='" + row['equipment_type_id'] + "'>Update</button>";
                      html += "<button class='btn btn-danger btn-cancel cancelBtn mr-2' equipmentTypeID='" + row['equipment_type_id'] + "'>Delete</button>";

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

});

</script>