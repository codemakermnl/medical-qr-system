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


		public function get_all_equipments() { 
			$this->db->select("equipments.*, designations.designation_name, equipment_type.equipment_type");
			$this->db->from("equipments");
			$this->db->join("equipment_type", "equipments.equipment_type_id = equipment_type.equipment_type_id");
			$this->db->join("designations", "designations.designation_id = designations.designation_id");
			$q = $this->db->get();
			return $q->result();
		}

		
		public function get_equipment($equipment_id) {
			$this->db->select("*");
			$this->db->from("equipments");
			$this->db->join("equipment_type", "equipments.equipment_type_id = equipment_type.equipment_type_id");
			$this->db->join("designations", "equipments.designation_id = designations.designation_id");
			$this->db->where("equipments.equipment_id = ", $equipment_id);
			$q = $this->db->get();
			return $q->result();
		}

		public function get_equipment_details($equipment_id) {
			$this->db->select("qr_codes.qr_code_path");
			$this->db->from("equipments");
			$this->db->join("equipment_type", "equipments.equipment_type_id = equipment_type.equipment_type_id");
			$this->db->join("designations", "equipments.designation_id = designations.designation_id");
			$this->db->join("qr_codes", "qr_codes.equipment_id = equipments.equipment_id");
			$this->db->where("equipments.equipment_id = ", $equipment_id);
			$q = $this->db->get();
			return $q->result();
		}
	}