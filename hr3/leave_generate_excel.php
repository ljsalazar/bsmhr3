<?php
  $page_title = 'Leave Generate Excel';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
//   $products = join_barista_table();

?>
<!--Body...-->
<?php

$output = '';
if(isset($_POST["export_excel"]))
{
    $fromdate = $_POST['fromdate'];
		$todate = $_POST['todate'];
  $output .= '
   <table id="datatablesSimple" class="table-striped table-bordered table-hover" bordered="4" style="width:100%">
   <thead>  
                    <tr>  
                         <th>#</th>  
                         <th>Employee Name</th>  
                         <th>Leave</th>  
                         <th>Posting Date</th>  
                         <th>Leave Description</th>
                         <th>Amount of Days</th>  
                         <th>From Date</th>
                         <th>To Date</th>  
                         <th>Admin Remarks</th> 
                         <th>Remarked Date</th>  
                    </tr>
                    </thead>
  ';


              //Query Statement for leave history
              $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
              $user = current_user();
              $userid = (int)$user['id'];
              $username = $user['username'];
              $user_level = $user['user_level'];

              if ($user_level == 1){

              $sql  =" SELECT l.id,l.LeaveType,l.FromDate,l.ToDate,l.Description,l.PostingDate,l.AdminRemarkDate,l.AdminRemark,l.Status,l.empid,l.amount_of_days,l.remaining_days,u.name,u.username,u.status";
              $sql .=" FROM tblleaves l";
              $sql .=" LEFT JOIN users u ON l.empid = u.id";
              $sql .=" WHERE l.PostingDate >= '$fromdate' AND l.PostingDate <= '$todate' AND u.status = 1 ";
              $sql .=" ORDER BY id DESC";
              }else{
                $sql  =" SELECT l.id,l.LeaveType,l.FromDate,l.ToDate,l.Description,l.PostingDate,l.AdminRemarkDate,l.AdminRemark,l.Status,l.empid,l.amount_of_days,l.remaining_days,u.name";
                $sql .=" FROM tblleaves l";
                $sql .=" LEFT JOIN users u ON l.empid = u.id";
                $sql .=" WHERE l.PostingDate >= '$fromdate' AND l.PostingDate <= '$todate' AND u.username = '$username'  AND u.status = 1 ";
                $sql .=" ORDER BY id DESC";
              }
              if($result = $conn->query($sql)){
              while ($row = $result -> fetch_row()) {
              

//   foreach ($products as $product){
//   $productstock = intval($product['quantity'] + $product['damage_item']);
   $output .= '
   <tbody>
                    <tr>  
                         <td class="text-center"> '.count_id(). '</td>  
                         <td class="text-center"> '.$row[12]. '</td>  
                         <td class="text-center"> '.$row[1]. '</td>  
                         <td class="text-center"> '.$row[5]. '</td>  
                         <td class="text-center"> '.$row[4]. '</td>  
                         <td class="text-center"> '.$row[10]. '</td>
                         <td class="text-center"> '.$row[2]. '</td>  
                         <td class="text-center"> '.$row[3]. '</td>  
                         <td class="text-center"> '.$row[7]. '</td>
                         <td class="text-center"> '.$row[6]. '</td>
                    </tr>
                    
                    </tbody>
   ';
}
              }
  $output .= '</table>';
  date_default_timezone_set('Asia/Manila');
  $date = date("F j, Y, g:i a");
  $title = $date."_Leaves_". "report.xls";
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment; filename="'.$title.'" ');
  echo $output;
 }

?>