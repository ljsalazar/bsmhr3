<?php
  $page_title = 'Add Leave Type ';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
   $leavetype = find_all('tblleavetype');
    $user = current_user();
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
if(isset($_POST['btn_add_leave_type'])){
$req_fields = array('leavetypes','description','earned_leaves');
validate_fields($req_fields);
   if(empty($errors)){
    $currentUserID = (int)$user['id'];
     $l_types = remove_junk($db->escape($_POST['leavetypes']));
     $l_description  = remove_junk($db->escape($_POST['description']));
     $l_earned_leaves = remove_junk($db->escape($_POST['earned_leaves']));

     $date    = make_date();
     $query  = "INSERT INTO tblleavetype (";
     $query .=" LeaveType,Description,earned_leaves";
     $query .=") VALUES (";
     $query .=" '{$l_types}', '{$l_description}', '{$l_earned_leaves}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE LeaveType='{$l_types}'";
     
    
     if($db->query($query)){
        //  Updating leave token of all user
     $query = "UPDATE users SET leave_token=leave_token + '{$l_earned_leaves}'";
     $db->query($query);
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
         <h2>Apply Leave Type</h2>
        <form action="add_leave_type.php" method="POST">
            <div class="card-body">
              <p>Leave Type:</p>
                <div class="row">
                  <div class="col-md-6">
                    <input type="text" name="leavetypes" class="form-control">
                  </div>
              </div>
              <p>Earned Leaves:</p>
                <div class="row">
                  <div class="col-md-6">
                    <input type="number" name="earned_leaves" class="form-control" placeholder="number of earned leaves" min="0">
                  </div>
              
              <div class="card-body">
                  <p>Description:</p>
                    <div class="input_group">
                    <textarea rows="4" class="form-control" name="description" placeholder=""></textarea>
                     </div>
                  </div>
                </div>

                <input type="submit" name="btn_add_leave_type" value="APPLY" class="btn btn-primary" style="font-size:15px"> 
                <a href="leave_type.php" class="btn btn-danger">Cancel</a>        
         </form>
      </div>
    </div>
</div>



<?php include_once('layouts/footer.php'); ?>