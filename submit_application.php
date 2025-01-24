<?php include 'admin/db_connect.php' ?>

<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check CAPTCHA
    if ($_POST['captcha'] != $_SESSION['captcha']) {
        die('CAPTCHA verification failed!');
    }

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed!');
    }
}


	$qry = $conn->query("SELECT * FROM vacancy where id=".$_GET['id'])->fetch_array();
	foreach($qry as $k =>$v){
		$$k = $v;
	}
	

    

?>
<style>

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container-fluid {
    padding: 20px;
}

/* Card styling */
.form-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    transition: all 0.3s ease;
}

.form-card:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

/* Form styling */
.form-group {
    padding: 20px;

}

.custom-file-input {
    cursor: pointer;
}

.custom-file-label {
    cursor: pointer;
}

/* Input and select styling */
.form-control, .custom-select {
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s ease;
}

.form-control:focus, .custom-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
}

.input-group {
    margin-bottom: 20px;
}

/* Button styling */
.btn-success, .btn-danger {
    border-radius: 5px;
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

/* Additional styles for file input */
.custom-file-label::after {
    content: "Browse";
}

.custom-file-input:lang(en) ~ .custom-file-label::after {
    content: "Browse";
}

.form-card {
    border: 1px solid #ddd; /* Border around the form */
    border-radius: 8px; /* Rounded corners */
    padding: 20px; /* Padding inside the form */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow for a card-like effect */
    margin: 20px 0; /* Margin around the form */
}

/* Form field spacing */
.form-group {
    margin-bottom: 1rem; /* Space between form groups */
}

/* File input styling */
.custom-file-input ~ .custom-file-label::after {
    content: "Browse"; /* Customize file input button text */
}

/* Button styling */
.btn-primary {
    background-color: #007bff; /* Primary button color */
    border: none; /* Remove border */
}
    </style>

<div class="container-fluid">
<form id="manage-application">
        <input type="hidden" name="id" value="">
		<input type="hidden" name="position_id" value="<?php echo $_GET['id'] ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?>">

	<div class="col-md-12">
		<div class="row">
			<h3>Application Form for <?php echo $position ?></h3>
		</div>
		<hr>
		<div class="row form-group">
		<div class="form-group">
                <label for="name">Applicant's Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="father_husband_name">Father/Husband's Name:</label>
                <input type="text" class="form-control" id="father_husband_name" name="father_husband_name" required>
            </div>
            
			<div class="row form-group">
			<div class="col-md-4">
            <label for="gender" class="control-label" style="display: block; width: 100px; font-size: 14px; margin-bottom: 5px;">Gender</label>
            <select name="gender" id="gender" class="custom-select browser-default" style="font-size: 14px; padding: 8px;">
            <option>Please Choose</option>
                <option>Male</option>
                  <option>Female</option>
					<option>Transgender</option>
				</select>
			</div>
            <div class="form-group">
    <label for="address">Address:</label>
    <textarea class="form-control" id="address" name="address" rows="5" cols="50" required></textarea>
</div>
            <div class="form-group">
                <label for="city">City/Town/Village:</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="post_office">Post Office:</label>
                <input type="text" class="form-control" id="post_office" name="post_office" required>
            </div>
            <div class="form-group">
                <label for="police_station">Police Station:</label>
                <input type="text" class="form-control" id="police_station" name="police_station" required>
            </div>
            <div class="form-group">
                <label for="district">District:</label>
                <input type="text" class="form-control" id="district" name="district" required>
            </div>


            <div class="form-group">
                <label for="state">State:</label>
                <input type="text" class="form-control" id="state" name="state" required>
            </div>
            
            <div class="form-group">
                <label for="pincode">Pincode:</label>
                <input type="text" class="form-control" id="pincode" name="pincode" required>
            </div>
            <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile:</label>
                <input type="text" class="form-control" id="mobile" name="mobile" required>
            </div>
            
            <div class="form-group">
                <label for="aadhar_number">Aadhar Number:</label>
                <input type="text" class="form-control" id="aadhar_number" name="aadhar_number" required>
            </div>
            <div class="custom-file">
    <input type="file" class="custom-file-input" id="aadhar_card" onchange="uploadFile(this)" name="aadhar_card" accept=".jpg,.jpeg,.png">
    <label id="aadhar_card_label" for="aadhar_card" style="color: red;">
        ***[File size should not exceed 100kb of only .jpeg, .jpg, .png for all the upload files]
    </label>

    <label class="custom-file-label" for="aadhar_card">UPLOAD AADHAR CARD</label>
</div>

    </div>
</div>
            
<div class="row form-group">
    <div class="input-group col-md-4 mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="">Photo</span>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="photo" onchange="displayfname(this, $(this), 100)" name="photo" accept=".jpg,.jpeg,.png">
            <label class="custom-file-label" for="photo">Choose file</label>

            
           
        </div>
    </div>
</div>

<div class="row form-group">
    <div class="input-group col-md-4 mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="">Signature</span>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="signature" onchange="displayfname(this, $(this), 100)" name="signature" accept=".jpg,.jpeg,.png">

            <label class="custom-file-label" for="signature">Choose file</label>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="dob">Date of Birth (yyyy-MM-dd):</label>
    <input type="date" class="form-control" id="dob" name="dob" pattern="\d{4}-\d{2}-\d{2}" title="Enter a date in the format yyyy-MM-dd" required>
</div>
			
            <div class="form-group">
                <label>Qualification Details:</label>
                <table class="table table-bordered" id="qualification_table">
                    <thead>
                        <tr>
                            <th>Degree</th>
                            <th>Institution</th>
                            <th>Year of Passing</th>
                            <th>Percentage/Grade</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="degree[]" class="form-control" required></td>
                            <td><input type="text" name="institution[]" class="form-control" required></td>
                            <td><input type="text" name="year_of_passing[]" class="form-control" required></td>
                            <td><input type="text" name="percentage[]" class="form-control" required></td>
                            <td><button type="button" class="btn btn-danger remove_row">Remove</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" id="add_qualification_row">Add Row</button>
            </div>
            <div class="form-group">
    <span class="sub_heading clsExpHead">TOTAL WORK EXPERIENCE (IF ANY):</span>
</div>

<div class="row">
    <div class="col-md-2 text-center bold_text">From Date</div>
    <div class="col-md-2 text-center bold_text">To Date</div>
</div>

<div class="row">
    <div class="col-md-2">
        <input type="date" class="form-control" name="from_date[]" placeholder="Select From Date">
    </div>
    <div class="col-md-2">
        <input type="date" class="form-control" name="to_date[]" placeholder="Select To Date">
    </div>
</div>

            <div class="form-group mt-3">
            <label>Work Experience Details:</label>
            <table class="table table-bordered" id="experience_table">
                   <thead>
            <tr>
                <th>Organization</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Nature of Job</th>
                <th>Platform Used</th>
                <th>Action</th>
            </tr>
                </thead>
                <tbody>
            <tr>
                <td><input type="text" name="organization[]" class="form-control" required></td>
                <td><input type="date" name="from_date[]" class="form-control" required></td>
                <td><input type="date" name="to_date[]" class="form-control" required></td>
                <td><input type="text" name="nature_of_job[]" class="form-control" required></td>
                <td><input type="text" name="platform_used[]" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger remove_row">Remove</button></td>
            </tr>
        </tbody>
    </table>
    <button type="button" class="btn btn-success" id="add_experience_row">Add Row</button>
    </div>
    
			<div class="row form-group">
    <div class="input-group col-md-4 mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="">Upload Work Experience</span>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="work_experience" onchange="displayfname(this, $(this), 100)" name="work_experience" accept=".jpg,.jpeg,.png">

            <label class="custom-file-label" for="work_experience">Choose file</label>
        </div>
    </div>
</div>

<div class="row form-group">
    <div class="input-group col-md-4 mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="">Upload Last Qualification</span>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="last_qualification" onchange="displayfname(this, $(this), 100)" name="last_qualification" accept=".jpg,.jpeg,.png">

            <label class="custom-file-label" for="last_qualification">Choose file</label>
        </div>
    </div>
</div>
			
            <div class="form-group">
                <label for="captcha">CAPTCHA Code:</label>
                <div class="row">
                    <div class="col-md-6">
                        <img src="generate_captcha.php" alt="CAPTCHA Image">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="captcha" name="captcha" required>
                    </div>
                </div>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="declaration" name="declaration" required>
                <label class="form-check-label" for="declaration">I hereby declare that all the information given by me in this application is true and correct to the best of my knowledge and belief. I also note that if any of the above statements are found to be incorrect or false or any information particulars have been suppressed or omitted in this from, I am liable to be disqualified for requisite test or if selected my appointment  will be cancelled without any compensation in lieu of notice.</label>
            </div>
		
			  
			</div>
		</div>
	</div>
	</form>
</div>
<script>
        $(document).ready(function() {
            $('#add_qualification_row').click(function() {
                var newRow = '<tr>' +
                    '<td><input type="text" name="degree[]" class="form-control" required></td>' +
                    '<td><input type="text" name="institution[]" class="form-control" required></td>' +
                    '<td><input type="text" name="year_of_passing[]" class="form-control" required></td>' +
                    '<td><input type="text" name="percentage[]" class="form-control" required></td>' +
                    '<td><button type="button" class="btn btn-danger remove_row">Remove</button></td>' +
                    '</tr>';
                $('#qualification_table tbody').append(newRow);
            });

            $(document).on('click', '.remove_row', function() {
                $(this).closest('tr').remove();
            });

            $('#declaration').change(function() {
                if ($(this).is(':checked')) {
                    alert("I hereby declare that all the information given by me in this application is true and correct to the best of my knowledge and belief. I also note that if any of the above statements are found to be incorrect or false or any information particulars have been suppressed or omitted in this from, I am liable to be disqualified for requisite test or if selected my appointment  will be cancelled without any compensation in lieu of notice.");
                }
            });
        });
       


    </script>
   <script>

$(document).ready(function() {
    $('#add_experience_row').click(function() {
        var newRow = '<tr>' +
            '<td><input type="text" name="organization[]" class="form-control" required></td>' +
            '<td><input type="date" name="from_date[]" class="form-control" required></td>' +
            '<td><input type="date" name="to_date[]" class="form-control" required></td>' +
            '<td><input type="text" name="nature_of_job[]" class="form-control" required></td>' +
            '<td><input type="text" name="platform_used[]" class="form-control" required></td>' +
            '<td><button type="button" class="btn btn-danger remove_row">Remove</button></td>' +
            '</tr>';
        $('#experience_table tbody').append(newRow);
    });

    $(document).on('click', '.remove_row', function() {
        $(this).closest('tr').remove();
    });
});
       
       
       
   </script>

    
 








<script>
	function displayfname(input, _this, maxSizeKB) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            var fileSizeKB = file.size / 1024; // Convert bytes to KB

            if (fileSizeKB > maxSizeKB) {
                alert('File size should not exceed ' + maxSizeKB + ' KB.');
                input.value = ''; // Clear the input
                _this.siblings('label').html('Choose file'); // Reset label text
                return;
            }

            var reader = new FileReader();
            reader.onload = function (e) {
                console.log(file.name);
                _this.siblings('label').html(file.name);
            }
            reader.readAsDataURL(file);
        }
    }
