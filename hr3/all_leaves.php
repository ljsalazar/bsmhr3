<?php
  $page_title = 'Leaves ';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
   // $leave_history = tblleave();

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
$sql="UPDATE tblleaves SET emp_read='{$isread}' WHERE empid='{$userid}' AND emp_read=0 AND Status=1";
$result = $db->query($sql);

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
    // SQL statement for employee unread queries
    $sql = "SELECT id FROM tblleaves WHERE emp_read='{$empread}' AND empid='{$userid}' AND Status='{$status}'";
    $result = $conn->query($sql);
    while($unreadcount = $result -> fetch_row()){
      $totalEmpUnread++;
    }
    // SQL statement for admin unread queries
    $sql = "SELECT id FROM tblleaves WHERE IsRead='{$isread}'";
    $result = $conn->query($sql);
    while($unreadcount = $result -> fetch_row()){
      $totalAdminUnread++;
    }
    ?>
      <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
        <nav class="breadcrumbs">
        <a href="leave_history.php" class="breadcrumbs__item">Leave History</a>
        <a href="leave_type.php" class="breadcrumbs__item">Leave Types</a>
        <a href="leave_report.php" class="breadcrumbs__item">Leave Report</a>
        <a href="leave_management.php" class="breadcrumbs__item">Leave Management <?php if(!$totalAdminUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalAdminUnread; ?></span><?php } ?></a>
        <a href="apply_leave.php" class="breadcrumbs__item is-active">Appoint Leave</a>
        </nav>
      
    <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special menu -->
        <nav class="breadcrumbs">
        <a href="leave_history.php" class="breadcrumbs__item">Leave History</a>
        <a href="leave_type.php" class="breadcrumbs__item">Leave Types</a>
        <a href="leave_report.php" class="breadcrumbs__item">Leave Report</a>
        <a href="leave_management.php" class="breadcrumbs__item">Leave Management <?php if(!$totalAdminUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalAdminUnread; ?></span><?php } ?></a>
        <a href="apply_leave.php" class="breadcrumbs__item is-active">Appoint Leave</a>
        </nav>


      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <nav class="breadcrumbs">
        <a href="apply_leave.php" class="breadcrumbs__item">Apply Leave</a>
        <a href="leave_history.php" class="breadcrumbs__item">Leave History</a>
        <!--This Line of codes show for all leaves responded by admin -->
        <a href="all_leaves.php" class="breadcrumbs__item is-active">All Leaves <?php if(!$totalEmpUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalEmpUnread; ?></span><?php } ?></a>
        </nav>
    <?php endif;?>
     </div>
    <div class="col-md-12">
      <div class="card h-100">
        <div class="card-header">
          <h2>All Reponded Leaves</h2>
           <?php
            if($user['leave_token'] >= '2'){
            echo "<p>Available Credits: <b>".$user['leave_token']."</b></p>"; 
            }else{
            echo "<p>Available Credit: <b>".$user['leave_token']."</b></p>"; 
            }
            ?>
        </div>
        <div class="card-body">
          <!--<table class="table table-bordered" class="table table-sm table-striped table-bordered table-hover" style="width:100%">-->
            <table id="example" class="table table-striped date-table" style="width:100%">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center" style="width: 50px;">Leave Type</th>
                <th class="text-center" style="width: 10%;"> From </th>
                <th class="text-center" style="width: 10%;"> To </th>
                <th class="text-center" style="width: 10%;"> Description </th>
                <th class="text-center" style="width: 10%;"> Posting Date </th>
                <th class="text-center" style="width: 10%;"> Admin Remark </th>
                <th class="text-left" style="width: 100px;"> Status </th>
              </tr>
            </thead>
            <tbody>
              <?php 

              //Query Statement for leave history
              $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
              $user = current_user();
              $userid = (int)$user['id'];

              $sql  =" SELECT l.id,l.LeaveType,l.FromDate,l.ToDate,l.Description,l.PostingDate,l.AdminRemarkDate,l.AdminRemark,l.Status,l.empid";
              $sql .=" FROM tblleaves l";
              $sql .=" LEFT JOIN users u ON l.id = u.id";
              $sql .=" WHERE l.empid= '{$userid}'";
              $sql .=" ORDER BY l.AdminRemarkDate DESC";
              if($result = $conn->query($sql)){
              while ($row = $result -> fetch_row()) {
              ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td class="text-center"> <?php echo remove_junk($row[1]); ?></td>
                <td class="text-center"><?php echo read_date($row[2]); ?></td>                   
                <td class="text-center"><?php echo read_date($row[3]); ?></td> 
                <td class="text-center"> <?php echo remove_junk($row[4]); ?></td>
                <td class="text-center"> <?php echo read_date($row[5]); ?></td>
                <td><?php if($row[7]=="")
                {
                  echo htmlentities('waiting for approval');
                } else
                {
                  echo htmlentities(($row[7])." "."at"." ".read_date($row[6]));
                }
                ?></td>
                <td><?php $stats=(int)$row[8];
                if($stats==1){
                  ?>
                  <span style="color: green">Approved</span>
                  <?php } if($stats==2)  { ?>
                  <span style="color: red">Not Approved</span>
                  <?php } if($stats==0)  { ?>
                    <span style="color: blue">waiting for approval</span>
                    <?php } ?>
                  </td>
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
        

        
        
        

<?php include_once('layouts/footer.php'); ?>