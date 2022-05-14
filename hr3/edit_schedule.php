<?php
  $page_title = 'Edit Schedule';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
  $shift_type = find_all('tblshift_type');
  $user = current_user();
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php 
    //Query Statement===
    $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
    $user = current_user();
    $userid = (int)$user['id'];
    //====================================
    $id = $_GET['id'];
    $sql  =" SELECT s.id,s.days,s.PostingDate,s.AdminRemark,s.AdminRemarkDate,s.Status,s.IsRead,s.empid,s.shift_type_id,u.name,u.username,t.name,t.fromTime,t.toTime";
    $sql .=" FROM tblschedule s";
    $sql .=" LEFT JOIN users u ON s.empid = u.id";
    $sql .=" LEFT JOIN tblshift_type t ON s.shift_type_id = t.id";
    $sql .=" WHERE s.id = '{$id}'";
    $result = $conn->query($sql);
    $row = $result->fetch_row();
    ?>

<?php
if (isset($_POST['btn_apply_sched'])) {
  $req_fields = array('schedule');
validate_fields($req_fields);
   if(empty($errors)){
    $employee_id = remove_junk($db->escape($_POST['id']));
    $schedule = remove_junk($db->escape($_POST['schedule']));
     //Days
     $mon  = remove_junk($db->escape($_POST['Monday']));
     $tue  = remove_junk($db->escape($_POST['Tuesday']));
     $wed  = remove_junk($db->escape($_POST['Wednesday']));
     $thu  = remove_junk($db->escape($_POST['Thursday']));
     $fri  = remove_junk($db->escape($_POST['Friday']));
     $sat  = remove_junk($db->escape($_POST['Saturday']));
     $days  = $mon."".$tue."".$wed."".$thu."".$fri."".$sat;

     $status=0;
     $isread=0;

     $query  = "UPDATE tblschedule SET";
     $query .=" shift_type_id='{$schedule}', days='{$days}'";
     $query .=" WHERE id = '{$employee_id}'";

     
     if($db->query($query)){
        
       $session->msg('s',"Scheduling applied! ". $value);
       redirect('scheduling.php', false);
     } else {
       $session->msg('d',' Sorry failed to added!');
       redirect('scheduling.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('scheduling.php',false);
   }

}
?>

<?php include_once('layouts/header.php'); ?>
<!-- This will be the body -->
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>

  </div>


  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-header">
        <h2>Edit Schedule</h2>

         <form method="post" action="edit_schedule.php">
           <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                     <p>Select shift</p>
                    <select class="form-control btn-default" name="schedule" required>

                      <option value="<?php echo $row[8];?>"><?php echo $row[11]." (from ".$row[12]." to ".$row[13].")";?></option>
                      <?php  foreach ($shift_type as $shifts): ?>
                      <option value="<?php echo $shifts['id']; ?>"><?php echo $shifts['name']. " (from " .$shifts['fromTime']. " to " .$shifts['toTime'].")"; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                </div>
                </div>

      <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <p>Select Days:</p>
          
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="Monday" id="radio1" value="Mon-" class="radio"/>
                  <label class="weekdayslabel" for="radio1">Monday</label>
                  </div>

                  <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="Tuesday" id="radio2" value="Tue-" class="radio"/>
                  <label class="weekdayslabel" for="radio2">Tuesday</label>
                  </div>

                  <div class="form-check form-switch"> 
                  <input class="form-check-input" type="checkbox" name="Wednesday" id="radio3" value="Wed-" class="radio"/>
                  <label class="weekdayslabel" for="radio3">Wednesday</label>
                  </div>
                
                  <div class="form-check form-switch"> 
                  <input class="form-check-input" type="checkbox" name="Thursday" id="radio4" value="Thu-" class="radio"/>
                  <label class="weekdayslabel" for="radio4">Thursday</label>
                  </div>

                  <div class="form-check form-switch"> 
                  <input class="form-check-input" type="checkbox" name="Friday" id="radio5" value="Fri-" class="radio"/>
                  <label class="weekdayslabel" for="radio5">Friday</label>
                  </div>

                  <div class="form-check form-switch"> 
                  <input class="form-check-input" type="checkbox" name="Saturday" id="radio6" value="Sat" class="radio"/>
                  <label class="weekdayslabel" for="radio6">Saturday</label>
                  </div>

                  </div>
                </div>
                </div>

              <input type="submit" name="btn_apply_sched" value="SAVE" class="btn btn-primary" style="font-size:15px">
              <a href="set_schedule.php?id=<?php echo $row[7];?>" class="btn btn-danger">Cancel</a>
         </form>
       </div>
     </div>
   </div>
 

 
 <!-- ==============MINI TABLE FOR SHIFT RECORDS============== -->
<!-- <div class="col-md-6">
    <div class="panel">
      <div class="jumbotron">
        <div class="panel" style="width:100%; display:block; margin:auto">
  <h4 style="text-align:left; margin-bottom:10px; margin-left:20px">Records by <b><?php echo strtoupper($user['username']);?></b></h4>
  <div style="max-height:600px">
      <table class="table" style="table-layout: fixed;">
    <tr>
        <th>#</th> <th>Shift</th> <th>Days</th> <th>Action</th>
    </tr>
  </table>
</div>
        <div style="max-height:600px; overflow:auto;">
      <table class="table" style="table-layout: fixed;">
    <?php 

              //Query Statement for leave history
              $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
              $user = current_user();
              $userid = (int)$user['id'];
              $username = $user['username'];
              $empid = $_GET['id'];
              $sql ="SELECT id,shift_schedule,days FROM tblschedule";
              $sql.=" WHERE empid='{$empid}'";
              $sql.=" ORDER BY id DESC";
              if($result = $conn->query($sql)){
              while ($row = $result -> fetch_row()) {
              ?>
    <tr>
                <td class="text-left"> <?php echo count_id(); ?></td>
                <td class="text-left"> <?php echo remove_junk($row[1]); ?></td>
                <td class="text-left"><?php echo remove_junk($row[2]); ?></td>
          <td class="text-left">
          <a href="edit_schedule.php?id=<?php echo remove_junk($row[0]);?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
          <a href="delete_schedule.php?id=<?php echo remove_junk($row[0]);?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Delete"><i class="glyphicon glyphicon-remove"></i></a>
        </td>  
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