<?php
  $page_title = 'Total Leave';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
   // $leave_history = tblleave();

   if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
 //code for update to read all new pending leave...// 
$isread=1; 
$sql="UPDATE tblleaves SET IsRead='{$isread}' WHERE IsRead=0";
$result = $db->query($sql);

?>


<?php include_once('layouts/header.php'); ?>
<!-- This will be the body -->
<div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>

      <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
        <nav class="breadcrumbs">
        <a href="apply_leave.php" class="breadcrumbs__item">Appoint Leave</a>
        <a href="leave_history.php" class="breadcrumbs__item">Leave History</a>
        <a href="leave_type.php" class="breadcrumbs__item">Leave Types</a>
        <a href="leave_report.php" class="breadcrumbs__item">Leave Report</a>
        <a href="leave_management.php" class="breadcrumbs__item is-active">Leave Management</a>
        </nav>
      
    <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special menu -->
        <nav class="breadcrumbs">
        <a href="apply_leave.php" class="breadcrumbs__item">Appoint Leave</a>
        <a href="leave_history.php" class="breadcrumbs__item">Leave History</a>
        <a href="leave_type.php" class="breadcrumbs__item">Leave Types</a>
        <a href="leave_report.php" class="breadcrumbs__item">Leave Report</a>
        <a href="leave_management.php" class="breadcrumbs__item is-active">Leave Management</a>
        </nav>


      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <nav class="breadcrumbs">
        <a href="apply_leave.php" class="breadcrumbs__item">Apply Leave</a>
        <a href="leave_history.php" class="breadcrumbs__item">Leave History</a>
        </nav>
    <?php endif;?>
    <div class="col-md-12">
      <div class="card h-100">
        <div class="card-header">
          <!-- <h2>Leaves</h2> -->
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
           <a href="leave_credit.php" class="btn btn-success me-md-2">ADD CREDITS <span class="bi bi-credit-card-fill"></a>
          </div>
        </div>
        <div class="card-body">
          <!--<table class="table table-bordered" class="table table-sm table-striped table-bordered table-hover" style="width:100%">-->
            <table id="example" class="table table-striped data-table" style="width:100%">
            <thead>
              <tr>
                <th class="text-left" style="width: 50px;">#</th>
                <th class="text-left" style="width: 50px;">Employee Name</th>
                <th class="text-left" style="width: 50px;">Leave Type</th>
                <th class="text-left" style="width: 10%;"> Posting Date </th>
                <th class="text-left" style="width: 10%;"> From-To </th>
                <th class="text-left" style="width: 100px;"> Status </th>
                <th class="text-left" style="width: 100px;"> Total Days </th>
                <th class="text-left" style="width: 100px;"> Remaining Days </th>
                <th class="text-left" style="width: 100px;"> Action </th>
              </tr>
            </thead>
            <tbody>
              <?php 

              //Query Statement for leave history
              $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
              $user = current_user();
              $userid = (int)$user['id'];

              $sql  =" SELECT id,LeaveType,FromDate,ToDate,Description,PostingDate,AdminRemarkDate,AdminRemark,Status,empid,amount_of_days,remaining_days,emp_name";
              $sql .=" FROM tblleaves";
              // $sql .=" LEFT JOIN users u ON l.empid = u.id";
              // $sql .=" WHERE l.empid= '{$userid}'";
              $sql .=" ORDER BY id DESC";
              if($result = $conn->query($sql)){
              while ($row = $result -> fetch_row()) {
              ?>
              <tr>
                <td class="text-left"><?php echo count_id();?></td>
                <td class="text-left"> <?php echo remove_junk($row[12]); ?></td>
                <td class="text-left"><?php echo remove_junk($row[1]); ?></td>                   
                <td class="text-left"><?php $posting_date = date("F j, Y", strtotime($row[5])); echo $posting_date; ?></td>
                <td class="text-left"><?php echo remove_junk("From:".$row[2]." To:".$row[3]); ?></td>
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
                <td class="text-left"><?php echo remove_junk($row[10]." Days"); ?></td>
                <td class="text-left"><?php echo remove_junk($row[11]." Days"); ?></td>
                <td class="text-left"><a href="leave_view.php?id=<?php echo remove_junk($row[0]);?>" class="btn btn-xs btn-info" data-toggle="tooltip" title="View">
                   <i class="bi bi-eye-fill"></i></a></td>
              </tr>
             <?php } }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


<!--from startbootstrap.com this is for Datatables...
    <link href="dist/css/styles.css" rel="stylesheet" />
    -->
    
        

        
        
        

<?php include_once('layouts/footer.php'); ?>