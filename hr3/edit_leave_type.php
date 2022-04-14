<?php
  $page_title = 'Edit Leave Type';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
   $leavetype = find_all('tblleavetype');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php 
    //Query Statement for selecting all leave types===
    $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
    $user = current_user();
    $userid = (int)$user['id'];
    //====================================
    $l_id = $_GET['id'];
    $sql ="SELECT * FROM tblleavetype WHERE id = '{$l_id}'";
    $result = $conn->query($sql);
    $row = $result->fetch_row();
    ?>
<?php
if(isset($_POST['btn_edit_leave_type'])){
$req_fields = array('leavetypes','description');
validate_fields($req_fields);
   if(empty($errors)){
     $l_types = remove_junk($db->escape($_POST['leavetypes']));
     $l_description  = remove_junk($db->escape($_POST['description']));
     $l_id = remove_junk($db->escape($_POST['id']));
     //SQL Statement Update leave type
     $query  ="UPDATE tblleavetype SET LeaveType='{$l_types}',Description='{$l_description}'";
     $query .=" WHERE id = '{$l_id}'";
     if($db->query($query)){
        
       $session->msg('s',"Leave Type applied! ");
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


       redirect('leave_type.php', false);
     } else {
       $session->msg('d',' Sorry failed to added!');
       redirect('leave_index.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('leave_type.php',false);
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
         <h2>Edit Leave Type</h2>
        <form action="edit_leave_type.php" method="POST">
            <div class="card-body">
              <p>Leave Type:</p>
                <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                    <input type="text" name="leavetypes" class="form-control" value="<?php echo $row[1]; ?>">
                  </div>
              </div>
              <div class="card-body">
                  <p>Description:</p>
                    <div class="input_group">
                    <textarea rows="4" class="form-control" name="description"><?php echo $row[2]; ?></textarea>
                     </div>
                  </div>
                </div>

                <input type="submit" name="btn_edit_leave_type" value="APPLY" class="btn btn-primary" style="font-size:15px">
                <a href="leave_type.php" class="btn btn-danger">Cancel</a>         
         </form>
      </div>
    </div>
</div>



<?php include_once('layouts/footer.php'); ?>