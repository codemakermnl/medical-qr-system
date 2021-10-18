<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GlobalController extends CI_Controller
{
    public function validateLogin()
    {
        $employee_id = (isset($_POST['username'])) ? $_POST['username'] : '';
        $password = (isset($_POST['password'])) ? $_POST['password'] : '';
        $login = $this->Global_model->get_data_with_query('users', '*', 'employee_id ="' .$employee_id. '" AND password="'.sha1($password).'"');

        // print("<pre>".print_r($this->input->post(),true)."</pre>");

        // die();

        if (count($login) > 0) {
            $user_info = $this->Global_model->get_data_with_query('users', '*', 'user_id ="' . $login[0]->user_id . '"');

            $this->session->set_userdata((array) ($user_info[0]));

            if( $user_info[0]->position_id == 1 || $user_info[0]->position_id == 2 ) {
                // echo json_encode(array('success' => true, 'message' => base_url().'admin-home'));
                echo json_encode(array('success' => true, 'message' => base_url().'home'));
            }else {

                echo json_encode(array('success' => false, 'message' => 'Unauthorized user.'));

                
            }

            // print("<pre>".print_r($user_account_info,true)."</pre>");
        } else {
            echo json_encode(array('success' => false, 'message' => 'Invalid employee Id or password'));
        }
    }

}
