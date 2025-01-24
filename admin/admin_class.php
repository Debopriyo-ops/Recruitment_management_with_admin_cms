
<?php
session_start();
ini_set('display_errors', 1);

Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
	include 'fpdf/fpdf.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function login2(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		$data .= ", type = '$type' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = 3";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
			}
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	
	function save_recruitment_status(){
		extract($_POST);
		$data = " status_label = '$status_label' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO recruitment_status set ".$data);
		}else{
			$save = $this->db->query("UPDATE recruitment_status set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_recruitment_status(){
		extract($_POST);
		$delete = $this->db->query("UPDATE recruitment_status set status = 0 where id = ".$id);
		if($delete)
			return 1;
	}
	function save_vacancy(){
		extract($_POST);
		$data = " position = '$position' ";
		$data .= ", availability = '$availability' ";
		$data .= ", description = '".htmlentities(str_replace("'","&#x2019;",$description))."' ";
		if(isset($status))
		$data .= ", status = '$status' ";
		
		if(empty($id)){
			
			$save = $this->db->query("INSERT INTO vacancy set ".$data);
		}else{
			$save = $this->db->query("UPDATE vacancy set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_vacancy(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM vacancy where id = ".$id);
		if($delete)
			return 1;
	}
	function generate_acknowledgment_slip($application_id, $position_id) {
		require('fpdf.php');
	
		// Create instance of FPDF
		$pdf = new FPDF();
		$pdf->AddPage();
		
		// Set font
		$pdf->SetFont('Arial', 'B', 12);
		
		// Add a cell
		$pdf->Cell(0, 10, 'Acknowledgment Slip', 0, 1, 'C');
		
		// Add application ID and position ID
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(0, 10, 'Application ID: ' . $application_id, 0, 1);
		$pdf->Cell(0, 10, 'Position ID: ' . $position_id, 0, 1);
		
		// Add more details if needed
		// $pdf->Cell(0, 10, 'More details here', 0, 1);
		
		// Output PDF to download
		$pdf->Output('D', $application_id . '_acknowledgment.pdf');
	}
	function save_application() {
		// Extract variables from POST array
		$required_fields = [
			'name', 'gender', 'address', 'city', 'post_office', 'police_station', 'state', 
			'district', 'pincode', 'mobile', 'father_husband_name', 'aadhar_number', 'dob', 
			'degree', 'institution', 'year_of_passing', 'percentage', 'captcha', 'declaration'
		];
	
		$errors = [];
		
		foreach ($required_fields as $field) {
			if (empty($_POST[$field])) {
				$errors[] = "$field is required";
			}
		}
	
		if (!empty($errors)) {
			return json_encode(['status' => 0, 'errors' => $errors]);
		}
		
	
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$address = isset($_POST['address']) ? $_POST['address'] : '';
		$city = isset($_POST['city']) ? $_POST['city'] : '';
		$post_office = isset($_POST['post_office']) ? $_POST['post_office'] : '';
		$police_station = isset($_POST['police_station']) ? $_POST['police_station'] : '';
		$state = isset($_POST['state']) ? $_POST['state'] : '';
		$district = isset($_POST['district']) ? $_POST['district'] : '';
		$pincode = isset($_POST['pincode']) ? $_POST['pincode'] : '';
		$email = isset($_POST['email']) ? $_POST['email'] : '';
		$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
		$father_husband_name = isset($_POST['father_husband_name']) ? $_POST['father_husband_name'] : '';
		$aadhar_number = isset($_POST['aadhar_number']) ? $_POST['aadhar_number'] : '';
		$dob = isset($_POST['dob']) ? $_POST['dob'] : '';
		$qualification_details = isset($_POST['degree']) ? $_POST['degree'] : array(); // Assuming 'degree' is the name attribute of the degree input fields
        $captcha = isset($_POST['captcha']) ? $_POST['captcha'] : '';
        $declaration = isset($_POST['declaration']) ? $_POST['declaration'] : '';
		$status = isset($_POST['status']) ? $_POST['status'] : '0'; 
		$position_id = isset($_POST['position_id']) ? $_POST['position_id'] : '';



		// Prepare the SQL data string
		$data = "name = '$name'";
		$data .= ", gender = '$gender'";
		$data .= ", address = '$address'";
		$data .= ", city = '$city'";
		$data .= ", post_office = '$post_office'";
		$data .= ", police_station = '$police_station'";
		$data .= ", state = '$state'";
		$data .= ", district = '$district'";
		$data .= ", pincode = '$pincode'";
		$data .= ", mobile = '$mobile'";
		$data .= ", email = '$email'";
		$data .= ", father_husband_name = '$father_husband_name'";
		$data .= ", aadhar_number = '$aadhar_number'";
		$data .= ", dob = '$dob'";
		//$data .= ", qualification_details = '$qualification_details'";
        $data .= ", captcha = '$captcha'";
        $data .= ", declaration = '$declaration'";
		if(isset($status))
		$data .= ", process_id = '$status' ";
		$data .= ", position_id = '$position_id'";

		$qualification_data = array();
    if (!empty($qualification_details)) {
        foreach ($qualification_details as $key => $degree) {
            $institution = $_POST['institution'][$key];
            $year_of_passing = $_POST['year_of_passing'][$key];
            $percentage = $_POST['percentage'][$key];
            $qualification_data[] = "$degree - $institution - $year_of_passing - $percentage";
        }
    }
    $qualification_details_string = implode("; ", $qualification_data);
    $data .= ", qualification_details = '$qualification_details_string'";

	$experience_data = [];
    if (!empty($_POST['organization'])) {
        foreach ($_POST['organization'] as $key => $organization) {
            $from_date = $_POST['from_date'][$key];
            $to_date = $_POST['to_date'][$key];
            $nature_of_job = $_POST['nature_of_job'][$key];
            $platform_used = $_POST['platform_used'][$key];
            $experience_data[] = "$organization - $from_date - $to_date - $nature_of_job - $platform_used";
        }
    }
    $experience_details_string = implode("; ", $experience_data);
    $data .= ", experience_details = '$experience_details_string'";




		if ($_FILES['aadhar_card']['tmp_name'] != '') {
			$aadhar_fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['aadhar_card']['name'];
			$aadhar_move = move_uploaded_file($_FILES['aadhar_card']['tmp_name'], 'assets/aadhar_card/' . $aadhar_fname);
			$data .= ", aadhar_card_path = '$aadhar_fname' ";
		}

		if ($_FILES['photo']['tmp_name'] != '') {
			$photo_fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['photo']['name'];
			$photo_move = move_uploaded_file($_FILES['photo']['tmp_name'], 'assets/photo/' . $photo_fname);
			$data .= ", photo_path = '$photo_fname' ";
		}
		
		// Example handling for Signature file upload
		if ($_FILES['signature']['tmp_name'] != '') {
			$signature_fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['signature']['name'];
			$signature_move = move_uploaded_file($_FILES['signature']['tmp_name'], 'assets/signature/' . $signature_fname);
			$data .= ", signature_path = '$signature_fname' ";
		}
		
		// Example handling for Last Qualification file upload
		if ($_FILES['last_qualification']['tmp_name'] != '') {
			$qualification_fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['last_qualification']['name'];
			$qualification_move = move_uploaded_file($_FILES['last_qualification']['tmp_name'], 'assets/last_qualification/' . $qualification_fname);
			$data .= ", last_qualification_path = '$qualification_fname' ";
		}
		
		// Example handling for Work Experience file upload
		if ($_FILES['work_experience']['tmp_name'] != '') {
			$experience_fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['work_experience']['name'];
			$experience_move = move_uploaded_file($_FILES['work_experience']['tmp_name'], 'assets/work_experience/' . $experience_fname);
			$data .= ", work_experience_path = '$experience_fname' ";
		}



		$query = "INSERT INTO application SET $data";
		$save = $this->db->query($query);
	
		if ($save) {
			// Get the last inserted ID
			$last_id = $this->db->insert_id;
			echo $last_id; // Return the last inserted ID
		} else {
			// Log the error if needed
			error_log("Error: " . $this->db->error);
			echo "0"; // Return an error indicator
		}
	}
	
	
	
		
	
	function delete_application(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM application where id = ".$id);
		if($delete)
			return 1;
	}

	
}