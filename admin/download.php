<?php
include 'db_connect.php';

// Check if file_type and id are provided in the URL
if (isset($_GET['file_type']) && isset($_GET['id'])) {
    $file_type = $_GET['file_type'];
    $id = $_GET['id'];
    
    // Fetch the filename from the database based on file_type and id
    $result = $conn->query("SELECT $file_type FROM application WHERE id = $id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fname = $row[$file_type];
        
        // Determine the file path based on the file_type
        switch ($file_type) {
            case 'aadhar_card_path':
                $file_path = "assets/aadhar_card/" . $fname;
                break;
            case 'photo_path':
                $file_path = "assets/photo/" . $fname;
                break;
            case 'signature_path':
                $file_path = "assets/signature/" . $fname;
                break;
            
            case 'work_experience_path':
                $file_path = "assets/work_experience/" . $fname;
                break;
                case 'last_qualification_path':
                    $file_path = "assets/last_qualification/" . $fname;
                    break;
            default:
                die("Invalid file type specified.");
        }
        
        // Remove timestamp or identifier from the filename
        $cleaned_fname = explode('_', $fname);
        unset($cleaned_fname[0]);
        $cleaned_fname = implode("", $cleaned_fname);
        
        // Set headers for file download
        header("Content-Type: " . filetype($file_path));
        header("Content-Length: " . filesize($file_path));
        header("Content-Disposition: attachment; filename=" . $cleaned_fname);
        
        // Output the file
        readfile($file_path);
        exit; // Stop further execution
    } else {
        die("File not found.");
    }
} else {
    die("Invalid request.");
}
?>