/*function displayfname(input, element) {
    var fileName = input.files[0].name;
    element.next('.custom-file-label').html(fileName);
}*/


$(document).ready(function(){
    $('input[type="file"]').change(function(){
        displayfname(this, $(this));
    });
});

$(document).ready(function() {
    $('#manage-application').submit(function(e) {
        e.preventDefault();

        var formData = new FormData($(this)[0]);

        $.ajax({
            url: 'admin/ajax.php?action=save_application',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                console.log('Server response:', resp); // Log the response for debugging
                if (resp != "0" && !isNaN(resp)) {
                    alert('Application successfully submitted.');
                    // Redirect to the acknowledgment page with the ID
                    window.location.href = 'acknowledge_application_2.php?id=' + resp;
                } else {
                   alert('An error occurred while saving the application.');
                }
            },
            error: function(err) {
                console.log('AJAX error:', err); // Log the AJAX error for debugging
                alert('An error occurred while submitting the application. Please check the console for details.');
            }
        });
    });
});

</script>

<script>
function uploadFile(input) {
    var file = input.files[0];
    var label = document.getElementById('aadhar_card_label');

    // Check if file is selected
    if (!file) {
        return;
    }

    // Check file size (max 100kb)
    if (file.size > 100 * 1024) { // 100kb
        label.style.color = 'red'; // Error state
        alert('File size should not exceed 100kb.');
        return;
    }

    // Check file type
    var allowedTypes = ['image/jpeg', 'image/png'];
    if (!allowedTypes.includes(file.type)) {
        label.style.color = 'red'; // Error state
        alert('Only .jpeg, .jpg, .png files are allowed.');
        return;
    }

    // Simulate upload success (in a real scenario, you would handle the upload here)
    // You could use AJAX to upload the file to the server and handle the response

    // Update label color to green on successful upload (for demonstration, this is just after validation)
    label.style.color = 'green';
}
</script>

<?php 

unset($_SESSION['csrf_token']);
unset($_SESSION['captcha']);

?>