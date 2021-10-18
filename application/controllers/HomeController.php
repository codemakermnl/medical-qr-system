<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();

		$this->checkSession();
	}

	function checkSession() {

		// if($this->uri->segment(1)!='login'){
		// 	if ($this->session->userdata('user_id')=='') {
		// 		header('Location: '.base_url("login"));
		// 	}
		// } else {
		// 	if($this->session->userdata('user_id')!=''){
		// 		header('Location: '.base_url("home"));
		// 	}
		// }
	}

	public function index()
	{
		$this->load->view('pages/index');

	}

	public function login()
	{
		$this->load->view('pages/login');

	}

	public function signUp()
	{
		$this->load->view('pages/sign_up_page');
	}

	public function home()
	{
		$data['view'] =  "home";
		$data['head'] = array(
			"title"         =>  "Home | Medical Inventory System",
			);
		$this->load->view('layouts/template', $data);

		// print("<pre>".print_r($data['result'],true)."</pre>");
	}

	public function equipmentType()
	{
		$data['view'] =  "equipment_type";
		$data['head'] = array(
			"title"         =>  "Equipment Type | Medical Inventory System",
			);
		$this->load->view('layouts/template', $data);

		// print("<pre>".print_r($data['result'],true)."</pre>");
	}


	public function changePassword()
	{
		$data['view'] =  'change-password';
		$data['head'] = array(
			"title"         =>  "Change Password | Medical Inventory System",
			);
		$this->load->view('layouts/template', $data);
	}

	

	public function logout() {
		$this->session->sess_destroy();
		header('Location: '.base_url());
	}

	



}
