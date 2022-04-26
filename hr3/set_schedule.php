<?php
  $page_title = 'Set Schedule';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
  $shift_type = find_all('tblshift_type');
  $user = current_user();
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
if (isset($_POST['btn_apply_sched'])) {
  $req_fields = array('shift_type_id');
validate_fields($req_fields);
   if(empty($errors)){
    $employee_id = remove_junk($db->escape($_POST['id']));
    $shift_type_ID = remove_junk($db->escape($_POST['shift_type_id']));
     //Days
     $mon  = remove_junk($db->escape($_POST['Monday']));
     $tue  = remove_junk($db->escape($_POST['Tuesday']));
     $wed  = remove_junk($db->escape($_POST['Wednesday']));
     $thu  = remove_junk($db->escape($_POST['Thursday']));
     $fri  = remove_junk($db->escape($_POST['Friday']));
     $sat  = remove_junk($db->escape($_POST['Saturday']));
     $status=0;
     $isread=0;
     $days = $mon."".$tue."".$wed."".$thu."".$fri."".$sat;

     //SQL statement for shift name reveal
     $sql ="SELECT fromTime,toTime FROM tblshift_type WHERE id = '{$shift_type_ID}'";
     $result = $db->query($sql);
     $row = $result -> fetch_row();
     $start_time = date("g:i a", strtotime($row[0]));
     $end_time = date("g:i a", strtotime($row[1]));
                $shift_time = $start_time."-".$end_time;

     $query  = "INSERT INTO tblschedule (";
     $query .=" days,Status,IsRead,empid,shift_type_id,shift_type_detail,emp_read";
     $query .=") VALUES (";
     $query .=" '{$days}', '{$status}', '{$isread}', '{$employee_id}','{$shift_type_ID}','{$shift_time}', '0'";
     $query .=")";
    //  $query .=" ON DUPLICATE KEY UPDATE shift_schedule='{$schedule}'";
     if($db->query($query)){
        
       $session->msg('s',"Scheduling applied! ");
       redirect('scheduling.php', false);
     } else {
       $session->msg('d',' Sorry failed to added!');
       redirect('shiftscheduling_index.php', false);
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
         <h2>Shift and Scheduling</h2>
         <label>set schedule here:</label>
         <form method="post" action="set_schedule.php">
           <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <select class="form-control btn-default" name="shift_type_id" required>
                      <option value="">Shift Type...</option>
                      <?php  foreach ($shift_type as $shifts): ?>
                      <option value="<?php echo $shifts['id']; ?>">
                      <?php
                      $start_time = date("g:i a", strtotime($shifts['fromTime']));
                      $end_time = date("g:i a", strtotime($shifts['toTime']));
                       echo $shifts['name']." (".$start_time. "-" .$end_time.")"; ?>
                      </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                </div>
                </div>

                <!-- <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <p>DAYS:</p>
                    <input type="radio" value="Monday" name="days">
                  <span class="badge" style="background-color: red;">Mon</span>
                    <input type="radio" value="Tuesday" name="days">  
                  <span class="badge" style="background-color: red;">Tue</span>
                    <input type="radio" value="Wednesday" name="days">
                  <span class="badge" style="background-color: red;">Wed</span>
                    <input type="radio" value="Thursday" name="days">
                  <span class="badge" style="background-color: red;">Thu</span>
                    <input type="radio" value="Friday" name="days">
                  <span class="badge" style="background-color: red;">Fri</span>
                    <input type="radio" value="Saturday" name="days">
                  <span class="badge" style="background-color: red;">Sat</span>
                </div>
                </div>
                </div> -->
                <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <p>Days:</p>

                <div class="weekdaysbtn">
                  <input type="checkbox" name="Monday" id="radio1" value="Mon-" class="radio"/>
                  <label class="weekdayslabel" for="radio1">Monday</label>
                  </div>

                  <div class="weekdaysbtn">
                  <input type="checkbox" name="Tuesday" id="radio2" value="Tue-" class="radio"/>
                  <label class="weekdayslabel" for="radio2">Tuesday</label>
                  </div>

                  <div class="weekdaysbtn"> 
                  <input type="checkbox" name="Wednesday" id="radio3" value="Wed-" class="radio"/>
                  <label class="weekdayslabel" for="radio3">Wednesday</label>
                  </div>

                  <div class="weekdaysbtn"> 
                  <input type="checkbox" name="Thursday" id="radio4" value="Thu-" class="radio"/>
                  <label class="weekdayslabel" for="radio4">Thursday</label>
                  </div>

                  <div class="weekdaysbtn"> 
                  <input type="checkbox" name="Friday" id="radio5" value="Fri-" class="radio"/>
                  <label class="weekdayslabel" for="radio5">Friday</label>
                  </div>

                  <div class="weekdaysbtn"> 
                  <input type="checkbox" name="Saturday" id="radio6" value="Sat-" class="radio"/>
                  <label class="weekdayslabel" for="radio6">Saturday</label>
                  </div>

                  </div>
                </div>
                </div>

              <input type="submit" name="btn_apply_sched" value="APPLY" class="btn btn-primary" style="font-size:15px">
              <a href="scheduling.php" class="btn btn-danger">Cancel</a>
         </form>
       </div>
     </div>
   </div>
 

 
 <!-- ==============MINI TABLE FOR SHIFT RECORDS============== -->
<div class="col-md-6">
    <div class="card h-100">
      <div class="card-header">
        <div class="panel" style="width:100%; display:block; margin:auto">
  <h4 style="text-align:left; margin-bottom:10px; margin-left:20px"><b>Schedule:</b></h4>
  <div style="max-height:300px">
      <table class="table" style="table-layout: auto;">
    <tr>
        <th>#</th> <th>Shift</th> <th>Days</th> <th>Action</th>
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
              $username = $user['username'];
              $empid = $_GET['id'];
              $sql ="SELECT s.id,s.days,s.shift_type_id,s.shift_type_detail,t.name,t.fromTime,t.toTime FROM tblschedule s";
              $sql.=" LEFT JOIN tblshift_type t ON s.shift_type_id = t.id";
              $sql.=" WHERE empid='{$empid}'";
              $sql.=" ORDER BY id DESC";
              if($result = $conn->query($sql)){
              while ($row = $result -> fetch_row()) {
              ?>
    <tr>
                <td class="text-left"> <?php echo count_id(); ?></td>
                <td class="text-left"> <?php echo remove_junk($row[4]); ?></td>                <td class="text-left"><?php echo remove_junk($row[1]); ?></td>
          <td class="text-left">
          <a href="edit_schedule.php?id=<?php echo remove_junk($row[0]);?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="bi bi-pencil-fill"></i></a>
          <a href="delete_schedule.php?id=<?php echo remove_junk($row[0]);?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove"><i class="bi bi-eraser-fill"></i></a>
        </td>  
    </tr>
    <?php } }?>
    </table>
  </div>
</div>
<!-- ==================== ==============-->


</div>
</div>
</div>
</div>


<?php include_once('layouts/footer.php'); ?>