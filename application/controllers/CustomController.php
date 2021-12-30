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

    public function getBorrowLogs() {
        $status = $this->input->get('status');

        if( $status ) {
            if( $status == "-1" ) {
                $status_filter = "-1";
            }else {
                $status_filter = $status == 'Returned' ?  "date_returned IS NOT NULL" : "date_returned IS NULL";
            }
        }else {
            $status_filter = "";
        }
        
        // echo 'status: ' . $this->input->get('status') . '<br>';
        $designation = $this->input->get('designation');
        $borrowed_by = $this->input->get('borrowed_by');
        $date_borrowed = $this->input->get('date_borrowed');

        // echo 'designation: ' . $designation . '<br>borrowed by: ' . $borrowed_by . '<br>';

        $result = $this->Custom_model->get_all_borrow_logs($status_filter, $designation, $borrowed_by, $date_borrowed);

        // echo $this->db->last_query();

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
        $status = $this->input->get('status');
        $designation = $this->input->get('designation');

        $result = $this->Custom_model->get_all_equipments($status, $designation);
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

    public function setEquipmentAsDefective() {
        $table = 'equipments';

        $data = array(
            'status_id' => 3
        );

        $field = 'equipment_id';
        $where = $this->input->post('equipment_id');
        $response = $this->Global_model->update_data($table, $data, $field, $where);

        if($response === "failed") {
            $data = array(
                'server_errors' => "Data update to database Failed. Please contact your system administrator."
            );

            print("<pre>".print_r($response,true)."</pre>");

            //redirect("make-report");
        }

        $table = 'equipment_defective_logs';
        $data = array(
            'defect_description' => $this->input->post('defect_description'),
            'equipment_id' => $this->input->post('equipment_id')
        );
        $response = $this->Global_model->insert_data($table, $data);

        return $response;
    }

    public function setEquipmentAsFixed() {
        $table = 'equipments';

        $data = array(
            'status_id' => 1
        );

        $field = 'equipment_id';
        $where = $this->input->post('equipment_id');
        $equipment_id = $this->input->post('equipment_id');
        $response = $this->Global_model->update_data($table, $data, $field, $where);

        if($response === "failed") {
            $data = array(
                'server_errors' => "Data update to database Failed. Please contact your system administrator."
            );

            print("<pre>".print_r($response,true)."</pre>");

            //redirect("make-report");
        }
        print("<pre>".print_r($this->input->post(),true)."</pre>");
        $cause = $this->input->post('cause');
        $fix = $this->input->post('fix');
        $date_fixed = date('Y-m-d H:i:s');

        $query = $this->db->query("UPDATE equipment_defective_logs SET cause = '$cause', fix = '$fix', date_fixed = '$date_fixed' WHERE date_fixed IS NULL AND equipment_id = $equipment_id");

        // echo $this->db->last_query();

        return $query;
    }

    public function register() {
        print("<pre>".print_r($this->input->post(),true)."</pre>");
        // TODO check if existing + form validation + form validation for password/confirm + email uniqueness

        $table = 'users';
        $email = $this->input->post('email');
        $data = array(
            'first_name' => $this->input->post('fname'),
            'last_name' => $this->input->post('lname'), 
            'email' => $this->input->post('email'), 
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


    public function getWeeklyBorrows() {
        $current_date = new DateTime(date('Y-m-d H:i:s'));
        $dayOfWeek = date('w', strtotime(  $current_date->format('Y-m-d H:i:s') ) );
        $current_day_of_week = $dayOfWeek;
        $ctr = $current_day_of_week+1;
        $weekly_earnings = [];

        $day_of_week = $current_date->format("W"); 
        $dateTime = new DateTime();
        $dateTime->setISODate($current_date->format('Y'), $day_of_week);
        $start_date = $dateTime->format('Y-m-d');
        $dateTime->modify('+7 days');
        $end_date = $dateTime->format('Y-m-d');

        // echo 'start date: ' . $start_date . ', <br>end date: ' . $end_date . '<br>';

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod(new DateTime($start_date), $interval, new DateTime($end_date));


        foreach ($period as $dt) {
            array_push( $weekly_earnings, $this->Custom_model->get_borrows("COUNT(*) as total", "DATE(equipment_borrow_logs.date_borrowed) = DATE('" .  $dt->format('Y-m-d') . "')" ) );
        }


       // $result = $this->Custom_model->get_weekly_sales();
       print_r(json_encode($weekly_earnings));
    }

    public function getMonthlyBorrows() {
        $monthly_earnings = [];

        $dateTime = new DateTime( date('Y') . '-01-01');
        $start_date = $dateTime->format('Y-m-d');
        $dateTime->modify('+12 months');
        $end_date = $dateTime->format('Y-m-d');

        // echo 'start date: ' . $start_date . ', <br>end date: ' . $end_date . '<br>';

        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod(new DateTime($start_date), $interval, new DateTime($end_date));


        foreach ($period as $dt) {
            // echo $dt->format('Y-m-d') . '<br>';
            array_push( $monthly_earnings, $this->Custom_model->get_borrows("COUNT(*) as total", 
                "MONTH(DATE(equipment_borrow_logs.date_borrowed)) = MONTH(DATE('" .  $dt->format('Y-m-d') . "'))" ) );
        }


       // $result = $this->Custom_model->get_weekly_sales();
       print_r(json_encode($monthly_earnings));
    }

    public function getYearlyBorrows() {
        $yearly_earnings = [];

        $dateTime = new DateTime( date('Y') . '-01-01');
        $dateTime->modify('+1 year');
        $start_date = $dateTime->format('Y-m-d');
        $dateTime->modify('-11 years');
        $end_date = $dateTime->format('Y-m-d');

        $interval = DateInterval::createFromDateString('1 year');
        $period = new DatePeriod(new DateTime($end_date), $interval, new DateTime($start_date));

        foreach ($period as $dt) {
            // echo $dt->format('Y-m-d') . '<br>';

            array_push( $yearly_earnings, $this->Custom_model->get_borrows("YEAR(DATE('" .  $dt->format('Y-m-d') . "')) AS year, " . "COUNT(*) as total", 
                "YEAR(DATE(equipment_borrow_logs.date_borrowed)) = YEAR(DATE('" .  $dt->format('Y-m-d') . "')) " ));
        }


       // $result = $this->Custom_model->get_weekly_sales();
       print_r(json_encode($yearly_earnings));
    }

    
    public function getTotals() {

        $total_equipments = $this->Global_model->get_all_data("equipments", "COUNT(*) AS total" );

        $total_borrows = $this->Global_model->get_data_with_query("equipment_borrow_logs", "COUNT(*) AS total", "DATE(equipment_borrow_logs.date_borrowed) = DATE(NOW())" );

        $total_returns = $this->Global_model->get_data_with_query("equipment_borrow_logs", "COUNT(*) AS total", "DATE(equipment_borrow_logs.date_returned) = DATE(NOW()) AND equipment_borrow_logs.date_returned IS NOT NULL" );

        print_r(json_encode(array( 'total_equipments' => $total_equipments[0]->total, 'total_borrows' => $total_borrows[0]->total,
                              'total_returns' => $total_returns[0]->total ) ) );
    }

    public function getReports() {
        $result = $this->Custom_model->get_reports();
        print_r(json_encode($result));
    }

    public function getDefectiveLogs() {
        $status = $this->input->get('status');

        if( $status ) {
            if( $status == "-1" ) {
                $status_filter = "-1";
            }else {
                $status_filter = $status == 'Fixed' ?  "date_fixed IS NOT NULL" : "date_fixed IS NULL";
            }
        }else {
            $status_filter = "";
        }

        $result = $this->Custom_model->get_defective_logs($status_filter);
        print_r(json_encode($result));
    }
   
}
