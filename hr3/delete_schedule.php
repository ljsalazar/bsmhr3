<?php
  $page_title = 'Delete Schedule';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
   
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>

<?php
if(isset($_POST['btn_delete_shift'])){
  
  $delete_l_id = $_POST['id'];
     $query  = "DELETE FROM tblschedule WHERE id = '{$delete_l_id}'";
     if($db->query($query)){
       $session->msg('d',"Schedule Deleted! ");
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

                $req_fields = array('shift_name','shift_day','emp_id');
                validate_fields($req_fields);
                if(empty($errors)){
                //Query Statement for Archiving Leave Type...
                $shift_name = $_POST['shift_name'];
                $shift_day = $_POST['shift_day'];
                $emp_id = $_POST['emp_id'];
                $query  = "INSERT INTO tblschedule_archive (";
                $query .=" shift_schedule,days,empid";
                $query .=") VALUES (";
                $query .=" '{$shift_name}', '{$shift_day}', '{$emp_id}'";
                $query .=")";
                $query .=" ON DUPLICATE KEY UPDATE shift_schedule='{$shift_name}'";
                $db->query($query);
                }
                 else{
            $session->msg("d", "Invalid Deletion");
            redirect('scheduling.php',false);
              }             


       redirect('scheduling.php', false);
     } else {
       $session->msg('d',' Sorry failed to delete!');
       redirect('delete_schedule.php', false);
     }
 }

?>

<?php include_once('layouts/header.php'); ?>
<!-- This will be the body -->
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div class="card h-100">
      <div class="card-header">
         <h2>Delete Schedule</h2>
        <form action="delete_schedule.php" method="POST">
            <div class="card-body">
              <p>Are you sure you want to delete this Schedule ?</p>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <?php 
                //==================================================
                //Query Statement for leave history
              $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
              $user = current_user();
              $userid = (int)$user['id'];
              $delete_l_id = $_GET['id'];
              $sql  =" SELECT s.id,s.days,s.PostingDate,s.AdminRemark,s.AdminRemarkDate,s.Status,s.IsRead,s.empid,shift_type_id,u.name,t.name,t.fromTime,t.toTime";
              $sql .=" FROM tblschedule s";
              $sql .=" LEFT JOIN users u ON s.empid = u.id";
              $sql .=" LEFT JOIN tblshift_type t ON s.shift_type_id = t.id";
              $sql .=" WHERE s.id = '{$delete_l_id}'";
                $result = $conn->query($sql);
                while ($row = $result -> fetch_row()) {
                  ?>
                <input type="hidden" name="shift_name" value="<?php echo remove_junk($row[10]." (from:".$row[11]." to:".$row[12].")");?>">
                <input type="hidden" name="shift_day" value="<?php echo remove_junk($row[1]);?>">
                <input type="hidden" name="emp_id" value="<?php echo remove_junk($row[7]);?>">
              
                </div>
                <input type="submit" name="btn_delete_shift" value="Yes" class="btn btn-primary">
                <a href="set_schedule.php?id=<?php echo remove_junk($row[7]); ?>" class="btn btn-danger">Cancel</a>    
                <?php } ?>  
         </form>
      </div>
    </div>
</div>



<?php include_once('layouts/footer.php'); ?>