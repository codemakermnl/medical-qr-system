<?php 
date_default_timezone_set('Asia/Taipei');

	class Custom_model extends CI_Model{

		public function get_all_users() { 
			$this->db->select("*");
			$this->db->from("users");
			$this->db->where("users.position_id = ", 3);
			$q = $this->db->get();
			return $q->result();
		}


		public function get_all_equipments($status, $designation) { 
			$this->db->select("equipments.*, designations.designation_name, equipment_type.equipment_type, status.status");
			$this->db->from("equipments");
			$this->db->join("equipment_type", "equipments.equipment_type_id = equipment_type.equipment_type_id");
			$this->db->join("designations", "equipments.designation_id = designations.designation_id");
			$this->db->join("status", "equipments.status_id = status.status_id");

			if( $status && $status != "-1" ) {
				$this->db->where("equipments.status_id", $status);
			}

			if( $designation && $designation != "-1" ) {
				$this->db->where("designations.designation_id", $designation);
			}

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


		// SELECT * FROM equipments 
		// JOIN equipment_type ON equipments.equipment_type_id = equipment_type.equipment_type_id
		// JOIN designations ON designations.designation_id = equipments.designation_id
		// LEFT JOIN equipment_borrow_logs 
		// ON equipments.equipment_id = equipment_borrow_logs.equipment_id

		// SELECT `equipments`.`model_number`, `equipment_type`.`equipment_type`, `designations`.`designation_name`, `equipment_borrow_logs`.`date_borrowed`, `equipment_borrow_logs`.`date_returned` FROM `equipments` JOIN `qr_codes` ON `qr_codes`.`equipment_id` = `equipments`.`equipment_id` JOIN `equipment_type` ON `equipments`.`equipment_type_id` = `equipment_type`.`equipment_type_id` JOIN `designations` ON `equipments`.`designation_id` = `designations`.`designation_id` LEFT JOIN `equipment_borrow_logs` ON `equipment_borrow_logs`.`equipment_id` = `equipments`.`equipment_id` WHERE `qr_codes`.`qr_code_path` LIKE 'rODZ3VAu2b9%' ORDER BY `equipment_borrow_logs`.`date_borrowed` DESC LIMIT 1

		public function get_equipment_by_hash($equipment_hash) {
			$this->db->select("equipments.equipment_id, equipments.model_number, equipment_type.equipment_type, designations.designation_name, equipments.status_id ");
			$this->db->from("equipments");
			$this->db->join("qr_codes", "qr_codes.equipment_id = equipments.equipment_id");
			$this->db->join("equipment_type", "equipments.equipment_type_id = equipment_type.equipment_type_id");
			$this->db->join("designations", "equipments.designation_id = designations.designation_id");
			$this->db->where("qr_codes.qr_code_path LIKE ", $equipment_hash . "%");
			$q = $this->db->get();
			return $q->result();
		}

		public function get_borrowed_equipment($equipment_id) {
			$this->db->select("equipments.equipment_id, designations.designation_name AS current_designation, equipment_borrow_logs.purpose, equipment_borrow_logs.date_borrowed, 
			CONCAT(users.first_name, ' ', users.last_name) AS borrowed_by ");
			$this->db->from("equipments");
			$this->db->join("equipment_borrow_logs", "equipments.equipment_id = equipment_borrow_logs.equipment_id");
			$this->db->join("designations", "equipment_borrow_logs.to_designation_id = designations.designation_id");
			$this->db->join("users", "equipment_borrow_logs.user_id = users.user_id");
			$this->db->where("equipments.equipment_id = ", $equipment_id);
			$this->db->where("equipment_borrow_logs.date_returned IS NULL");
			$q = $this->db->get();
			return $q->result();
		}

		public function return_equipment($table,$data, $equipment_id){
			$this->db->where('equipment_id', $equipment_id);
			$this->db->where('date_returned IS NULL');
			$this->db->update($table, $data);
			$updated_status = $this->db->affected_rows();
			if($updated_status):
			    return "success";
			else:
			    return "failed";
			endif;
		}

		public function get_borrows($select,$where) {
			$this->db->select($select);
			$this->db->from("equipment_borrow_logs");
			$this->db->where($where);
			$q = $this->db->get();
			return $q->result();
		}

		public function get_all_borrow_logs($status, $designation, $borrowed_by, $date_borrowed) {
			$this->db->select("equipments.equipment_id, equipments.model_number, equipment_type.equipment_type, designations.designation_name AS borrowed_designation, equipment_borrow_logs.purpose, equipment_borrow_logs.date_borrowed, IFNULL(equipment_borrow_logs.date_returned, 'N/A') AS date_returned, 
				CONCAT(users.first_name, ' ', users.last_name) AS borrowed_by");
			$this->db->from("equipments");
			$this->db->join("equipment_borrow_logs", "equipments.equipment_id = equipment_borrow_logs.equipment_id");
			$this->db->join("designations", "equipment_borrow_logs.to_designation_id = designations.designation_id");
			$this->db->join("equipment_type", "equipments.equipment_type_id = equipment_type.equipment_type_id");
			$this->db->join("users", "equipment_borrow_logs.user_id = users.user_id");

			if( $status && $status != "-1" ) {
				$this->db->where($status);
			}

			if( $designation && $designation != "-1" ) {
				$this->db->where("designations.designation_id", $designation);
			}

			if( $borrowed_by && $borrowed_by != "-1" ) {
				$this->db->where("users.user_id", $borrowed_by);
			}

			if( $date_borrowed && $date_borrowed != "-1" ) {
				$this->db->where("DATE(equipment_borrow_logs.date_borrowed) = DATE('$date_borrowed')");
			}

			$this->db->order_by("equipment_borrow_logs.equipment_borrow_log_id", "desc");
			$q = $this->db->get();
			return $q->result();
		}

		public function get_reports() {
			$this->db->select("equipments.equipment_id, equipments.model_number, equipment_type.equipment_type, reported_equipments.defect_description,
				CONCAT(users.first_name, ' ', users.last_name) AS reported_by, reported_equipments.date_reported ");
			$this->db->from("equipments");
			$this->db->join("reported_equipments", "equipments.equipment_id = reported_equipments.equipment_id");
			$this->db->join("equipment_type", "equipments.equipment_type_id = equipment_type.equipment_type_id");
			$this->db->join("users", "reported_equipments.reported_by = users.user_id");
			$this->db->order_by("reported_equipments.reported_equipment_id", "desc");
			$q = $this->db->get();
			return $q->result();
		}

		public function get_defective_logs($status) {
			$this->db->select("equipments.equipment_id, equipments.model_number, equipment_type.equipment_type, equipment_defective_logs.defect_description,
				equipment_defective_logs.defective_date, IFNULL(equipment_defective_logs.cause, 'N/A') AS cause, IFNULL(equipment_defective_logs.fix, 'N/A') AS fix, IFNULL(equipment_defective_logs.date_fixed, 'N/A') AS date_fixed ");
			$this->db->from("equipments");
			$this->db->join("equipment_defective_logs", "equipments.equipment_id = equipment_defective_logs.equipment_id");
			$this->db->join("equipment_type", "equipments.equipment_type_id = equipment_type.equipment_type_id");
			$this->db->order_by("equipment_defective_logs.equipment_defective_log_id", "desc");

			if( $status && $status != "-1" ) {
				$this->db->where($status);
			}

			$q = $this->db->get();
			return $q->result();
		}
	}