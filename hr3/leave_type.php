<?php
  $page_title = 'Leave History ';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
   // $leave_history = tblleave();

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
    $totalAdminUnread=0;
    $sql = "SELECT id FROM tblleaves WHERE IsRead='{$isread}'";
    $result = $conn->query($sql);
    while($unreadcount = $result -> fetch_row()){
      $totalAdminUnread++;
    }
    ?>
    <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
        <nav class="breadcrumbs">
        <a href="leave_report.php" class="breadcrumbs__item">Leave Report</a>
        <a href="leave_management.php" class="breadcrumbs__item">Leave Management <?php if(!$totalAdminUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalAdminUnread; ?></span><?php } ?></a>
        <a href="apply_leave.php" class="breadcrumbs__item">Apply Leave</a>
        <a href="leave_history.php" class="breadcrumbs__item">Leave History</a>
        <a href="leave_type.php" class="breadcrumbs__item is-active">Leave Types</a>
        </nav>
      
    <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special menu -->
        <nav class="breadcrumbs">
        <a href="leave_report.php" class="breadcrumbs__item">Leave Report</a>
        <a href="leave_management.php" class="breadcrumbs__item">Leave Management <?php if(!$totalAdminUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalAdminUnread; ?></span><?php } ?></a>
        <a href="apply_leave.php" class="breadcrumbs__item">Apply Leave</a>
        <a href="leave_history.php" class="breadcrumbs__item">Leave History</a>
        <a href="leave_type.php" class="breadcrumbs__item is-active">Leave Types</a>
        </nav>


      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <nav class="breadcrumbs">
        <a href="apply_leave.php" class="breadcrumbs__item">Apply Leave</a>        
        <!--This Line of codes show for all leaves responded by admin -->
        <a href="all_leaves.php" class="breadcrumbs__item">All Leaves <?php if(!$totalEmpUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalEmpUnread; ?></span><?php } ?></a>
        <a href="leave_history.php" class="breadcrumbs__item is-active">Leave History</a>
        </nav>
    <?php endif;?>
    
      </div>
    <div class="col-md-12">
      <div class="card h-100">
        <div class="card-header">
          <h2>Manage Leave Type</h2>
          <a href="leave_type_archive.php" class="btn btn-outline-danger"><span class="bi bi-trash3-fill"></a>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
           <a href="add_leave_type.php" class="btn btn-primary me-md-2">Add New</a>
          </div>
        </div>
        <div class="card-body">
          <!--<table class="table table-bordered" class="table table-sm table-striped table-bordered table-hover" style="width:100%">-->
            <table id="datatablesSimple" class="table table-striped data-table" style="width:100%">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center" style="width: 50px;">Leave Type</th>
                <th class="text-center" style="width: 10%;"> Description </th>
                <th class="text-center" style="width: 10%;"> Creation Date </th>
                <th class="text-left" style="width: 100px;"> Action </th>
              </tr>
            </thead>
            <tbody>
              <?php 

              //Query Statement for leave history
              $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
              $user = current_user();
              $userid = (int)$user['id'];

              $sql  =" SELECT * FROM tblleavetype";
              $sql .=" ORDER BY id DESC";
              if($result = $conn->query($sql)){
              while ($row = $result -> fetch_row()) {
              ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td class="text-center" style="width:20%"> <?php echo remove_junk($row[1]); ?></td> 
                <td class="text-left" style="width:30%"> <?php echo remove_junk($row[2]); ?></td>
                <td class="text-center" style="width:30%"> <?php echo read_date($row[3]); ?></td>
                <td class="text-center"><a href="edit_leave_type.php?id=<?php echo remove_junk($row[0]);?>" class="btn" style="margin-bottom:10px; background-color:green; color: whitesmoke;"> Edit </a>
                <a href="delete_leave_type.php?id=<?php echo remove_junk($row[0]);?>" class="btn" style="margin-bottom:10px; background-color:red; color: whitesmoke;"> Delete </a>
              </td>
              </tr>
             <?php } }?>
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