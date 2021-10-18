<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Medical Inventory QR System</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/layouts.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/standard.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/custom.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/category.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/datatables.min.css">

	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<!-- 	<script src="<?=base_url()?>assets/js/validate.js"></script> -->
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/datatables.min.js"></script>


	<style>


	</style>
</head>

<body>
	<div class="nav-top container-fluid">
		<div class="row" >
			<img class="nav-logo mx-3" src="<?=base_url()?>assets/img/logos/pnp_logo.png">
			<div class="col col-md-8 ">
				<div class="div-nav-heading" >
					<span class="nav-heading-top">
						<!-- Medical Inventory QR System -->
					</span>
				</div>
				<div class="div-nav-heading" >
					<span class="nav-title">
						<b>Medical Inventory QR System</b>
					</span>
				</div>

			</div>
		</div>

		<div class="row" >
			<div class="col col-md-8"> 

			</div>	
		</div>

	</div>
	<nav class="navbar navbar-expand-sm navbar-dark bg-custom">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsExample03">
			<ul class="navbar-nav mr-auto">

			</ul>


<!-- 		<ul class="navbar-nav">	
			<li class="nav-item dropdown">
				<a class="nav-link nav-color dropdown-toggle nav-user" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?= $this->session->userdata('username'); ?>
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="<?=base_url()?>change-password">Change Password</a>
					<a class="dropdown-item" href="<?=base_url()?>logout">Sign Out</a>
				</div>
			</li>
		</ul> -->
	</div>
</nav>

<div class="page-body">
	<div class="container">
		<div class="section-title">
			<h3>Sign Up</h3>

			<form name="regForm" id="regForm" enctype="multipart/form-data" method="POST" action="register">
				<font color='red'><center><span id="error_message"></span></center></font>  
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="fname">First Name</label>
							<input type="text" class="form-control" formControlName="fname" id="fname" name="fname" />
						</div>

						<div class="form-group">
							<label for="lname">Last Name</label>
							<input type="text" class="form-control" formControlName="lname" id="lname" name="lname" required />
						</div>


						<div class="form-group">
		                  	<label for="employee_id">Employee ID</label>
		                  	<input type="text" class="form-control" formControlName="employee_id" id="employee_id" name="employee_id" placeholder="Employee ID"  required />
		                 </div>


						<div class="form-group">
							<label for="complete_address">Complete Address</label>
							<textarea class="form-control" formControlName="complete_address" id="complete_address" name="complete_address" required  ></textarea> 
						</div>


	                  <div class="form-group">
	                  	<label for="role">Role</label>
	                  	<select class="form-control" formControlName="role" id="role" name="role" >
	                  		<option value="1">Admin</option>
	                  		<option value="2">Staff</option>
	                  	</select>
	                  </div>


	                  <div class="form-group">
	                  	<label for="password">Password</label>
	                  	<input type="password" class="form-control" formControlName="password" id="password" name="password" placeholder="Password"   required/>
	                  </div>

	                  <div class="form-group">
	                  	<label for="cpassword">Confirm Password</label>
	                  	<input type="password" class="form-control" formControlName="cpassword" id="cpassword" name="cpassword" placeholder="Confirm Password"  required />
	                  </div>

	                   <div class="form-group">
	                  	<ul>
	                  		<li>Should have at least 1 number</li>
	                  		<li>Should have at least 1 lower case character</li>
	                  		<li>Should have at least upper case character</li>
	                  	</ul>
	                  </div>


	                  <div class="row">
	                  	<div class=" form-group col-md-6">
	                  		<button type="submit" id="btn-submit-add-product" class="btn btn-success col-md-12" >
	                  			Save
	                  		</button>
	                  	</div>
	                  	<div class="form-group  col-md-6">
	                  		<button type="cancel" id="" class="btn btn-secondary col-md-12" >
	                  			Cancel
	                  		</button>
	                  	</div>
	                  </div>
	              </div>

	              <div class="col-md-3"></div>

	          </div>
	      </form>
	  </div>
	</div>
</div>

<script src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations-v1.0.0.js"></script>

<script>
	$(document).ready(function() {
		$('#home a').removeClass('nav-color');
		$('#home a').addClass('nav-active');

	});
</script>

<script type="text/javascript">


 	$(document).on('click', 'form button[type=submit]', function(e) {
 		var password = $('#password').val();
 		var confirmPassword = $('#cpassword').val();
 		var valid = true;
 		var fields = ['fname', 'lname', 'complete_address', 'employee_id', 'password'];
 		var fieldsValid = true;
 		var message = '';

 		fields.forEach( function(field){
 			if( !$('#' + field).val() ) {
 				fieldsValid = false;
 				message += field + ' is required. ';
 			}
 		} );


 		if( !isPasswordValid(password) ) {
 			message += 'Password is not valid! It should have atleast 1 number, 1 uppercase character and 1 lowercase character. ';
 			valid = false;
 		}

 		if( password !== confirmPassword ) {
 			message += 'Password and confirm password should match! ' ;
 			valid = false;
 		}

 		
 		if( !valid || !fieldsValid ) {
			e.preventDefault(); //prevent the default action
			$('#error_message').text(message);
 		}


 	});


 	function isPasswordValid( value ) {
		return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
	       && /[a-z]/.test(value) // has a lowercase letter
	       && /[A-Z]/.test(value) // has a lowercase letter
	       && /\d/.test(value) // has a digit
	}
	


        
</script>




<footer class="footer">
	<div class="container text-center">
		<span class="footer-copyright">Copyright &copy; <?= date('Y') ?> Medical Inventory System. All Rights Reserved.</span>
	</div>
</footer>


</body>
</html>