<?php 
date_default_timezone_set('Asia/Taipei');

	class Custom_model extends CI_Model{

		public function get_all_users() { 
			$this->db->select("*");
			$this->db->from("users");
			$this->db->where("users.position_id = ", 2);
			$q = $this->db->get();
			return $q->result();
		}

		

	}