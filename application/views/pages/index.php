<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Medical QR Inventory System</title>
  <base href="/">
   <link rel="icon" href="<?=base_url()?>assets/img/logos/logo.png"/>

  <link rel="stylesheet" href="<?=base_url()?>assets/css/styles.css" type="text/css">

  <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/standard.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/login.css">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">


  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

  <!-- Font Awesome JS -->
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


</head>
  <body>
     <section class="admin-login-page">
        <div class="admin-container admin-style">
          <div class="row admin-card-container ">
            <div class="card admin-card ">
              <div class="card-body">
                <div class="text-center">
                </div>
                <div class="text-center">
                  
                </div>
                <div class="login-form-title">Log In  </div>
                <div class="welcome-form-title text-center mt-3">
                  <span  style="color: red"><?php echo empty($error) ? '' : $error ?></span>
                  <h5></h5>
                  <h5></h5>
                  <h3 class="system-form-title"></h3>
                </div>
                <div class="login-form-container">
                  <div class="alert-container-content hidden"></div>
                  <form id="login-form">
                    <div class="form-group mt-3">
                      <input type="email" class="form-control standard-form-field username login-input" id="username" name="username" placeholder="EMAIL" style="width: 350px;">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control standard-form-field password login-input" id="password" name="password" placeholder="PASSWORD" style="width: 350px;">
                    </div>
                    <!-- <div class="text-center">
                      <label class="checkbox-inline"><input type="checkbox" class="remember_me" value="1" name="remember_me">Remember me</label>
                    </div> -->
                    <div class="text-center">
                     <!-- <a class="forgot-password">Forgot your password or username?</a> -->
                   </div>
                  <div class="alert alert-danger error-message d-none text-center mt-2 mb-0"></div>
                   <div class="form-group text-center mt-3">
                      <input type="submit" id="btn-login" class="btn btn-primary btn-login col-12" value="Log In" />
                    </div>
                    <div class="text-center mt-4">
                      New User? <a href="<?=base_url()?>signUp" >Sign Up</a>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </body>

<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>


<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script>
 $(document).ready(function() {

  $(document).on('click', '.forgot-password', function() {
      $('#forgot-password-modal').modal('show');
  });

  $(document).on('click', '.about-us', function() {
      $('#about-us-modal').modal('show');
  });
  
  $(document).on('click', '.btn-login', function () {
        var check = validateInput();
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        if(check) {
            loginUser();
        } else {
            $(this).prop('disabled', false).html('Login');
        }
    });

    $('.login-input').on('keyup', function (e) {
        if (e.keyCode == 13) {
            $('#btn-login').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            var check = validateInput();
            if(check) {
                loginUser();
            } else {
                $('#btn-login').prop('disabled', false).html('Login');
            }
        }
    });

    function validateInput() {
        $('.validate_error_message').remove();
        $('.required_input').removeClass('err_inputs');
        var check_user_name = $("#username");
        var check_password = $("#password");
        var error_message = "<span class='validate_error_message'>This field is required</span>";

        if (check_user_name.val() == "" ||  check_password.val() == "") {
            if (check_user_name.has("span") && $("span").hasClass("warning-note")) {
                
            } else {
                if(check_user_name.val() == '') {
                    $(check_user_name).addClass("err_inputs");
                    $(error_message).addClass("d-block warning-note").insertAfter($(check_user_name));
                }
                    
                if(check_password.val() == '') {
                    $(check_password).addClass("err_inputs");
                    $(error_message).addClass("d-block warning-note").insertAfter($(check_password));
                }          
            }
            return false;
        } else {
            $('.validate_error_message').remove();
            $(check_password).removeClass('err_inputs');
            $(check_user_name).removeClass('err_inputs');
            return true;    
        }
    }

    function loginUser() {
        $('.error-text-login').addClass('d-none').removeClass('d-block');
        var form = $('#login-form').serialize();
        $.ajax({
                url: '<?=base_url()?>ajax/login',
                type: 'POST',
                data: form,
            }).done(function (data) {
              var result = JSON.parse(data);
                if(result.success === true) {
                    window.location.replace(result.message);
                } else {
                    $('#password').val('');
                    $('.error-message').removeClass('d-none').addClass('d-block').html(result.message);
                    $('#btn-login').html('Login').prop('disabled', false);
                }
            });
    }
 });
  
</script>

</html>
