<?php
	$page_title = 'Time Archive';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
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
	
	$query = $conn->query("SELECT complaint_notif FROM users WHERE id='$user_id'");
	while($user_data = mysqli_fetch_array($query)) {
		$complaint_notif = $user_data['complaint_notif'];
	}
	
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
				<?php echo display_msg($msg); ?>
				<nav class="breadcrumbs">
					<a href="time_index.php" class="breadcrumbs__item">Time and Attendance <?php if(!$complaint_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$complaint_notif; ?></span><?php } ?></a>
					<a href="timesheet_index.php" class="breadcrumbs__item is-active">Timesheet Management</a>
				</nav>
				
				<div class="col-md-12">
					<div class="card h-100">
						<div class="card-header">
							<h2>Deleted Time Logs</h2>
							<p>Archived items you can retrieve or permanently delete</p>
							<button name="cancel" class="btn btn-primary" onclick="location.href='timesheet_index.php'">Back</button>
						</div>
						<div class="card-body" style="max-height:600px; overflow:auto;">
							<table id="example" class="table table-striped data-table" style="width:100%">
								<thead>
									<tr>
										<th>User</th>
										<th>Login Time</th>
										<th>Logout Time</th>
										<th>Calculated Work</th>
										<th>Options</th>
									</tr>
								</thead>
								<?php
									$query = $conn->query("SELECT * FROM time_attendance_archive ORDER BY time_id DESC");
									
									while($user_data = mysqli_fetch_array($query)) {
										echo "<tr>";
										echo "<td>".$user_data['name']."</td>";
										echo "<td>".$user_data['login_time']."</td>";
										echo "<td>".$user_data['logout_time']."</td>";
										echo "<td>".$user_data['calculated_work']."</td>";
										echo "<td><a href='time_retrieve_archive.php?time_id=$user_data[time_id]'class='btn btn-secondary'data-toggle='tooltip' title='Retrieve'><i class='bi bi-folder-symlink-fill'></i></a> <a href='time_delete_archive.php?time_id=$user_data[time_id]' class='btn btn-danger'data-toggle='tooltip' title='Remove'><i class='bi bi-eraser-fill'></i></a></td>";
										echo "</tr>";
									}?>
							</table>
						</div>
						
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
	</html>
		