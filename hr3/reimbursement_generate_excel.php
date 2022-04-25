<?php
	$page_title = 'Time Generate Excel';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	//   $products = join_barista_table();
	
?>
<!--Body...-->
<?php
	
	$output = '';
	if(isset($_POST["generate"]))
	{
		$fromdate = $_POST['fromdate'];
		$todate = $_POST['todate'];
		$user_selected = $_POST['user_selected'];
		$output .= '
		<table id="datatablesSimple" class="table-striped table-bordered table-hover" bordered="4" style="width:100%">
		<thead>  
		<tr>  
		<th>#</th> 
		<th>Name</th>  
		<th>Reimbursement</th>  
		<th>Reimbursement Date</th>  
		<th>Amount</th>  
		<th>Status</th>  
		</tr>
		</thead>
		';
		
		
		//Query Statement for leave history
		$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
		$user = current_user();
		$userid = (int)$user['id'];
		$username = $user['username'];
		$user_level = $user['user_level'];
		$status = $_POST['status'];
		
		switch ($status) {
			case 'Rejected Only':
			$accepted = '2';
			break;
			case 'Accepted Only':
			$accepted = '1';
			break;
		}
		
		if ($user_level <= 2){
			if ($user_selected == 'All users'){
				if ($status == 'All') {
					$result = $conn->query("SELECT name, reimbursement, reimbursement_date, amount, status FROM reimbursements WHERE reimbursement_date >= '$fromdate' 
					AND reimbursement_date <= '$todate' AND accepted != 0 ORDER BY reimbursement_id DESC");	
					} else {
					$result = $conn->query("SELECT name, reimbursement, reimbursement_date, amount, status FROM reimbursements WHERE reimbursement_date >= '$fromdate' 
					AND reimbursement_date <= '$todate' AND accepted = '$accepted' ORDER BY reimbursement_id DESC");	
				}
				
				} else {
				if ($status == 'All') {
					$result = $conn->query("SELECT name, reimbursement, reimbursement_date, amount, status FROM reimbursements WHERE reimbursement_date >= '$fromdate' 
					AND reimbursement_date <= '$todate' AND name = '$user_selected' AND accepted != 0 ORDER BY reimbursement_id DESC");	
					} else {
					$result = $conn->query("SELECT name, reimbursement, reimbursement_date, amount, status FROM reimbursements WHERE reimbursement_date >= '$fromdate' 
					AND reimbursement_date <= '$todate' AND name = '$user_selected' AND accepted = '$accepted' ORDER BY reimbursement_id DESC");	
				}
			}
		} 
		elseif ($user_level > 2) {
			if ($status == 'All') {
				$result = $conn->query("SELECT name, reimbursement, reimbursement_date, amount, status FROM reimbursements WHERE reimbursement_date >= '$fromdate' 
				AND reimbursement_date <= '$todate' AND username = '$username' AND accepted != 0 ORDER BY reimbursement_id DESC");	
				} else {
				$result = $conn->query("SELECT name, reimbursement, reimbursement_date, amount, status FROM reimbursements WHERE reimbursement_date >= '$fromdate' 
				AND reimbursement_date <= '$todate' AND username = '$username' AND accepted = '$accepted' ORDER BY reimbursement_id DESC");	
			}
		}
		#if($result = $conn->query($sql)){
			while($row = mysqli_fetch_array($result)){
				
				
				//   foreach ($products as $product){
				//   $productstock = intval($product['quantity'] + $product['damage_item']);
				$output .= '
				<tbody>
				<tr>  
				<td class="text-center"> '.count_id(). '</td>  
				<td class="text-center"> '.$row['name']. '</td>  
				<td class="text-center"> '.$row['reimbursement']. '</td>  
				<td class="text-center"> '.$row['reimbursement_date']. '</td>  
				<td class="text-center"> '.$row['amount']. '</td>  
				<td class="text-center"> '.$row['status']. '</td>  
				</tr>
				
				</tbody>
				';
			}
			#	}
			$output .= '</table>';
			date_default_timezone_set('Asia/Manila');
			$date = date("F j, Y, g:i a");
			$title = $date."_Reimbursement_". "report.xls";
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="'.$title.'" ');
		echo $output;
		}
		
		?>				