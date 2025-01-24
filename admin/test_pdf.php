<?php
// Start output buffering at the very beginning
ob_start();

// Include FPDF library
require('fpdf/fpdf.php');

// Include database connection
include 'db_connect.php';

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Debug: Display the ID received
    error_log("ID received: $id");
    
    // Fetch application details
    $query = "SELECT id, position_id FROM application WHERE id = $id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $application = $result->fetch_assoc();
        $applicant_id = $application['id'];
        $position_id = $application['position_id'];
        
        // Fetch position name from vacancy table
        $position_query = $conn->query("SELECT position FROM vacancy WHERE id = $position_id");
        $position_name = 'Unknown Position';
        if ($position_query && $position_query->num_rows > 0) {
            $position = $position_query->fetch_assoc();
            $position_name = $position['position'];
        }

        // Clear the output buffer before generating PDF
        ob_end_clean();

        // Create a new PDF document
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // Set font
        $pdf->SetFont('Arial', 'B', 16);
        
        // Add a cell
        $pdf->Cell(40, 10, 'Acknowledgment Slip');
        $pdf->Ln(10); // Line break
        
        // Set font for the details
        $pdf->SetFont('Arial', '', 12);
        
        // Add ID
        $pdf->Cell(40, 10, 'ID: ' . $applicant_id);
        $pdf->Ln(10); // Line break
        
        // Add Position
        $pdf->Cell(40, 10, 'Position: ' . $position_name);
        
        // Set the headers to ensure the PDF is downloaded properly
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Acknowledgment_Slip.pdf"');
        header('Cache-Control: max-age=0');
        
        // Output the PDF as a download
        $pdf->Output('D', 'Acknowledgment_Slip.pdf');
        exit();
    } else {
        // Clear the output buffer and display an error message
        ob_end_clean();
        echo "Application not found.";
        error_log("Application not found for ID: $id");
    }
} else {
    // Clear the output buffer and display an error message
    ob_end_clean();
    echo "Invalid request.";
    error_log("Invalid request: ID parameter missing");
}
?>
