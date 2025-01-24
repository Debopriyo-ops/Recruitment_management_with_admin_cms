<!DOCTYPE html>
<html lang="en">
    <?php
    session_start();
    include('admin/db_connect.php');
    ob_start();
    $query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
     foreach ($query as $key => $value) {
      if(!is_numeric($key))
        $_SESSION['setting_'.$key] = $value;
    }
    ob_end_flush();
    include('header.php');

	
    ?>

    <style>
    	header.masthead {
		  background: white;
		  background-repeat: no-repeat;
      background-size: contain;
    		}
    </style>
<header class="masthead">
<div class="container">
  <div class="row align-items-center">
    <!-- Left Logo Column -->
    

    <!-- Content Column -->
    <div class="col-12 col-md-8" style="padding-left: 30px; text-align: left;">
    <h1 style="margin-bottom: 20px;"><span style="color: #48CAE4;">West Bengal Cyber Crime Wing of West Bengal Police</span></h1>
    <p >Inviting interested candidates to apply for the recruitment of 54 IT personnel:</p>
    <ul style="padding-left: 20px; list-style-position: inside;">
        <li><strong>1.</strong> Data Entry Operators </li>
        <li><strong>2.</strong> Software Support Personnel</li>
        <li><strong>3.</strong> System Administrator</li>
        <li><strong>4.</strong> Software Developer</li>  
        <li><strong>5.</strong> Security And Network Administrator</li>
        <li><strong>6.</strong> Senior Software Developer</li>
      </ul>
      <p>All positions are on a <strong>contractual basis</strong>.</p>
</div>

    <!-- Right Logo Column -->
    <div class="col-12 col-md-2 text-end">
      <img src="assets/img/WB_CCW_2.png" alt="Right Logo" class="img-fluid" style="max-width: 250px; height: auto;margin-right: -530px">
    </div>
  </div>
</div><!-- End of row -->
    
    <!-- General Instructions and Dates -->
    <div class="container mt-3 pt-2">
  <!-- General Instructions Section -->
  <p style="margin-bottom: 80px; text-align: left; padding-left: 20px;">
  <strong><span style="color: #48CAE4; font-size: 24px;">GENERAL INSTRUCTIONS:</span></strong><br><br>
  <strong>1.</strong> Fill all items that are relevant to you in capital letters or numbers or tick (✓) the check box as required. All items which are mandatory must be filled in; otherwise, the form may be rejected.<br><br>
  <strong>2.</strong> Please ensure that all information provided is correct and accurate. Submission of false information will be treated as null and void, and candidates will be liable for legal action.<br><br>
  <strong>3.</strong> Please ensure a valid and unique mobile number for a single post for future correspondence.<br><br>
  <strong>4.</strong> All incomplete and duplicate application forms will be summarily rejected.<br><br>
  <strong>5.</strong> Candidates are advised to upload scanned copies of their passport-size photograph, signature, copy of their Aadhaar Card, last qualifying exam's certificate, copy of OEM L2 Certification (for System Administrator), and copies of working experience certificates (if any).<br><br>
  <strong>6.</strong> The candidate is required to upload a recent (within three months) color photograph in dark clothes (contrast color with respect to the white background).<br><br>
  <strong>7.</strong> On successful submission of the application, the applicants shall be provided with an acknowledgment slip with some of their details and a unique Application ID by the system. A printout of the acknowledgment slip should be kept by the candidate for future reference.
</p>

  <!-- Start and End Date Section -->
  <p class="text-center" style="margin-top: 50px;font-size: 24px;">
    <strong>Start Date of Online Application:</strong> 00-00-2024<br>
    <strong>End Date of Online Application:</strong> 00-00-2024
  </p>

  <!-- Scroll Down Section -->
  <p class="text-center" style="margin-top: 50px; margin-bottom: 50px;font-size: 20px;">
    <strong> Please scroll down to apply online.</strong>
  </p>

  <!-- Down Arrow Image -->
  <div class="text-center">
    <img src="assets/img/Down_Arrow_frost_blue.png" alt="Down Arrow" class="arrow-down">
  </div>
</div>
 <!-- End of container -->
  </div> <!-- End of container -->
</header>


    <body id="page-top">
        <!-- Navigation-->
        <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
        </div>
      </div>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="./"><?php echo $_SESSION['setting_name'] ?></a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=home">Home</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=about">About</a></li>
                       <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=admit">Admit</a></li>

                     
                    </ul>
                </div>
            </div>
        </nav>
       
        <?php 
        $page = isset($_GET['page']) ?$_GET['page'] : "home";
        include $page.'.php';
        ?>
       

<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-righ t"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div id="preloader"></div>
        <footer class="bg-light py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="mt-0">Contact us</h2>
                        <hr class="divider my-4" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
                        <i class="fas fa-phone fa-3x mb-3 text-muted"></i>
                        <div><?php echo $_SESSION['setting_contact'] ?></div>
                    </div>
                    <div class="col-lg-4 mr-auto text-center">
                        <i class="fas fa-envelope fa-3x mb-3 text-muted"></i>
                        <!-- Make sure to change the email address in BOTH the anchor text and the link target below!-->
                        <a class="d-block" href="mailto:<?php echo $_SESSION['setting_email'] ?>"><?php echo $_SESSION['setting_email'] ?></a>
                    </div>
                </div>
            </div>
            <br>
            <div class="container"><div class="small text-center text-muted"><?php echo $_SESSION['setting_name'] ?> | <a href="https://cybercrimewing.wb.gov.in/" target="_blank">WB-CCW, Govt. of West Bengal</a></div></div>
        </footer>
        
       <?php include('footer.php') ?>
    </body>

    <?php $conn->close() ?>

</html>
