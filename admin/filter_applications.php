<?php include('db_connect.php'); ?>

<?php
// Fetch positions
$qry = $conn->query("SELECT * FROM vacancy");
while ($row = $qry->fetch_assoc()) {
    $pos[$row['id']] = $row['position'];
}

$pid = 'all';
if (isset($_GET['pid']) && $_GET['pid'] >= 0) {
    $pid = $_GET['pid'];
}

$position_id = 'all';
if (isset($_GET['position_id']) && $_GET['position_id'] >= 0) {
    $position_id = $_GET['position_id'];
}

// Fetch application status labels
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

$filtered_applications = [];
if ($application->num_rows > 0) {
    while ($row = $application->fetch_assoc()) {
        $qualification_details = explode("; ", $row['qualification_details']);
        foreach ($qualification_details as $detail) {
            $parts = explode(" - ", $detail);
            if (count($parts) == 4) {
                list($degree, $institution, $year_of_passing, $percentage) = $parts;
                // Convert percentage to integer
                $percentage = (int)$percentage;
                if ($percentage >= 60) {
                    $filtered_applications[] = $row;
                    break;
                }
            }
        }
    }
}

// Debugging: Print the filtered applications array
// Remove this section in production
//echo "<pre>";
//print_r($filtered_applications);
//echo "</pre>";




?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row">
            <!-- Table Panel -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <span><large><b>Application List</b></large></span>
                                <!-- PDF Download Button -->
                                <!--<button class="btn btn-sm btn-block btn-success" id="download_pdf"><i class="fa fa-download"></i> Download PDF</button>-->
                            </div>
                        </div>
                    </div>
                  <!--  <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-2 offset-md-2 text-right">Position :</div>
                                    <div class="col-md-5">
                                        <select name="" class="custom-select browser-default select2" id="position_filter">
                                            <option value="all" <?php echo $position_id == "all" ? "selected" : '' ?>>All</option>
                                            <?php foreach ($pos as $k => $v): ?>
                                                <option value="<?php echo $k ?>" <?php echo $position_id == $k ? "selected" : '' ?>><?php echo $v ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <hr><br>
                        <table class="table table-bordered table-hover">
                            <colgroup>
                                <col width="10%">
                                <col width="30%">
                                <col width="20%">
                                <col width="30%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Applicant Information</th>
                                    <th class="text-center">Position</th>
                                    <th class="text-center">Qualification Details</th>
                                </tr>
                            </thead>
                            <tbody>
                           
                                <?php if (!empty($filtered_applications)): ?>
                                    <?php foreach ($filtered_applications as $key => $application): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $key + 1 ?></td>
                                            <td>
                                               <p>Application ID: <b><?php echo $application['id'] ?></b></p>
                                               <p>Name: <b><?php echo $application['name'] ?></b></p>
                                            </td>
                                            <td class="text-center">
                                            <p>Applied For: <b><?php echo $application['position'] ?></b></p>
                                            </td>
                                            <td class="text-center">
                                            <p>Qualification: <b><?php echo $application['qualification_details'] ?></b></p>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No applications found with qualification percentage >= 60%</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            <!-- End of Table Panel -->

            <!-- Filters Panel -->
     <script>
         $('table').dataTable();
</script>       
