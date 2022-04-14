<?php
  $page_title = 'Schedule';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
 //code for update to read all new notifications...// 
//Query Statement for unread leave===
    $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
    $user = current_user();
    $userid = (int)$user['id'];
    //====================================
$isread=1;
$sql="UPDATE tblschedule SET IsRead='{$isread}' WHERE IsRead=0";
$result = $db->query($sql);

?>

<?php include_once('layouts/header.php'); ?>
<!-- This will be the body -->
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>

    <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
        <nav class="breadcrumbs">
        <a href="set_shift.php" class="breadcrumbs__item">Set Shift</a>
        <a href="scheduling.php" class="breadcrumbs__item">Scheduling</a>
        <a href="schedule_management.php" class="breadcrumbs__item is-active">Manage Schedule</a>
        </nav>

  <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special menu -->
        <nav class="breadcrumbs">
        <a href="set_shift.php" class="breadcrumbs__item">Set Shift</a>
        <a href="scheduling.php" class="breadcrumbs__item">Scheduling</a>
        <a href="schedule_management.php" class="breadcrumbs__item is-active">Manage Schedule</a>
        </nav>


      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <nav class="breadcrumbs">
        <a href="schedule.php" class="breadcrumbs__item">Your Schedule<?php if(!$totalUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalUnread; ?></span><?php } ?></a>
        </nav>
      
    <?php endif;?>

  </div>

  <div class="col-md-12">
      <div class="card h-100">
        <div class="card-header">
          <h2>Manage Schedules</h2>
        </div>
        <div class="card-body">
          <!--<table class="table table-bordered" class="table table-sm table-striped table-bordered table-hover" style="width:100%">-->
            <table id="datatablesSimple" class="table table-striped data-table" style="width:100%">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center" style="width: 50px;">Employee Name</th>
                <th class="text-center" style="width: 50px;">Schedule</th>
                <th class="text-center" style="width: 50px;">Posting Date</th>
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
              $sql  =" SELECT s.id,s.days,s.PostingDate,s.AdminRemark,s.AdminRemarkDate,s.Status,s.IsRead,s.empid,shift_type_id,u.name,t.name,t.fromTime,t.toTime";
              $sql .=" FROM tblschedule s";
              $sql .=" LEFT JOIN users u ON s.empid = u.id";
              $sql .=" LEFT JOIN tblshift_type t ON s.shift_type_id = t.id";
              $sql .=" WHERE user_level = 3";
              $sql .=" ORDER BY id DESC";
              if($result = $conn->query($sql)){
              while ($row = $result -> fetch_row()) {

              ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td class="text-center"><?php echo remove_junk($row[9]); ?></td>
                <td class="text-center"> <?php echo remove_junk($row[1]); ?></td>
                <td class="text-center"><?php echo remove_junk($row[2]); ?></td>                  
                <td><?php $stats=(int)$row[5];
                if($stats==1){
                  ?>
                  <span style="color: green">Approved</span>
                  <?php } if($stats==2)  { ?>
                  <span style="color: red">Not Approved</span>
                    <?php } if($stats==0)  { ?>
                    <span style="color: blue">waiting for approval</span>
                    <?php } ?>
                  </td>
                  <td class="text-center"><a href="schedule_view.php?id=<?php echo remove_junk($row[0]);?>" class="btn" style="margin-bottom:10px; background-color:steelblue; color: whitesmoke;"> View Details </a></td>
                <?php } } ?>
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