<?php
  $page_title = 'Edit Shift';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
  
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php 
    //Query Statement===
    $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
    $user = current_user();
    $userid = (int)$user['id'];
    //====================================
    $id = $_GET['id'];
    $sql ="SELECT * FROM tblshift_type WHERE id = '{$id}'";
    $result = $conn->query($sql);
    $row = $result->fetch_row();
    ?>

<?php 
if(isset($_POST['btn_save_shift'])){
  $req_fields = array('shift_name','fromTime','toTime');
validate_fields($req_fields);
if(empty($errors)){
     $shift_id = remove_junk($db->escape($_POST['id']));
     $shift_name = remove_junk($db->escape($_POST['shift_name']));
     $fromTime  = remove_junk($db->escape($_POST['fromTime']));
     $toTime = remove_junk($db->escape($_POST['toTime']));

     $query  = "UPDATE tblshift_type SET";
     $query .=" name='{$shift_name}', fromTime='{$fromTime}', toTime='{$toTime}'";
     $query .=" WHERE id = '{$shift_id}'";
     // Condition for From time and To time should should not be the same
         if($fromTime == $toTime){
                    $session->msg('w', 'From time and To time should should not be the same');
                    redirect('set_shift.php', false);
         }
     // ================================================================

     if($db->query($query)){
        
       $session->msg('s',"Shift saved! ");
       redirect('set_shift.php', false);
     } else {
       $session->msg('d',' Sorry failed to update!');
       redirect('shiftscheduling_index.php', false);
     }
     } else{
     $session->msg("d", $errors);
     redirect('set_shift.php',false);
   }

}
?>


<?php include_once('layouts/header.php'); ?>
<!-- This will be the body -->
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
    <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
        <nav class="breadcrumbs">
        <a href="schedule_management.php" class="breadcrumbs__item">Manage Schedule</a>
        <a href="scheduling.php" class="breadcrumbs__item">Scheduling</a>
		<a href="set_shift.php" class="breadcrumbs__item is-active">Set Shift</a>
        </nav>

  <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special menu -->
        <nav class="breadcrumbs">
        <a href="schedule_management.php" class="breadcrumbs__item">Manage Schedule</a>
        <a href="scheduling.php" class="breadcrumbs__item">Scheduling</a>
        <a href="set_shift.php" class="breadcrumbs__item is-active">Set Shift</a>
        </nav>


      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <nav class="breadcrumbs">
        <a href="schedule.php" class="breadcrumbs__item">Your Schedule</a>
        </nav>
      
    <?php endif;?>

  </div>

  <div class="col-md-6">
  <div class="card h-100">
			<div class="card-header">
         <h2>EDIT SHIFT</h2>
        
         <form method="post" action="edit_shift.php">
          <input type="hidden" name="id" value="<?php echo (int)$_GET['id']; ?>">

           <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <label>Name:</label>
                    <input type="text" name="shift_name" class="form-control" value="<?php echo $row[1];?>" required>
                  </div>
                </div>
              </div>
                
              

              <div class="card-body">
              <label>From:</label>
                <div class="input-group col-md-2">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-time"></i>
                  </span>
                  <input type="time" class="form-control" name="fromTime" value="<?php echo $row[2];?>" required>
               </div>
             </div>

               <div class="card-body">
              <label>To:</label>
                <div class="input-group col-md-2">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-time"></i>
                  </span>
                  <input type="time" class="form-control" name="toTime" value="<?php echo $row[3];?>" required>
               </div>
              </div>
              
              <input type="submit" name="btn_save_shift" value="SAVE" class="btn btn-primary" style="font-size:15px">
              <a href="set_shift.php" class="btn btn-danger">Cancel</a>
         </form>
       </div>
     </div>


 </div>
  <!-- ==============MINI TABLE FOR SHIFT RECORDS============== -->
<!-- <div class="col-md-6">
    <div class="panel">
      <div class="jumbotron">
        <div class="panel" style="width:100%; display:block; margin:auto">
  <h4 style="text-align:left; margin-bottom:10px; margin-left:10px">Shifting Records:</h4>
  
  <div style="max-height:300px">
      <table class="table" style="table-layout: auto;">
    <tr>
        <th>Shift Name</th> <th>From</th> <th>To</th> <th>Action</th>
    </tr>
  </table>
</div>
        <div style="max-height:300px; overflow:auto;">
      <table class="table" style="table-layout: auto;">
    <?php 

              //Query Statement for leave history
              $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
              $user = current_user();
              $userid = (int)$user['id'];
              $sql ="SELECT id,name,fromTime,toTime FROM tblshift_type";
              $sql.=" ORDER BY id DESC";
              if($result = $conn->query($sql)){
              while ($row = $result -> fetch_row()) {
              ?>
    <tr>
                <td class="text-left"> <?php echo remove_junk($row[1]); ?></td>
                <td class="text-left"><?php $f_time = date("g:i a", strtotime($row[2])); echo $f_time; ?></td>                   
								<td class="text-left"><?php $f_time = date("g:i a", strtotime($row[3])); echo $f_time; ?></td>
        
    </tr>
    <?php } }?>
    </table>
  </div>
</div> -->
<!-- ==================== ==============-->


      </div>
    </div>
  </div>
 

 </div>


<?php include_once('layouts/footer.php'); ?>