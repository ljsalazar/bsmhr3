<?php
	$page_title = 'Generate Time Report';
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
					<div class="panel">
						<div class="jumbotron text-center">
							<h2>Select Report Timeframe</h2>	
							<form method="post" action="time_generate_excel.php" enctype="multipart/form-data">
								<?php if ($user_level <= '1'): ?>
								<div class="form-group">
									<p style="text-align:left">User: </p>
									<select class="form-control" name="user_selected" placeholder="Select User">
										<?php
											$query = $conn->query("SELECT name FROM users");
											$all = "All users";
											echo '<option>'.$all.'</option>';
											
											while($row = mysqli_fetch_array($query)){
												echo '<option>'.$row['name'].'</option>';
											}
											
										?>
									</select>
								</div>
								<?php elseif ($user_level >= '2'): ?>
								<input type="hidden" class="form-control" name="user_selected" value="0"> </input>
								<?php endif;?>
								<p style="text-align:left">From: </p>
								<div class="form-group">
									<input required type="datetime-local" class="form-control" name="fromdate" value="<?php echo date('Y-m-d'); ?>" />
								</div>	
								<p style="text-align:left">To: </p>
								<div class="form-group">
									<input required type="datetime-local" class="form-control" name="todate" value="<?php echo date('Y-m-d'); ?>" />
								</div></br>
								<button type="submit" name="generate" class="btn btn-primary" value="generate">Generate Report</button>
							</form></br>
							<button name="cancel" class="btn" onclick="location.href='timesheet_index.php'">Cancel</button>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
	</html>
