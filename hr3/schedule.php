<?php
  $page_title = 'Schedule';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
   // $leave_history = tblleave();

   if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
	include_once('layouts/header.php');
 //code for update to read all new notifications...// 
//Query Statement for unread leave===
    $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
    $user = current_user();
    $userid = (int)$user['id'];
    //====================================
$empread=1; 
$sql="UPDATE tblschedule SET emp_read='{$empread}' WHERE empid='{$userid}' AND Status=1";
$result = $db->query($sql);

?>
<!-- This will be the body -->
<div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
      <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
        <nav class="breadcrumbs">
        <a href="scheduling.php" class="breadcrumbs__item">Scheduling</a>
        <a href="set_shift.php" class="breadcrumbs__item">Set Shift</a>
        <a href="schedule_management.php" class="breadcrumbs__item">Manage Schedule</a>
        </nav>

  <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special menu -->
        <nav class="breadcrumbs">
        <a href="scheduling.php" class="breadcrumbs__item">Scheduling</a>
        <a href="set_shift.php" class="breadcrumbs__item">Set Shift</a>
        <a href="schedule_management.php" class="breadcrumbs__item">Manage Schedule</a>
        </nav>


      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <nav class="breadcrumbs">
        <a href="schedule.php" class="breadcrumbs__item is-active">Schedule</a>
        </nav>
      
    <?php endif;?>
     </div>

     <div class="col-md-12">
     <div class="card h-100">
					<div class="card-header">
         
          <div class="pull-right">
          <a href="generate_schedule_report.php?id=<?php $user = current_user();
    $userid = (int)$user['id']; echo $userid; ?>" class="btn btn-danger">PDF <span class="bi bi-filetype-pdf"></a>
         </div>
        </div>
        <div class="card-body">
          <!--<table class="table table-bordered" class="table table-sm table-striped table-bordered table-hover" style="width:100%">-->
            <table id="example" class="table table-striped data-table" style="width:100%">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Shift Schedule</th>
                <th class="text-center">Days</th>
                <th class="text-center">Posting Date</th>
                <th class="text-center">Action taken date</th>
              </tr>
            </thead>
            <tbody>
              <?php 

              //Query Statement for leave history
              $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
              $user = current_user();
              $userid = (int)$user['id'];

              $sql  ="SELECT s.id,s.days,s.PostingDate,s.AdminRemarkDate,s.Status,s.empid,s.shift_type_id,t.name,t.fromTime,t.toTime FROM tblschedule s";
              $sql .=" LEFT JOIN tblshift_type t ON s.shift_type_id = t.id ";
              $sql .=" WHERE s.empid = '{$userid}' AND s.Status = 1";
              $sql .=" ORDER BY id ASC";
              if($result = $conn->query($sql)){
              while ($row = $result -> fetch_row()) {
              ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td class="text-center"> <?php 
                  $start_time = date("g:i a", strtotime($row[8]));
                  $end_time = date("g:i a", strtotime($row[9])); 
                  echo remove_junk($row[7]." (".$start_time."-".$end_time.")"); ?></td>
                <td class="text-center"><?php echo remove_junk($row[1]); ?></td>                   
                <td class="text-center"><?php echo read_date($row[2]); ?></td> 
                <td class="text-center"> <?php echo read_date($row[3]); ?></td>
              </tr>
             <?php } }?>
            </tbody>
          </tabel>
        </div>
      </div>



       </div>
  </div>

<!--from startbootstrap.com this is for Datatables...
    <link href="dist/css/styles.css" rel="stylesheet" />
    -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="dist/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="dist/js/datatables-simple-demo.js"></script>

<?php include_once('layouts/footer.php'); ?>