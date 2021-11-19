<?php
require_once(APPPATH.'third_party/QRCodeGenerator.php');

class CustomController extends CI_Controller
{

    function __construct ()
    {   
      parent::__construct();
      // $this->load->library('phpqrcode/qrlib');
      $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }


    public function getEquipmentTypes() {
        
        $result = $this->Global_model->get_all_data("equipment_type", "*");
        print_r(json_encode($result));
    
    }

    public function getEquipmentType() {
        $equipment_id = $this->input->get('equipment_type_id');
        $result = $this->Global_model->get_data_with_query("equipment_type", "*", "equipment_type_id = " . $equipment_id );
        print_r(json_encode($result));
    }

    public function getDesignations() {
        
        $result = $this->Global_model->get_all_data("designations", "*");
        print_r(json_encode($result));
    
    }

    public function getDesignation() {
        $designation_id = $this->input->get('designation_id');
        $result = $this->Global_model->get_data_with_query("designations", "*", "designation_id = " . $designation_id );
        print_r(json_encode($result));
    }

    public function getEquipments() {
        $result = $this->Custom_model->get_all_equipments();
        print_r(json_encode($result));
    
    }

    public function getEquipmentDetails() {
        $result = $this->Custom_model->get_equipment_details($this->input->get('equipment_id'));
        // echo $this->db->last_query();
        print_r(json_encode($result));
    }

    public function getEquipment() {
        $equipment_id = $this->input->get('equipment_id');
        $result = $this->Custom_model->get_equipment($equipment_id);
        print_r(json_encode($result));
    }

    public function addEquipmentType() {
        $table = 'equipment_type';
        $data = array(
            'equipment_type' => $this->input->post('equipment_type'),
            'description' => $this->input->post('description'), 
            'quantity' => 1
        );
        $response = $this->Global_model->insert_data($table, $data);
        print_r(json_encode($response));

    }

    public function addEquipment() {
        $table = 'equipments';
        $data = array(
            'equipment_type_id' => $this->input->post('equipment_type_id'),
            'designation_id' => $this->input->post('designation_id'), 
            'model_number' => $this->input->post('model_number')
        );
        $response = $this->Global_model->insert_data($table, $data);
        $equipment_id = $response;


        $qrcodeGenerator = new QRCodeGenerator();
        $length = 11;
        $hash = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!?&^', ceil($length / strlen($x)))), 1, $length);
        $generated_filename = $qrcodeGenerator->generate( $hash );
        if( !$generated_filename ) {
            $data = array(
                'server_errors' => "QR code generation Failed. Please contact your system administrator."
            );
        }

        $table = 'qr_codes';

        $data = array(
            'equipment_id' => $equipment_id,
            'qr_code_path' =>  $generated_filename, 
        );
        $response = $this->Global_model->insert_data($table, $data);

        if($response === "failed") {
            $data = array(
                'server_errors' => "Data insertion to database Failed. Please contact your system administrator."
            );
        }

        print_r(json_encode($response));

    }

    public function addDesignation() {
        $table = 'designations';
        $data = array(
            'designation_name' => $this->input->post('designation_name')
        );
        $response = $this->Global_model->insert_data($table, $data);
        print_r(json_encode($response));
    }

    public function updateEquipment() {
        $table = 'equipments';

        $data = array(
            'equipment_type_id' => $this->input->post('equipment_type_id'),
            'designation_id' => $this->input->post('designation_id'), 
            'model_number' => $this->input->post('model_number')
        );

        $field = 'equipment_id';
        $where = $this->input->post('equipment_id');
        $response = $this->Global_model->update_data($table, $data, $field, $where);
        return $response;
    }

    public function updateEquipmentType() {
        $table = 'equipment_type';

        $data = array(
            'equipment_type' => $this->input->post('equipment_type'),
            'description' => $this->input->post('description'), 
            'quantity' => 1
        );

        $field = 'equipment_type_id';
        $where = $this->input->post('equipment_type_id');
        $response = $this->Global_model->update_data($table, $data, $field, $where);
        return $response;
        return $response;
    }

    public function updateDesignation() {
         $table = 'designations';
        $data = array(
            'designation_name' => $this->input->post('designation_name')
        );

        $field = 'designation_id';
        $where = $this->input->post('designation_id');
        $response = $this->Global_model->update_data($table, $data, $field, $where);
        return $response;
    }

