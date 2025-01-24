<?php
require('fpdf/fpdf.php');
require('admin/db_connect.php'); 

if (isset($_POST['application_id'])) {
    $application_id = $_POST['application_id'];

    // Fetch all positions from vacancy table
    $qry = $conn->query("SELECT * FROM vacancy");
    $positions = [];
    while ($row = $qry->fetch_assoc()) {
        $positions[$row['id']] = $row['position'];
    }

    // Fetch applicant details from the database
    $stmt = $conn->prepare("SELECT name, father_husband_name, dob, position_id, address, aadhar_number, photo_path, signature_path FROM application WHERE id = ?");
    $stmt->bind_param("i", $application_id);
    $stmt->execute();
    $stmt->bind_result($name, $father_husband_name, $dob, $position_id, $address, $aadhar_number, $photo_path, $signature_path);
    $stmt->fetch();
    $stmt->close();

    if ($name && $position_id) {
        // Generate PDF using FPDF
        $pdf = new FPDF();
        $pdf->AddPage();

        // Add logo
        if (file_exists('assets/img/WB_CCW_2.png')) {
            $pdf->Image('assets/img/WB_CCW_2.png', 10, 10, 45, 45); 
        }

        $pdf->SetLineWidth(0.4); // Set border thickness
        $pdf->Rect(10, 10, 190, 45);
        // Add titles
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(0, 10, 'Cyber Crime Wing', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 16); 
        $pdf->Cell(0, 10, 'Govt. of West Bengal', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'ADMIT CARD', 0, 1, 'C');
        $pdf->Ln(20);

        $pdf->SetLineWidth(0.3); 
        $pdf->Rect(10, 60, 140, 75);

        // Set font for applicant details
        $pdf->SetFont('Arial', '', 12);

        // Left column for text
        $pdf->Cell(90, 10, 'Application ID: ' . $application_id);
        $pdf->Ln(10);
        $pdf->Cell(90, 10, 'Name: ' . $name);
        $pdf->Ln(10);
        $pdf->Cell(90, 10, 'Father/Husband Name: ' . $father_husband_name);
        $pdf->Ln(10);
        $pdf->Cell(90, 10, 'DOB: ' . $dob);
        $pdf->Ln(10);
        $pdf->Cell(90, 10, 'Post Applied For: ' . $positions[$position_id]);
        $pdf->Ln(10);
        $pdf->Cell(90, 10, 'Address: ' . $address);
        $pdf->Ln(10);
        $pdf->Cell(90, 10, 'Aadhaar Number: ' . $aadhar_number);
        $pdf->Ln(10);

        

        $pdf->SetLineWidth(0.3);
        $pdf->Rect(165, 65, 40, 40);

        // Add photo if exists
        if (!empty($photo_path) && file_exists('admin/assets/photo/' . $photo_path)) {
            $pdf->Image('admin/assets/photo/' . $photo_path, 165, 65, 30, 20); // Adjust the position (x, y) and size
        }

        // Add signature if exists
        if (!empty($signature_path) && file_exists('admin/assets/signature/' . $signature_path)) {
            $pdf->Image('admin/assets/signature/' . $signature_path, 165, 85, 40, 15); // Adjust the position (x, y) and size
        }


        $pdf->Ln(15);

        // Add Important Instructions
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'IMPORTANT INSTRUCTIONS:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(0, 10, 
            "1. Candidates should check the Admit Card carefully and bring discrepancies, if any, to the notice of the Commission's office immediately.\n" .
            "2. Admission to the examination is purely provisional subject to determination of eligibility in terms of the advertisement.\n" .
            "3. Under no circumstances admission will be allowed without the valid Admit Card downloaded from the Commission's website.\n" .
            "4. Candidates are advised not to bring any Item except those required for the purpose of examination, e.g. admit card, Id proof, photograph etc.\n" .
            "5. Candidates are required to bring two Identical stamp size photographs along with any one of the following documents in original: (i) Madhyamik or equivalent certificate bearing photograph, (ii) Passport, (iii) PAN Card, (iv) EPIC (Voter Identity Card), (v) Driving License and (vi) any other I.D. proof issued by the State or Central Government.\n" .
            "6. PLEASE NOTE THAT ENTRY INTO THE EXAMINATION VENUE SHALL BE CLOSED 10 MINUTES BEFORE THE SCHEDULED TIME OF COMMENCEMENT OF THE EXAMINATION i.e. 11:50 a.m. NO CANDIDATE SHALL BE ALLOWED ENTRY INTO THE EXAMINATION VENUE AFTER THE CLOSING TIME.\n" .
            "7. Candidates should reach the Examination Venue 1 (one) hour before and enter the Examination Hall at least 30 (thirty) minutes before commencement of the examination.\n" .
            "8. No candidate will be allowed to leave the examination hall before the scheduled hour of conclusion of the examination.\n" .
            "9. The candidates should use only BLACK BALL POINT PEN for making all the entries as well as darkening the ovals in the Attendance Sheets. They are advised to bring their own Black Ball Point Pens.\n" .
            "10. I. Candidates are advised not to use whitener, blade etc. to smudge the entries in the OMR sheet. Smudging of entries in the OMR sheet will be treated as adoption of unfair means.\n" .
            "ii. Carrying / using mobile phones, smart watches, calculators, portable scanner, Bluetooth device, gadgets of communication inside the examination hall will also be treated as adoption of unfair means.\n" .
            "Adoption of any kind of unfair means during the hours of examination will attract penal action including ban from future examinations as would be deemed fit by the Commission without any prior intimation to the candidates.\n" .
            "11. Candidates having benchmark disabilities with limitation in writing including that of speed [i.e PwBD (CT) and PwBD(CTS) candidates] will be allowed 30 minutes compensatory time (i.e. @20 mins per hour)\n" .
            "12. PWBD(CT) and PWBD(CTS) candidates are advised to bring Disability Certificate and a valid certificate (Appendix -1) from a Competent Authority issued on or before 02.11.2023 and produce the same in the Examination Hall on demand for verification and for availing of Compensatory Time and/or Scribe.\n" .
            "13. Candidates having benchmark disabilities with limitation in writing including that of speed and requiring the help of a Scribe as indicated in the application form are requested to engage their own Scribe. The Scribe must have academic qualification one step below the qualification of the candidate taking Examination.\n" .
            "14. A candidate having completed his/her answer-script must hand it over, even if blank, to the Invigilator before leaving the examination hall. The answer-script must on no account be left on the desk.\n" .
            "15. There will be an arrangement for frisking of the candidates at the entry point of the venue.\n" .
            "16. Candidate may carry his/her own hand sanitizer (small size) and drinking water in transparent bottles.\n" .
            "17. Candidates will have to remove any kind of mask/face cover (if used) for verification whenever required by the examination functionaries.\n" .
            "****CARRYING / USING MOBILE PHONES, SMART WATCHES, CALCULATORS, PORTABLE SCANNER, BLUETOOTH DEVICE, GADGETS OF COMMUNICATION, CLIPBOARD IS COMPLETELY BANNED INSIDE THE PREMISES WHERE THE EXAMINATION IS BEING CONDUCTED. CANDIDATES ARE ADVISED IN THEIR OWN INTEREST NOT TO BRING ANY OF THE BANNED ITEMS INCLUDING MOBILE PHONES OR ANY VALUABLE / COSTLY ITEMS TO THE VENUE OF THE EXAMINATION AS ARRANGEMENT FOR SAFE KEEPING CAN NOT BE ASSURED. COMMISSION WILL NOT BE RESPONSIBLE FOR ANY LOSS IN THIS REGARD.");

        // Output the PDF file
        $pdf->Output('D', 'admit_card.pdf'); 
    } else {
        echo "No application found with the provided ID.";
    }
} else {
    echo "Application ID is required.";
}
?>
