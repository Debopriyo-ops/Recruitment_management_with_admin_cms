<?php 
include 'admin/db_connect.php'; 
?>
<style>
#portfolio .img-fluid{
    width: calc(100%);
    height: 30vh;
    z-index: -1;
    position: relative;
    padding: 1em;
}
.vacancy-list{
cursor: pointer;
}
span.hightlight{
    background: yellow;
}
</style>
        <header class="masthead">
            <div class="container-fluid h-100">
                <!--<div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end mb-4 page-title">
                    	<h3 class="text-white"> <?php echo $_SESSION['setting_name']; ?></h3>
                        <hr class="divider my-4" />-->
                    <!--<div class="col-md-12 mb-2 text-left">
                        <div class="card">
                            <div class="card-body">
                                  <h4 class="text-center">Find Vacancies</h4>
                               <div class="form-group">
                                   <div class="input-group">
                                       <input type="text" class="form-control" id="filter">
                                       <div class="input-group-append">
                                           <span class="input-group-text"><i class="fa fa-search"></i></span>
                                       </div>
                                   </div>
                               </div>
                            </div>
                        </div>
                    </div>      -->                  
                    </div>
                    
                </div>
            </div>
        </header>
        <section id="">
<?php include 'admin/db_connect.php' ?>

<?php
    // Fetch all vacancy records including the status field
    $qry = $conn->query("SELECT * FROM vacancy");
?>

<div class="container mb-2 pt-4">
    <div class="table-responsive">
        <table class="table table-bordered table-white text-black">
            <thead class="thead-light">
                <tr>
                    <th>Position</th>
                    <th>Description</th>
                    <th>Vacancy</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $qry->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['position'] ?></td>
                    <td><?php echo html_entity_decode($row['description']) ?></td>
                    <td><?php echo $row['availability'] ?></td>
                    <td>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if($row['status'] == 1): ?>
                                    <button class="btn btn-block col-md-12 btn-primary btn-sm" type="button" onclick="applyNow(<?php echo $row['id'] ?>)">Apply Now</button>
                                <?php else: ?>
                                    <button class="btn btn-block col-md-12 btn-primary btn-sm" type="button" disabled="">Application Closed</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</section>
<script>
    $('html, body').animate({
        scrollTop: ($('section').offset().top - 72)
    }, 1000);

    function applyNow(id) {
        uni_modal('Application form', 'submit_application.php?id=' + id, 'large');
    }
</script>

<style>
    .table-white {
        background-color: #ffffff;
    }
    .text-black {
        color: #000000;
    }
</style>