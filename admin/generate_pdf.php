<?php
// Include the Composer autoload file
require_once(__DIR__ . '/../vendor/autoload.php'); // Adjust path if necessary

use Dompdf\Dompdf;
use Dompdf\Options;

// Initialize DOMPDF
$dompdf = new Dompdf();

// Set DOMPDF options (optional)
$options = new Options();
$options->set('defaultFont', 'Helvetica');
$dompdf->setOptions($options);

// Get filter parameters
$pid = isset($_GET['pid']) ? $_GET['pid'] : 'all';
$position_id = isset($_GET['position_id']) ? $_GET['position_id'] : 'all';

// Database connection
include(__DIR__ . '/db_connect.php'); // Adjust the path if necessary
$stats = $conn->query("SELECT * FROM recruitment_status ORDER BY id ASC");
$stat_arr[0] = "New";
while ($row = $stats->fetch_assoc()) {
    $stat_arr[$row['id']] = $row['status_label'];
}
// Construct WHERE clause based on filters
$awhere = '';
if ($pid != 'all') {
    $awhere .= " WHERE a.process_id = '$pid' ";
}
if ($position_id != 'all') {
    if (!empty($awhere)) {
        $awhere .= " AND ";
    } else {
        $awhere .= " WHERE ";
    }
    $awhere .= " a.position_id = '$position_id' ";
}

// Fetch applications based on filters
$application = $conn->query("SELECT a.*, v.position 
                             FROM application a 
                             INNER JOIN vacancy v ON v.id = a.position_id 
                             $awhere 
                             ORDER BY a.id ASC");

// Generate HTML content
$html = '<html>
            <head>
                <style>
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid black;
                        padding: 8px;
                        text-align: left;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                </style>
            </head>
            <body>
                <h1>Filtered Applications List</h1>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Applicant Information</th>
                            <th>Status</th>
                            <th>Post Applied For</th>
                        </tr>
                    </thead>
                    <tbody>';

$i = 1;
while ($row = $application->fetch_assoc()) {
    $html .= '<tr>
                <td>' . $i++ . '</td>
                <td>Name: ' . ucwords($row['name']) . '<br>Application ID: ' . $row['id']  . '<br>Mobile: ' . $row['mobile'] .'<br>Email: ' . $row['email'] .'</td>
                <td>' .$stat_arr[$row['process_id']] .'</td>
                <td>' . $row['position'] . '</td>
                
              </tr>';
}

$html .= '</tbody></table></body></html>';

// Load HTML content
$dompdf->loadHtml($html);

// (Optional) Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render PDF (first pass)
$dompdf->render();

// Stream the PDF (browser view) or download it
$dompdf->stream('filtered_applications.pdf', array('Attachment' => 1));
?>