    public function register() {
        print("<pre>".print_r($this->input->post(),true)."</pre>");
        // TODO check if existing + form validation + form validation for password/confirm + email uniqueness

        $table = 'users';
        $email = $this->input->post('email');
        $data = array(
            'first_name' => $this->input->post('fname'),
            'last_name' => $this->input->post('lname'), 
            'employee_id' => $this->input->post('employee_id'), 
            'address' =>  $this->input->post('complete_address'), 
            'password' => sha1($this->input->post('password')),
            'position_id' => $this->input->post('role')
        );
        $response = $this->Global_model->insert_data($table, $data);

        if($response === "failed") {
            $data = array(
                'server_errors' => "Data insertion to database Failed. Please contact your system administrator."
            );

            print("<pre>".print_r($data,true)."</pre>");
            print("<pre>".print_r($response,true)."</pre>");

            //redirect("make-report");
        }

    
        

        //     print("<pre>".print_r($data,true)."</pre>");
        //     print("<pre>".print_r($response,true)."</pre>");

        //     //redirect("make-report");
        // }

        redirect("login"); 

    }

    private function padCodes( $code ) {
        while( strlen($code) < 9 ) {
            $code .= '0';
        }
        return $code;
    }

    public function getAllUsers()
    {
        $result = $this->Custom_model->get_all_users();
        print_r(json_encode($result));
    }


    public function getAllAccounts() {
        $result = $this->Custom_model->get_all_accounts();
        print_r(json_encode($result));
    }


     public function deleteUser() {
        $table = "accounts";
        $field = "user_id";
        $where = $this->input->post("user_id");
        $result = $this->Global_model->delete_data($table, $field, $where);

        $table = "users";
        $field = "user_id";
        $where = $this->input->post("user_id");
        $result = $this->Global_model->delete_data($table, $field, $where);

        print_r(json_encode($result));
    }
   

    public function validatePassword()
    {
        $password = $_POST['password'];
        $isExist = $this->Global_model->get_data_with_query('users', 'id', 'password ="' . sha1($password) . '" AND username = "' . $this->session->userdata('username') . '"');
        if (count($isExist) > 0) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        echo json_encode(array('status' => $status));
    }

    public function getNewPassword()
    {
        $length = 6;
        $data['password'] = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);

        print_r(json_encode($data));
    }

    public function addAccount()
    {
        $table = 'users';
        $data = array(
            'username' => $this->input->post('username'),
            'password' => sha1($this->input->post('password')),
            'position_id' => $this->input->post('position'),
            'college_id' => $this->input->post('college')
        );
        $response = $this->Global_model->insert_data($table, $data);
        print_r(json_encode($response));
    }


    public function updatePassword()
    {
        $user_id = $this->session->userdata('user_id');
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $confirm_new_password = $this->input->post('confirm_new_password');
        $user = $this->Global_model->get_data_with_query('users', 'password', 'user_id =' . $user_id);
        if ($new_password == $confirm_new_password) {
            if (sha1($current_password) == $user[0]->password) {
                $table = 'users';
                $data = array('password' => sha1($confirm_new_password));
                $field = 'user_id';
                $where = $user_id;
                $response = $this->Global_model->update_data($table, $data, $field, $where);
                $result['message'] = "Password Successfully Changed";
                $result['status'] = "success";
            } else {
                $result['message'] = "Invalid Password";
                $result['status'] = "error";
            }

        } else {
            $result['message'] = "New password and confirm password does not match";
            $result['status'] = "error";
        }

        print_r(json_encode($result));
    }


    public function deleteDesignation() {
        $table = "designations";
        $field = "designation_id";
        $where = $this->input->post("designation_id");
        $result = $this->Global_model->delete_data($table, $field, $where);
        print_r(json_encode($result));
    }

    public function deleteEquipmentType() {
        $table = "equipment_type";
        $field = "equipment_type_id";
        $where = $this->input->post("equipment_type_id");
        $result = $this->Global_model->delete_data($table, $field, $where);
        print_r(json_encode($result));
    }

    public function deleteEquipment() {
        $table = "equipments";
        $field = "equipment_id";
        $where = $this->input->post("equipment_id");
        $result = $this->Global_model->delete_data($table, $field, $where);
        print_r(json_encode($result));
    }

  


   
}
