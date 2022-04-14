<?php
  $page_title = 'Apply Leave ';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
   $leavetype = find_all('tblleavetype');
    $user = current_user();
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
if(isset($_POST['btn_apply_leave'])){
$req_fields = array('leavetypes','description','fromDate','toDate');
validate_fields($req_fields);
   if(empty($errors)){
    $currentUserID = (int)$user['id'];
     $l_types = remove_junk($db->escape($_POST['leavetypes']));
     $l_description  = remove_junk($db->escape($_POST['description']));
     $l_fromDate = remove_junk($db->escape($_POST['fromDate']));
     $l_toDate   = remove_junk($db->escape($_POST['toDate']));
     $status=0;
     $isread=0;

$now = time(); // get current date
//$your_date = strtotime("2021-12-14"); // different date
$from_Date = strtotime($l_fromDate);
$to_Date = strtotime($l_toDate);
$datediff = $to_Date - $from_Date; // get the difference between the two dates


$now_from = $now - $from_Date; // remaining days of leave allowed
$consumed_days = round($now_from / (60 * 60 * 24));

//This variables will be inputed to the database
$amount_days = round($datediff / (60 * 60 * 24) + 1); // prints the how many days elapsed between the two dates

$remaining_days = $amount_days - $consumed_days; // subtract the days elapsed to the remaining days of leave allowed

     

     $date    = make_date();
     $query  = "INSERT INTO tblleaves (";
     $query .=" LeaveType,Description,FromDate,ToDate,Status,IsRead,empid,amount_of_days,remaining_days";
     $query .=") VALUES (";
     $query .=" '{$l_types}', '{$l_description}', '{$l_fromDate}', '{$l_toDate}', '{$status}', '{$isread}', '{$currentUserID}', '{$amount_days}', '{$remaining_days}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE LeaveType='{$l_types}'";
     if($l_fromDate > $l_toDate){
                $session->msg('w', 'To Date should be greater than FromDate');
                redirect('apply_leave.php', false);
           }
     if($db->query($query)){
        
       $session->msg('s',"Leave applied! ");
       //================================================
                 //Activity Log
                 //attribute for activity log support
                //  $i_purchase_date = $_POST['purchase_date'];
                //  $ip = $_SERVER['REMOTE_ADDR']; //client IP
                //  date_default_timezone_set('Asia/Manila');
                //  $time = date("F j, Y, h:iA", time());
                //  $itemserialno = $item['serialno'];
                //  //user attributes
                //  $currentUserID = (int)$user['id'];
                //  $currentUser = $user['name'];
                //  $userlevel = (int)$user['user_level'];
                //  //condition for userlevel defining user role
                //  if($userlevel == '1'){
                //   $userRole = "Admin";
                //  }
                //  else{
                //   $userRole = "User";
                //  }
                //  $logactivity = "New item #$i_serialno-$i_name was added by $userRole on $time";
                //   activitylog($logactivity);
                // //Query Statement for activity log
                // $query  = "INSERT INTO activitylog (";
                // $query .=" name,action,quantity_added,ip,purchase_date";
                // $query .=") VALUES (";
                // $query .=" '{$currentUser}', '{$logactivity}', '{$i_qty}', '{$ip}', '{$i_purchase_date}' ";
                // $query .=")";
                // $query .=" ON DUPLICATE KEY UPDATE name='{$currentUser}'";
                // $db->query($query);             
                 //==================================================


       redirect('apply_leave.php', false);
     } else {
       $session->msg('d',' Sorry failed to added!');
       redirect('leave_index.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('apply_leave.php',false);
   }

 }

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
    $sql = "SELECT id,LeaveType,IsRead,Status,emp_read FROM tblleaves WHERE empid='{$userid}' AND emp_read='{$empread}' AND Status='{$status}'";
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
        <a href="apply_leave.php" class="breadcrumbs__item is-active">Apply Leave</a>
        </nav>
      
    <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special menu -->
        <nav class="breadcrumbs">
        <a href="leave_history.php" class="breadcrumbs__item">Leave History</a>
        <a href="leave_type.php" class="breadcrumbs__item">Leave Types</a>
        <a href="leave_report.php" class="breadcrumbs__item">Leave Report</a>
        <a href="leave_management.php" class="breadcrumbs__item">Leave Management <?php if(!$totalAdminUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalAdminUnread; ?></span><?php } ?></a>
        <a href="apply_leave.php" class="breadcrumbs__item is-active">Apply Leave</a>
        </nav>


      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <nav class="breadcrumbs">
        <a href="leave_history.php" class="breadcrumbs__item">Leave History</a>
        <!--This Line of codes show for all leaves responded by admin -->
        <a href="all_leaves.php" class="breadcrumbs__item">All Leaves <?php if(!$totalEmpUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalEmpUnread; ?></span><?php } ?></a>
        <a href="apply_leave.php" class="breadcrumbs__item is-active">Apply Leave</a>
        </nav>
    <?php endif;?>
  </div>
  <div class="col-md-12">
    <div class="card h-100">
      <div class="card-header">
         <h2>Apply Leave</h2>
        <form action="apply_leave.php" method="POST">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control btn-default" name="leavetypes">
                      <option value="">Types of Leave...</option>
                    <?php  foreach ($leavetype as $types): ?>
                      <option value="<?php echo $types['LeaveType'] ?>">
                        <?php echo $types['LeaveType'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
              </div>
              <div class="card-body">
                  <p>Description:</p>
                    <div class="input_group">
                    <textarea rows="4" class="form-control" name="description" placeholder=""></textarea>
                     </div>
                  </div>
                </div>

            <div class="card-body">
              <p>From Date:</p>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                  <input type="date" class="form-control" name="fromDate" placeholder="From Date" >
               </div>
              </div>

              <div class="card-body">
              <p>To Date:</p>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                  <input type="date" class="form-control" name="toDate" placeholder="To Date" >
               </div>
              </div>

                <input type="submit" name="btn_apply_leave" value="APPLY" class="btn btn-primary" style="font-size:15px">         
         </form>
      </div>
    </div>
</div>


<?php include_once('layouts/footer.php'); ?>