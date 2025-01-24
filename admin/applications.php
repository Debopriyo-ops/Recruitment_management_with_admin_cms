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
                                <button class="btn btn-sm btn-block btn-success" id="download_pdf"><i class="fa fa-download"></i> Download PDF</button>
                                <!-- Email Button (conditionally visible) -->
                                <?php if ($pid == 1 && $position_id == 'all'): ?>
                                <button class="btn btn-sm btn-block btn-warning" id="send_email"><i class="fa fa-envelope"></i> Send Email</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
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
                        </div>
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
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                while ($row = $application->fetch_assoc()): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++ ?></td>
                                        <td class="">
                                            <p>Application ID: <b><?php echo $row['id'] ?></b></p>
                                            <p>Name: <b><?php echo $row['name'] ?></b></p>
                                            <p>Applied for : <b><?php echo $row['position'] ?></b></p>
                                            <p>Mobile: <b><?php echo $row['mobile'] ?></b></p>
                                            <p>Email: <b><?php echo $row['email'] ?></b></p>


                                        </td>
                                        <td class="text-center">
                                            <?php echo $stat_arr[$row['process_id']] ?>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary view_application" type="button" data-id="<?php echo $row['id'] ?>">View</button>
                                            <button class="btn btn-sm btn-primary edit_application" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
                                            <button class="btn btn-sm btn-danger delete_application" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End of Table Panel -->

            <!-- Filters Panel -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <button class="btn-block btn-sm btn filter_status" type="button" data-id="all">All</button>
                            </div>
                        </div>
                        <?php foreach ($stat_arr as $key => $value): ?>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <button class="btn-block btn-sm btn filter_status <?php echo $pid == $key ? 'btn-primary' : 'btn-info' ?>" type="button" data-id="<?php echo $key ?>"><?php echo $value ?></button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- End of Filters Panel -->
        </div>
    </div>
</div>

<style>
    td {
        vertical-align: middle !important;
    }

    td p {
        margin: unset;
    }

    img {
        max-width: 100px;
        max-height: 150px;
    }
</style>

<script>
    // Highlight active filter status button
    $('.filter_status').each(function(){
        if($(this).attr('data-id') == '<?php echo $pid ?>')
            $(this).addClass('btn-primary')
        else
            $(this).addClass('btn-info')
    });

    // Initialize DataTable (assuming you have included DataTables library)
    $('table').dataTable();

    // Event delegation for view_application buttons
    $(document).on('click', '.edit_application', function() {
        uni_modal("Edit Application", "manage_application.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    // View Application button click event
    $(document).on('click', '.view_application', function() {
        uni_modal("", "view_application.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    $(document).on('click', '.delete_application', function() {
        _conf("Are you sure to delete this Applicant?", "delete_application", [$(this).attr('data-id')]);
    });

    // Function to delete application via AJAX
    function delete_application($id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_application',
            method: 'POST',
            data: { id: $id },
            success: function (resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }

    // Filter status button click event
    $(document).on('click', '.filter_status', function() {
        const positionId = $('#position_filter').val();
        location.href = "index.php?page=applications&pid=" + $(this).attr('data-id') + '&position_id=' + positionId;
    });

    // Position filter change event
    $('#position_filter').change(function () {
        location.href = "index.php?page=applications&position_id=" + $(this).val() + '&pid=' + <?php echo json_encode($pid); ?>;
    });

    // Download PDF button click event
    $('#download_pdf').click(function () {
        const positionId = $('#position_filter').val();
        const pid = $('.filter_status.btn-primary').data('id');
        const url = `generate_pdf.php?pid=${pid}&position_id=${positionId}`;

        // Open the URL in a new window/tab to trigger the PDF download
        window.open(url, '_blank');
    });
    $('#send_email').click(function () {
        const positionId = $('#position_filter').val();
        const pid = 1;

        // Make AJAX request to send emails
        $.ajax({
        url: 'send_emails.php',
        method: 'POST',
        data: { pid: pid, position_id: positionId },
        success: function (resp) {
            if (resp.trim() === '1') {
                alert_toast("Emails successfully sent", 'success');
            } else {
                alert_toast("Failed to send emails", 'danger');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("AJAX error:", textStatus, errorThrown);
            alert_toast("Failed to send emails", 'danger');
        }
    });
});
</script>
