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
		<table id="datatablesSimple" class="table-bordered table-bordered table-hover" bordered="4" style="width:100%">
		<thead>  
		<tr>  
		<th>#</th> 
		<th>User</th>  
		<th>Login Time</th>  
		<th>Logout Time</th>  
		<th>Hours Worked</th>  
		</tr>
		</thead>
		';
		
		
		//Query Statement for leave history
		$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
		$user = current_user();
		$userid = (int)$user['id'];
		$username = $user['username'];
		$user_level = $user['user_level'];
		
		if ($user_level <= 1){
			if ($user_selected == 'All users'){
				$result = $conn->query("SELECT name, login_time, logout_time, calculated_work FROM time_attendance WHERE login_time >= '$fromdate' 
				AND logout_time <= '$todate' ORDER BY time_id DESC");
				
				} else {
				$result = $conn->query("SELECT name, login_time, logout_time, calculated_work FROM time_attendance WHERE login_time >= '$fromdate' 
				AND logout_time <= '$todate' AND name = '$user_selected' ORDER BY time_id DESC");
			}
		} 
		elseif ($user_level >= 2) {
			$result = $conn->query("SELECT name, login_time, logout_time, calculated_work FROM time_attendance WHERE login_time >= '$fromdate' 
			AND logout_time <= '$todate' AND name = '$name' ORDER BY time_id DESC");
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
				<td class="text-center"> '.$row['login_time']. '</td>  
				<td class="text-center"> '.$row['logout_time']. '</td>  
				<td class="text-center"> '.$row['calculated_work']. '</td>  
				</tr>
				
				</tbody>
				';
			}
	#	}
		$output .= '</table>';
		date_default_timezone_set('Asia/Manila');
		$date = date("F j, Y, g:i a");
		$title = $date."_Time_". "report.xls";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="'.$title.'" ');
		echo $output;
	}
	
?>