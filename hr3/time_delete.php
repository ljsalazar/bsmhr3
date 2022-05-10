<?php
	$page_title = 'Time Delete Prompt';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$user = current_user();
	$user_level = $user['user_level'];
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
	$time_id = $_GET['time_id'];
	$user_id = $user['id'];
	
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
							<?php
								if(isset($_POST['yes'])) {
									$query1 = $conn->query("INSERT INTO time_attendance_archive SELECT * FROM time_attendance WHERE time_id=$time_id");
									$query = $conn->query("DELETE FROM time_attendance WHERE time_id=$time_id");
									$session->msg('s',"Successfully Deleted");
									
									#header("Location:timesheet_index.php");
									echo "<script>window.location.href='timesheet_index.php';</script>";
								}
							?>
							<h2>Are you sure you want to delete?</h2>	
							<form method="post" action="">
								</br>
								<button type="submit" name="yes" class="btn btn-primary" value="yes">Yes</button>
							</form></br>
							<button name="cancel" class="btn" onclick="location.href='timesheet_index.php'">Cancel</button>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
		</html>
				