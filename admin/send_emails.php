<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '/../vendor/autoload.php');include('db_connect.php');

if (isset($_POST['pid']) && isset($_POST['position_id'])) {
    $pid = $_POST['pid'];
    $position_id = $_POST['position_id'];

    // Construct WHERE clause based on filters
    $awhere = " WHERE a.process_id = '$pid' ";
    if ($position_id != 'all') {
        $awhere .= " AND a.position_id = '$position_id' ";
    }

    // Fetch emails of applicants based on filters
    $qry = $conn->query("SELECT email FROM application a 
                         INNER JOIN vacancy v ON v.id = a.position_id 
                         $awhere");

    $emails = [];
    while ($row = $qry->fetch_assoc()) {
        $emails[] = $row['email'];
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->SMTPDebug = 0;                                
        $mail->isSMTP();
        $mail->Host = 'smtp-mail.outlook.com';  // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'cybercrime24@hotmail.com';  // SMTP username
        $mail->Password = 'Ccw@#$123';           // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('cybercrime24@hotmail.com', 'WB CCW Recruitment Team');
        $mail->Subject = 'Notification from WB CCW Recruitment';
        $mail->Body = "Dear Applicant,\n\nThis is a notification regarding your application at WB CCW, Govt of West Bengal.\nPlease visit the link to download your admit card.\nUrl: http://localhost/Recruitment_Management_System_2_alter_new/index.php?page=admit.\n\nRegards,\nRecruitment Team\nWB CCW Govt of West Bengal";
        // Send email to each applicant
        foreach ($emails as $email) {
            $mail->addAddress($email);
            if (!$mail->send()) {
                echo "0";  // Fail response
                exit;
            }
            $mail->clearAddresses();
        }

        echo "1";  // Success response
    } catch (Exception $e) {
        echo "0";  // Fail response
    }
} else {
    echo "0";  // Invalid request response
}

?>
