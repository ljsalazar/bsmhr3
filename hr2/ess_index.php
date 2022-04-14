<?php
  $page_title = 'Employee Self Service';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);


   if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>


<?php include_once('layouts/header.php'); ?>
<!-- This will be the body -->
<div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>

       <?php if($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <nav class="breadcrumbs">
                <a href="apply_leave.php" class="breadcrumbs__item">Apply Leave</a>
                <a href="../hr3/time_index.php" class="breadcrumbs__item">Time and Attendance</a>
                </nav>
       <?php endif;?>

<div class="col-md-12">
      <div class="card h-100">
        <div class="card-header">
          <h2>EMPLOYEE SELF SERVICE</h2>
        </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>