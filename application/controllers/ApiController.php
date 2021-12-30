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
        $email = (isset($_POST['email'])) ? $_POST['email'] : '';
        $password = (isset($_POST['password'])) ? $_POST['password'] : '';
        $login = $this->Global_model->get_data_with_query('users', '*', 'email ="' .$email. '" AND password="'. $password.'" AND position_id = 3');

        // echo $this->db->last_query();

        if (count($login) > 0) {
            echo json_encode(array('success' => true, 'has_info' => true, 'user_id' => $login[0]->user_id));
        }else {
            echo json_encode(array('success' => false, 'has_info' => false));
        }
    
    }


    public function employeeSignUp() {
        $table = "users";
        $success = true;
        $errors = "";
        $email = $this->input->post('email');
        $login = $this->Global_model->get_data_with_query('users', '*', 'email ="' .$email . '" AND position_id = 3');

        if (count($login) > 0) {
            $errors = "Email already exists.";
            $success = false;
        }else {
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'), 
                'email' => $email, 
                'address' =>  "", 
                'password' => $this->input->post('password'),
                'position_id' => 3
            );
            $response = $this->Global_model->insert_data($table, $data);

            if($response === "failed") {
                $errors = "Add Employee Failed";
                $success = false;
            }
        }


        echo json_encode(array('success' => $success, 'errors' => $errors));
    }

    public function getEquipment() {
        $equipmentHash = $this->input->get('qrCodeString');
        $result = $this->Custom_model->get_equipment_by_hash($equipmentHash);
        // echo $this->db->last_query();
        print_r(json_encode($result));
    }

    public function getBorrowedEquipment() {
        $equipmentId = $this->input->get('equipmentId');
        $result = $this->Custom_model->get_borrowed_equipment($equipmentId);
        // echo $this->db->last_query();
        print_r(json_encode($result));
    }

    public function borrowEquipment() {
        // print("<pre>".print_r($this->input->post(),true)."</pre>");
        $to_designation = $this->input->post('to_designation');
        $equipment_id = $this->input->post('equipment_id');
        $user_id = $this->input->post('user_id');
        $purpose = $this->input->post('purpose');
        $success = true;
        $errors = "";

        // echo 'purpose: ' . $purpose . '<br>';

        $designation = $this->Global_model->get_data_with_query("designations", "*", "designation_name = '" . $to_designation . "'" );;

        $data = array(
            'status_id' => 2
        );

        $field = 'equipment_id';
        $where = $equipment_id;
        $response = $this->Global_model->update_data('equipments', $data, $field, $where);

        
        $data = array(
            'equipment_id' => $equipment_id,
            'to_designation_id' => $designation[0]->designation_id,
            'user_id' => $user_id,
            'purpose' => $purpose
        );
        $response = $this->Global_model->insert_data("equipment_borrow_logs", $data);

        if($response === "failed") {
            $errors = "Borrow Equipment Failed";
            $success = false;
        }



        print_r(json_encode($response));

    }

    public function returnEquipment() {
        // print("<pre>".print_r($this->input->post(),true)."</pre>");
        $equipment_id = $this->input->post('equipment_id');
        $user_id = $this->input->post('user_id');
        $success = true;
        $errors = "";

        $data = array(
            'status_id' => 1
        );

        $field = 'equipment_id';
        $where = $equipment_id;
        $response = $this->Global_model->update_data('equipments', $data, $field, $where);

        if($response === "failed") {
            $errors = "Return Equipment Update Equipment Failed";
            $success = false;
        }
        
        $data = array(
            'date_returned' => date('Y-m-d H:i:s')
        );

        $where = $equipment_id;
        $response = $this->Custom_model->return_equipment('equipment_borrow_logs',$data, $equipment_id);

        if($response === "failed") {
            $errors = "Return Equipment Return Equipment Failed";
            $success = false;
        }

        print_r(json_encode(array('success' => $success)));

    }

    public function reportEquipment() {
        // print("<pre>".print_r($this->input->post(),true)."</pre>");
        $equipment_id = $this->input->post('equipment_id');
        $user_id = $this->input->post('user_id');
        $defect_description = $this->input->post('defect_description');
        $success = true;
        $errors = "";

        // $data = array(
        //     'status_id' => 3
        // );

        // $field = 'equipment_id';
        // $where = $equipment_id;
        // $response = $this->Global_model->update_data('equipments', $data, $field, $where);

        // if($response === "failed") {
        //     $errors = "Return Equipment Update Equipment Failed";
        //     $success = false;
        // }
        
         $data = array(
            'equipment_id' => $equipment_id,
            'reported_by' => $user_id,
            'defect_description' => $defect_description
        );
        $response = $this->Global_model->insert_data("reported_equipments", $data);


        if($response === "failed") {
            $errors = "Report Equipment Report Equipment Failed";
            $success = false;
        }

        print_r(json_encode(array('success' => $success)));

    }

    

}
?>