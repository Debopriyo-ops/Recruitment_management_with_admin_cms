<?php 
include 'db_connect.php';
$application = $conn->query("SELECT  a.*,v.position FROM application a inner join vacancy v on v.id = a.position_id where a.id=".$_GET['id'])->fetch_array();
foreach($application as $k => $v){
	$$k = $v;
}
$aadhar_fname = explode('_', $aadhar_card_path);
unset($aadhar_fname[0]);
$aadhar_fname = implode("", $aadhar_fname);

$photo_fname = explode('_', $photo_path);
unset($photo_fname[0]);
$photo_fname = implode("", $photo_fname);

$signature_fname = explode('_', $signature_path);
unset($signature_fname[0]);
$signature_fname = implode("", $signature_fname);


$qualification_fname = explode('_', $last_qualification_path);
unset($qualification_fname[0]);
$qualification_fname = implode("", $qualification_fname);

$experience_fname = explode('_', $work_experience_path);
unset($experience_fname[0]);
$experience_fname = implode("", $experience_fname);


?>
<div class="container-fluid">
	<div class="col-md-12">
		<p><b>Applied for :</b><?php echo $position ?></p>
		<p><b>Applicant's Name :</b><?php echo $name?></p>
		<p><b>Gender :</b><?php echo $gender ?></p>
		<p><b>Address :</b><?php echo $address ?></p>
		<p><b>City :</b><?php echo $city ?></p>
		<p><b>Post Office :</b><?php echo $post_office ?></p>
		<p><b>Police Station :</b><?php echo $police_station ?></p>
		<p><b>State :</b><?php echo $state ?></p>
		<p><b>District :</b><?php echo $district ?></p>
		<p><b>Pincode :</b><?php echo $pincode ?></p>
		<p><b>Mobile :</b><?php echo $mobile ?></p>
		<p><b>Father/Husband's Name: :</b><?php echo $father_husband_name ?></p>
		<p><b>Aadhar Number :</b><?php echo $aadhar_number ?></p>
		<p><b>Aadhar_card</p>
			<a href="download.php?file_type=aadhar_card_path&id=<?php echo $_GET['id'] ?>" target="_blank"><?php echo $aadhar_fname ?></a>

			<p><b>Photo</p>
			<a href="download.php?file_type=photo_path&id=<?php echo $_GET['id'] ?>" target="_blank"><?php echo $photo_fname ?></a>

			<p><b>Signature</p>
			<a href="download.php?file_type=signature_path&id=<?php echo $_GET['id'] ?>" target="_blank"><?php echo $signature_fname ?></a>

		<p><b>Date of Birth: :</b><?php echo $dob ?></p>
		<p><b>Qualification Details: :</b><?php echo $qualification_details ?></p>
		<p><b>Experience Details:</b> <?php echo $experience_details; ?></p>

		<p><b>Work Experience</p>
			<a href="download.php?file_type=work_experience_path&id=<?php echo $_GET['id'] ?>" target="_blank"><?php echo $qualification_fname ?></a>

			<p><b>Last Qualification</p>
			<a href="download.php?file_type=last_qualification_path&id=<?php echo $_GET['id'] ?>" target="_blank"><?php echo $experience_fname ?></a>


	

		


		

		

	</div>
</div>