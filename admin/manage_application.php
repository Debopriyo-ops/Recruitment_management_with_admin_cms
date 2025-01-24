<?php include 'db_connect.php' ?>



<?php
	if(isset($_GET['id'])){
		$application = $conn->query("SELECT  a.*,v.position FROM application a inner join vacancy v on v.id = a.position_id where a.id=".$_GET['id'])->fetch_array();
       // $qualification_details_string = $application['qualification_details'];
        //$qualification_details = explode("; ", $qualification_details_string);
        
        foreach($application as $k => $v){
			$$k = $v;
		}

        

        
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

	
	$qry = $conn->query("SELECT * FROM vacancy ");
	while($row=$qry->fetch_assoc()){
		$pos[$row['id']] = $row['position'];
	}
	$rs = $conn->query("SELECT * FROM recruitment_status ");
	while($row=$rs->fetch_assoc()){
		$stat[$row['id']] = $row['status_label'];
	}


?>
<style>
	/* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7f8; /* Light background color */
    margin: 0;
    padding: 20px;
}

/* Card Style */
.form-card {
    border: 1px solid #ddd; /* Light gray border */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    padding: 20px; /* Padding inside the card */
    background-color: #fff; /* White background */
    margin-top: 20px; /* Margin at the top */
    box-sizing: border-box; /* Ensure padding and border are included in total width/height */
}

/* Form Elements */
.form-card .form-control,
.form-card .custom-select,
.form-card .custom-file-input {
    border-radius: 4px; /* Rounded corners for inputs */
}

.form-card .custom-file-label {
    border-radius: 4px; /* Rounded corners for file input labels */
}

.form-card .input-group-text {
    background-color: #f8f9fa; /* Light background for input groups */
    border: 1px solid #ddd; /* Light gray border for input groups */
    border-radius: 4px 0 0 4px; /* Rounded corners for input group prepend */
}

.form-card .input-group {
    border-radius: 4px; /* Rounded corners for input groups */
}

.form-card label {
    font-weight: bold; /* Make labels bold */
    margin-bottom: 5px; /* Space below labels */
}

.form-card .row {
    margin-bottom: 15px; /* Space between rows */
}
</style>






