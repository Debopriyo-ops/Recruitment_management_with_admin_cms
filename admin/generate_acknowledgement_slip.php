<?php
require('fpdf/fpdf.php');
require('db_connect.php'); 

if (isset($_POST['application_id'])) {
    $application_id = $_POST['application_id'];

    // Fetch all positions from vacancy table

    $qry = $conn->query("SELECT * FROM vacancy");
    $positions = [];
    while ($row = $qry->fetch_assoc()) {
        $positions[$row['id']] = $row['position'];
    }

    // Fetch applicant details from the database
    $stmt = $conn->prepare("SELECT name, position_id, address, aadhar_number, photo_path FROM application WHERE id = ?");
    $stmt->bind_param("i", $application_id);
    $stmt->execute();
    $stmt->bind_result($name, $position_id, $address, $aadhar_number, $photo_path);
    $stmt->fetch();
    $stmt->close();

    if ($name && $position_id) {
        // Fetch position name
        $stmt = $conn->prepare("SELECT position_id FROM application WHERE id = ?");
        $stmt->bind_param("i", $position_id);
        $stmt->execute();
        $stmt->bind_result($position);
        $stmt->fetch();
        $stmt->close();

        // Generate PDF using FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Acknowledgement Slip', 0, 1, 'C');
        $pdf->Ln(20);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 10, 'Application ID: ' . $application_id);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Name: ' . $name);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Post Applied For: ' . $positions[$position_id]);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Address: ' . $address);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Aadhaar Number: ' . $aadhar_number);
        $pdf->Ln(10);

        // Add photo if exists
        if (!empty($photo_path) && file_exists('assets/photo/' . $photo_path)) {
            $pdf->Image('assets/photo/' . $photo_path, 150, 10, 30, 30);
        }

        $pdf->Output('D', 'acknowledgement_slip.pdf'); 
    } else {
        echo "No application found with the provided ID.";
    }
} else {
    echo "Application ID is required.";
}
?>
