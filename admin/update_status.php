<?php
require 'db_connect.php'; // 

// Check if form data (id and status) is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Update the application status in the database
    $update_query = "UPDATE application SET process_id = '$status' WHERE id = '$id'";
    $update_result = $conn->query($update_query);

    // Check if update was successful
    if ($update_result) {
        // Redirect to the applications page
        header("Location: http://localhost/Recruitment_Management_System_2_alter_new/admin/index.php?page=applications");
        exit; // Ensure that subsequent code is not executed after redirection
    } else {
        echo "Failed to update status."; // Handle update failure
    }
}
?>