<?php
  $page_title = 'Admin | Schedule Details ';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);

  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>

<?php include_once('layouts/header.php'); ?>
<!-- This will be the body -->
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
    <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
        <nav class="breadcrumbs">
        <a href="scheduling.php" class="breadcrumbs__item">Scheduling</a>
        <a href="set_shift.php" class="breadcrumbs__item">Set Shift</a>
        <a href="schedule_management.php" class="breadcrumbs__item is-active">Manage Schedule</a>
        </nav>

  <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special menu -->
        <nav class="breadcrumbs">
        <a href="scheduling.php" class="breadcrumbs__item">Scheduling</a>
        <a href="set_shift.php" class="breadcrumbs__item">Set Shift</a>
        <a href="schedule_management.php" class="breadcrumbs__item  is-active">Manage Schedule</a>
        </nav>


      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <nav class="breadcrumbs">
        <a href="schedule.php" class="breadcrumbs__item">Your Schedule</a>
        </nav>
      
    <?php endif;?>
  </div>
  
  <div class="col-md-12">
    <div class="card h-100">
      <div class="card-header">
         <h2>Schedule Details:</h2>
              <table class="table table-bordered table-hover" style="width:100%">
            <tbody>
              <?php 

              //Query Statement for leave history===
              $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
              $user = current_user();
              $userid = (int)$user['id'];
              //Getting an ID located in the URL...
              $lid=intval($_GET['id']);
              //===================================
              $sql  =" SELECT s.id,s.days,s.PostingDate,s.AdminRemark,s.AdminRemarkDate,s.Status,s.IsRead,s.empid,s.shift_type_id,u.name,u.username,t.name,t.fromTime,t.toTime";
              $sql .=" FROM tblschedule s";
              $sql .=" LEFT JOIN users u ON s.empid = u.id";
              $sql .=" LEFT JOIN tblshift_type t ON s.shift_type_id = t.id";
              $sql .=" WHERE s.id = '{$lid}'";
              $sql .=" ORDER BY id DESC";
              if($result = $conn->query($sql)){
              while ($row = $result -> fetch_row()) {

              ?>
              <tr>
              <td style="font-size:16px;"> <b>Name:</b></td>
                <td><?php echo remove_junk($row[9]); ?></td>
                <td style="font-size:16px;"><b>Id:</b></td>
                <td colspan="3"><?php echo remove_junk($row[7]); ?></td>
                <!-- <td style="font-size:16px;"><b>Gender :</b></td>
                <td><?php echo htmlentities($result->Gender);?></td> -->
                </tr>

                <tr>
                <td style="font-size:16px;"><b>Username:</b></td>
                <td colspan="5"><?php echo remove_junk($row[10]); ?></td>
                <!-- <td style="font-size:16px;"><b>Emp Contact No. :</b></td>
                <td><?php echo htmlentities($result->Phonenumber);?></td>-->
                </tr>

                <tr>
                <td style="font-size:16px;"><b>Date Schedule:</b></td>
                <td><?php echo remove_junk($row[1]) ?></td>
                <td style="font-size:16px;"><b>Time:</b></td>
                <td><?php echo remove_junk("From ".$row[12]." To ".$row[13]);?></td>
                <td style="font-size:16px;"><b>Posting Date:</b></td>
                <td><?php echo remove_junk($row[2]);?></td>
                </tr>

                <tr>
                <td style="font-size:16px;"><b>Status:</b></td>
                <td colspan="5"><?php $stats=$row[5];
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

                <tr>
                <td style="font-size:16px;"><b>Admin Remark: </b></td>
                <td colspan="5"><?php
                if($row[3]==""){
                  echo "waiting for Approval";  
                }
                else{
                echo remove_junk($row[3]);
                }
                ?></td>
                 </tr>

                 <tr>
                  <td style="font-size:16px;"><b>Admin Action taken date : </b></td>
                  <td colspan="5"><?php
                  if($row[4]==""){
                    echo "NA";  
                  }
                  else{
                  echo remove_junk($row[4]);
                  }
                  ?></td>
                   </tr>
                   <!-- //Condition: If Admin taken action or not... -->
                   <?php 
                    if($stats==0)
                    {

                    ?>
                    <tr>
                     <td colspan="5">
                      <a href="sched_approval_form.php?id=<?php echo remove_junk($row[0]);?>" class="btn" style="margin-bottom:10px; background-color:steelblue; color: whitesmoke;"> Take Action</a>
                      
                      </td>
                    </tr>
                    <?php } ?>
                    <!-- // -->
              <?php } }?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>