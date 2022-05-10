<?php
	$page_title = 'Shift Type Archive';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(1);
	
	$user = current_user();
	$user_level = $user['user_level'];
	if ($user_level <= 1){
		#	header("Location:claim_index_admin.php");
	}
	?><?php
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$claim;$currency;$amount;
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
	$user = current_user();
	$username = $user['username'];
	$user_id = $user['id'];
	$user_level = $user['user_level'];
	$fullname = $user['name'];
	
?><?php include_once('layouts/header.php'); ?>
<html>
	<head>
		<meta name="generator"
		content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
		<title></title>
	</head>
	<body>
		<div class="row">
			<div class="col-md-12"><?php echo display_msg($msg); ?>
				<!-- <?php if ($user_level <= '1'): ?>
				<ul class="nav nav-pills">
					
					<li role="presentation"><a href="claim_index.php" class="btn" style="margin-bottom:10px">Appoint Claims</a></li>
					<li role="presentation"><a href="claim_type.php" class="btn" style="margin-bottom:10px">Types of Claims</a></li>
					<li role="presentation" class="active"><a href="claim_history.php" class="btn" style="margin-bottom:10px">Claims History</a></li>
				</ul>
				
				<?php else: ?>
				<ul class="nav nav-pills">
					
					<li role="presentation"><a href="claim_index.php" class="btn" style="margin-bottom:10px">Appoint Claims</a></li>
					<li role="presentation" class="active"><a href="claim_history.php" class="btn" style="margin-bottom:10px">Claims History</a></li>
				</ul>		
				<?php endif;?> -->
				
				<div class="col-md-12">
					<div class="card h-100">
						<div class="card-header">
							<h3>Deleted Shift Logs</h3>
							<button name="cancel" class="btn btn-primary" onclick="location.href='set_shift.php'">Back</button>
							<div class="card-body">
							<table id="example" class="table table-striped data-table" style="width:100%">
									<thead><tr>
										<th>#</th>
										<th>Shift Type</th>
										<th>From Time</th>
										<th>To Time</th>
										<th>Deletion Date</th>
										<th>Options</th>
									</tr></thead>
								<tbody>
									
										<?php
											$query = $conn->query("SELECT * FROM tblshifttype_archive ORDER BY id DESC");
											
											while($user_data = mysqli_fetch_array($query)) {
												echo "<tr>";
												echo "<td>".count_id()."</td>";
												echo "<td>".$user_data['name']."</td>";
												echo "<td>".$user_data['fromTime']."</td>";
												echo "<td>".$user_data['toTime']."</td>";
												echo "<td>".$user_data['DeletionDate']."</td>";
												
												echo "<td><a href='shift_type_retrieve_archive.php?shifttype_id=$user_data[id]'class='btn btn-secondary'data-toggle='tooltip' title='Retrieve'><i class='bi bi-folder-symlink-fill'></i></a> <a href='shift_type_delete_archive.php?shifttype_id=$user_data[id]' class='btn btn-danger'data-toggle='tooltip' title='Remove'><i class='bi bi-eraser-fill'></i></a></td>";
												echo "</tr>";
											}?>
											</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
	</html>
