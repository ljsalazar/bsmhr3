<?php
  $page_title = 'Delete Shift Type';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
   
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>

<?php
if(isset($_POST['btn_delete_shift'])){
  
  $delete_l_id = $_POST['id'];
     $query  = "DELETE FROM tblshift_type WHERE id = '{$delete_l_id}'";
     if($db->query($query)){
       $session->msg('d',"Shift Type Deleted! ");
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

                $req_fields = array('s_name','s_fromTime','s_toTime');
                validate_fields($req_fields);
                if(empty($errors)){
                //Query Statement for Archiving Leave Type...
                $s_name = $_POST['s_name'];
                $s_fromTime = $_POST['s_fromTime'];
                $s_toTime = $_POST['s_toTime'];
                $query  = "INSERT INTO tblshifttype_archive (";
                $query .=" name,fromTime,toTime";
                $query .=") VALUES (";
                $query .=" '{$s_name}', '{$s_fromTime}', '{$s_toTime}'";
                $query .=")";
                $query .=" ON DUPLICATE KEY UPDATE name='{$s_name}'";
                $db->query($query);
                }
                 else{
            $session->msg("d", "Invalid Deletion");
            redirect('set_shift.php',false);
              }             


       redirect('set_shift.php', false);
     } else {
       $session->msg('d',' Sorry failed to delete!');
       redirect('delete_shift.php', false);
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
         <h2>Delete Shift Type</h2>
        <form action="delete_shift.php" method="POST">
            <div class="card-body">
              <p>Are you sure you want to delete this Shift ?</p>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <?php 
                //==================================================
                //Query Statement for leave history
              $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
              $user = current_user();
              $userid = (int)$user['id'];
              $delete_l_id = $_GET['id'];
                $query ="SELECT * FROM tblshift_type WHERE id = '{$delete_l_id}'";
                $result = $conn->query($query);
                while ($row = $result -> fetch_row()) {
                  ?>
                <input type="hidden" name="s_name" value="<?php echo remove_junk($row[1]);?>">
                <input type="hidden" name="s_fromTime" value="<?php echo remove_junk($row[2]);?>">
                <input type="hidden" name="s_toTime" value="<?php echo remove_junk($row[3]);?>">
              
                </div>
                <input type="submit" name="btn_delete_shift" value="Yes" class="btn btn-primary">
                <a href="set_shift.php?id=<?php echo remove_junk($row[0]); ?>" class="btn btn-danger">Cancel</a>  
                <?php } ?>    
         </form>
      </div>
    </div>
</div>



<?php include_once('layouts/footer.php'); ?>