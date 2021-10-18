<?php

class ApiController extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	// index.php/ThirdPartyController/index
	function index() {
      

		
	}

	function getUserData() {
		$email_hash = $this->input->get('qrCodeString');
		$result = $this->Global_model->get_data_with_where_query("accounts", "*", "accounts.email_hash" , $email_hash);
        print_r(json_encode($result));
	}

    public function validateEmployeeLogin() {
        $employee_id = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : '';
        $password = (isset($_POST['password'])) ? $_POST['password'] : '';
        $login = $this->Global_model->get_data_with_query('users', '*', 'employee_id ="' .$employee_id. '" AND password="'. $password.'" AND position_id = 3');

        if (count($login) > 0) {
            echo json_encode(array('success' => true, 'has_info' => false));
        }else {
            echo json_encode(array('success' => true, 'has_info' => false));
        }
    
    }


    public function employeeSignUp() {
        $table = "users";
        $success = true;
        $errors = "";
        $data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'), 
            'employee_id' => $this->input->post('employee_id'), 
            'address' =>  "", 
            'password' => sha1($this->input->post('password')),
            'position_id' => 3
        );
        $response = $this->Global_model->insert_data($table, $data);

        if($response === "failed") {
            $errors = "Add Employee Failed";
            $success = false;
        }

        echo json_encode(array('success' => $success, 'errors' => $errors));
    }

}
?>