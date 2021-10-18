<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Manage Accounts</h3>
		</div>
		<div class="section-body">
			<table id="users" class="table table-hover dt-responsive" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>User ID #</th>
						<th>Username</th>
						<th>Mobile Number</th>
						<th>Email</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>User ID #</th>
						<th>Username</th>
						<th>Mobile Number</th>
						<th>Email</th>
						<th>Actions</th>
					</tr>
				</tfoot>
			</table>

		</div>
	</div>
</div>


	<!-- Change Password modal -->
	<div class="modal fade modal-fade-in-scale-up" id="new-pass-modal" aria-hidden="true" aria-labelledby="exampleModalTitle"
	 role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header bgc-primary">
					<h4 class="modal-title white mt-15">New Password</h4>
					<button type="button" class="close white" data-dismiss="modal" aria-label="Close">
			       	 	<span aria-hidden="true">×</span>
			        </button>
				</div>
				<div class="modal-body mt-15">
					<form id="form-addadmin" method="post">
						<div class="form-group">
							<div class="row">
								<input type="hidden" id="np_person_id" name="np_person_id" value='' />
								<div class="col-md-12">
									<div class="label-input">Email</div>
									<input type="email" class="form-control form-input" id="np-email" name="np-email" readonly>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<div class="label-input">First Name </div>
									<input type="text" class="form-control form-input" id="np-fname" name="np-fname" readonly>
								</div>
								<div class="col-md-6">
									<div class="label-input">Last Name </div>
									<input type="text" class="form-control form-input" id="np-lname" name="np-lname" readonly>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<div class="label-input">Faculty Number</div>
									<input type="text" class="form-control form-input" id="np-faculty_number" name="np-faculty_number" readonly>
								</div>
								<div class="col-md-6">
									<div class="label-input">Password <span class="required">*</span></div>
									<input type="text" class="form-control form-input" id="new-pword" name="new-pword" readonly>
								</div>
							</div>
						</div>
					</form>
					<div class="message"><span>Please take note of the new password.</span></div>
				</div>

				<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
						<button type="button" id="btn-confirm-new-pass" class="btn btn-primary">Confirm</button>
				</div>
			</div>
		</div>
	</div>

<script>
	var users;
	$(document).ready(function() {
		$('#account-management a').removeClass('nav-color');
		$('#account-management a').addClass('nav-active');
			users = $("#users").DataTable({
				ajax: {
					url: "<?=base_url()?>ajax/get-all-users",
					dataSrc: ''
				},
				responsive:true,
				// "order": [[ 5, "desc" ]],
				columns: [
				{ data: 'user_id'},
				{ data: 'username' },
				{ data: 'mobile_number' },
				{ data: 'email'},
				{ defaultContent: "<button class='btn btn-secondary btn-sm btn-view'>View</button><button class='btn btn-danger btn-sm btn-delete ml-3'>Delete</button>"
				
			}
				],
				columnDefs: [
					// { className: "hidden", "targets": [0]},
					// { className: "acct-name", "targets": [1]},
				]
		});

		$(document).on('click', '.btn-view', function() {
			var id = $(this).closest('tr').find('td').eq(0).text();
			window.location.href = "<?php echo base_url()?>view_profile/" + id;
		});


		$(document).on('click', '.btn-delete', function() {
			var id = $(this).closest('tr').find('td').eq(0).text();
			$.ajax({
                url: '<?=base_url()?>ajax/delete-user',
                type: 'POST',
                data: {
                	user_id: id,
                },
                success:function(data) {
                	// $('#add-account-modal').modal('hide');
                	alert("Account Successfully Deleted!");
                	users.ajax.reload();
                }
            });
		});

	});
</script>