<div class="container-fluid">
    <form id="update_application_status" method="POST", action = "update_status.php">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
        <div class="col-md-12">
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="" class="control-label">Position</label>
                    <select class="custom-select browser-default select2" name="position_id">
                        <option value=""></option>
                        <?php foreach($pos as $k => $v): ?>
                            <option value="<?php echo $k ?>" <?php echo isset($position_id) && $position_id == $k ? "selected" : ''; ?>><?php echo $v ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-4">
                    <label for="" class="control-label">Applicant's Name</label>
                    <input type="text" class="form-control" name="name" required="" value="<?php echo isset($name) ? $name : '' ?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-4">
                    <label for="" class="control-label">Gender</label>
                    <select name="gender" id="" class="custom-select browser-default">
                        <option <?php echo isset($gender) && $gender == 'Male' ? "selected" : '' ?>>Male</option>
                        <option <?php echo isset($gender) && $gender == 'Female' ? "selected" : '' ?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-10">
                    <label for="" class="control-label">Address</label>
                    <textarea name="address" id="" cols="30" rows="3" required class="form-control"><?php echo isset($address) ? $address : '' ?></textarea>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-10">
                    <label for="" class="control-label">City/Town/Village:</label>
                    <input type="text" class="form-control" name="city/town/village" required="" value="<?php echo isset($city) ? $city : '' ?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-10">
                    <label for="" class="control-label">Post Office:</label>
                    <input type="text" class="form-control" name="post_office" required="" value="<?php echo isset($post_office) ? $post_office : '' ?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-10">
                    <label for="" class="control-label">Police Station:</label>
                    <input type="text" class="form-control" name="police_station" required="" value="<?php echo isset($police_station) ? $police_station : '' ?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-10">
                    <label for="" class="control-label">State:</label>
                    <input type="text" class="form-control" name="state" required="" value="<?php echo isset($state) ? $state : '' ?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-10">
                    <label for="" class="control-label">District:</label>
                    <input type="text" class="form-control" name="district" required="" value="<?php echo isset($district) ? $district : '' ?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-10">
                    <label for="" class="control-label">Pincode:</label>
                    <input type="text" class="form-control" name="pincode" required="" value="<?php echo isset($pincode) ? $pincode : '' ?>">
                </div>
            </div>
            <div class="row form-group">
            <div class="col-md-10">
            <label for="email" class="control-label">Email:</label>
            <input type="email" class="form-control" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
            </div>
            </div>
            <div class="row form-group">
                <div class="col-md-10">
                    <label for="" class="control-label">Mobile:</label>
                    <input type="text" class="form-control" name="mobile" required="" value="<?php echo isset($mobile) ? $mobile : '' ?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-10">
                    <label for="" class="control-label">Father/Husband's Name:</label>
                    <input type="text" class="form-control" name="father_husband_name" required="" value="<?php echo isset($father_husband_name) ? $father_husband_name : '' ?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-10">
                    <label for="" class="control-label">Aadhar Number:</label>
                    <input type="text" class="form-control" name="aadhar_number" required="" value="<?php echo isset($aadhar_number) ? $aadhar_number : '' ?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-10">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="aadhar_card" onchange="displayfname(this,$(this))" name="aadhar_card" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="aadhar_card"><?php echo isset($aadhar_fname) ? $aadhar_fname : 'Aadhar Card Upload' ?></label>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="input-group col-md-4 mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">Photo</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="photo" onchange="displayfname(this,$(this))" name="photo" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="photo"><?php echo isset($photo_fname) ? $photo_fname : '' ?></label>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="input-group col-md-4 mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">Signature</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="signature" onchange="displayfname(this,$(this))" name="signature" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="signature"><?php echo isset($signature_fname) ? $signature_fname : '' ?></label>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-10">
                    <label for="dob">Date of Birth (yyyy-MM-dd):</label>
                    <input type="text" class="form-control" name="dob" pattern="\d{4}-\d{2}-\d{2}" title="Enter a date in the format yyyy-MM-dd" required="" value="<?php echo isset($dob) ? $dob : '' ?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-10">
                    <p><b>Qualification Details: </b><?php echo isset($qualification_details) ? $qualification_details : '' ?></p>
                </div>
            </div>

            <div class="row form-group">
            <div class="col-md-10">
            <p><b>Work Experience Details: </b>
             <?php 
           if (isset($experience_details)) {
            $experience_entries = explode("; ", $experience_details);
            foreach ($experience_entries as $experience) {
                echo "<p>$experience</p>";
            }
            }
            ?>
             </p>
            </div>
            </div>
            <div class="row form-group">
                <div class="input-group col-md-4 mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">Work Experience</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="work_experience" onchange="displayfname(this,$(this))" name="work_experience" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="work_experience"><?php echo isset($experience_fname) ? $experience_fname : '' ?></label>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="input-group col-md-4 mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">Last Qualification</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="last_qualification" onchange="displayfname(this,$(this))" name="last_qualification" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="last_qualification"><?php echo isset($qualification_fname) ? $qualification_fname : '' ?></label>
                    </div>
                </div>
            </div>
            <?php if(isset($id)): ?>
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="" class="control-label">Status</label>
                    <select class="custom-select browser-default select2" name="status">
                        <option value="0" <?php echo isset($process_id) && $process_id == 0 ? "selected" : '' ?>>New</option>
                        <?php foreach($stat as $k => $v): ?>
                            <option value="<?php echo $k ?>" <?php echo isset($process_id) && $process_id == $k ? "selected" : '' ?>><?php echo $v ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>
        </div>	
    </form>
</div>



<script>
	function displayfname(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	console.log(input.files[0].name)
        	_this.siblings('label').html(input.files[0].name);
        }

        reader.readAsDataURL(input.files[0]);
    }
}



$(document).ready(function() {
    $('.select2').change(function() {
        var application_id = $('input[name="id"]').val();
        var new_status = $('select[name="status"]').val();
        console.log('Application ID:', application_id);
        console.log('New Status:', new_status);
        
        // Set the form values
        $('#application_id').val(application_id);
        $('select[name="status"]').val(new_status);
        
        // Submit the form via AJAX
        $('#update_application_status').submit();
    });

    });

</script>

