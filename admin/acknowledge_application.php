<?php
include('db_connect.php');
require('fpdf/fpdf.php'); 

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch application details with position
    $application = $conn->query("SELECT a.*, v.position FROM application a INNER JOIN vacancy v ON v.id = a.position_id WHERE a.id = $id")->fetch_array();

    if ($application) {
        $name = $application['name'];
        $address = $application['address'];
        $position_id = $application['position_id'];
        $aadhar_number = $application['aadhar_number'];
        $position = $application['position'];

        // Display the details
        echo "Your Application ID: " . $id . "<br>";
       
        // Fetch all vacancies
        $qry = $conn->query("SELECT * FROM vacancy");
        while ($row = $qry->fetch_assoc()) {
            $pos[$row['id']] = $row['position'];
        }

       
    } else {
        echo "No application found with ID: " . $id;
    }
} else {
    echo "No ID found.";
}
?>


<div class="container">
    <h2>Generate Acknowledgement Slip</h2>
    <form action="generate_acknowledgement_slip.php" method="POST">
        <div class="form-group">
            <label for="application_id">Application ID:</label>
            <input type="text" class="form-control" id="application_id" name="application_id" required>
        </div>
        <button type="submit" class="btn btn-primary">Generate Acknowledgement Slip</button>
    </form>
</div>

