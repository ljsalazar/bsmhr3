<?php
  $page_title = 'Scheduling';
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
  
  <?php
    //Query Statement for unread leave===
    $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
    $user = current_user();
    $userid = (int)$user['id'];
    //====================================
    $isread=0;
    $empread=0;
    $totalEmpUnread=0;
    $totalAdminUnread=0;
    $status=1;
    $sql = "SELECT id FROM tblschedule WHERE emp_read='{$empread}' AND empid='{$userid}' AND Status='{$status}'";
    $result = $conn->query($sql);
    while($unreadcount = $result -> fetch_row()){
      $totalEmpUnread++;
    }
    $sql = "SELECT id FROM tblschedule WHERE IsRead='{$isread}'";
    $result = $conn->query($sql);
    while($unreadcount = $result -> fetch_row()){
      $totalAdminUnread++;
    }
    ?>
    <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
        <nav class="breadcrumbs">
        <a href="set_shift.php" class="breadcrumbs__item">Set Shift</a>
        <a href="schedule_management.php" class="breadcrumbs__item">Manage Schedule<?php if(!$totalAdminUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalAdminUnread; ?></span><?php } ?></a>
        <a href="scheduling.php" class="breadcrumbs__item is-active">Scheduling</a>
        </nav>

  <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special menu -->
        <nav class="breadcrumbs">
        <a href="set_shift.php" class="breadcrumbs__item">Set Shift</a>
        <a href="schedule_management.php" class="breadcrumbs__item">Manage Schedule<?php if(!$totalAdminUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalAdminUnread; ?></span><?php } ?></a>
        <a href="scheduling.php" class="breadcrumbs__item is-active">Scheduling</a>
        </nav>


      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <nav class="breadcrumbs">
        <a href="schedule.php" class="breadcrumbs__item">Your Schedule</a>
        </nav>
      
    <?php endif;?>
    </div>
  <div class="col-md-12">
      <div class="card h-100">
        <div class="card-header">
          <h2>Scheduling</h2>
        </div>
        <div class="card-body">
          <!--<table class="table table-bordered" class="table table-sm table-striped table-bordered table-hover" style="width:100%">-->
            <table id="datatablesSimple" class="table table-striped data-table" style="width:100%">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center" style="width: 50px;">Employee Name</th>
                <th class="text-center" style="width: 50px;">Username</th>
                <th class="text-center" style="width: 100px;"> Status </th>
                <th class="text-center" style="width: 100px;"> Action </th>
              </tr>
            </thead>
            <tbody>
              <?php 

              //Query Statement for leave history===
              $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
              $user = current_user();
              $userid = (int)$user['id'];
              //===================================
              $sql  =" SELECT *";
              $sql .=" FROM users";
              $sql .=" WHERE user_level = 3";
              $sql .=" ORDER BY id DESC";
              if($result = $conn->query($sql)){
              while ($row = $result -> fetch_row()) {

              ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td class="text-center"> <?php echo remove_junk($row[1]); ?></td>
                <td class="text-center"><?php echo remove_junk($row[2]); ?></td>                   
                <td class="text-center"><?php $stats=(int)$row[6];
                if($stats==1){
                  ?>
                  <span style="color: green">Active</span>
                  <?php } if($stats==0)  { ?>
                  <span style="color: red">Not Active</span>
                    <?php } ?>
                  </td>
                  <?php $stats=(int)$row[6];
                  if ($stats==1) {
                  ?>
                  <td class="text-center"><a href="set_schedule.php?id=<?php echo remove_junk($row[0]);?>" class="btn" style="margin-bottom:10px; background-color:steelblue; color: whitesmoke;"><i class="glyphicon glyphicon-calendar"></i> Set Schedule </a></td>
                <?php } } }?>
                </tr>

              </tbody>
        </table>
      </div>
      </div>
    </div>
</div>

<!--from startbootstrap.com this is for Datatables...
    <link href="dist/css/styles.css" rel="stylesheet" />
    -->
    <?php include('layouts/table/tablefooter.php');?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="dist/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="dist/js/datatables-simple-demo.js"></script>


<?php include_once('layouts/footer.php'); ?>