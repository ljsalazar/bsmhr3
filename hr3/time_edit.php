<?php
	$page_title = 'Edit Time Data';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$user = current_user();
	$user_level = $user['user_level'];
	$user_id = $user['id'];
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
	$time_id = $_GET['time_id'];
	
	$result = $conn->query("SELECT * FROM time_attendance WHERE time_id=$time_id");
	while($user_data = mysqli_fetch_array($result))
	{
		#$budget = $user_data['reimbursement_budget'];
		$login_time = $user_data['login_time'];
		$logout_time = $user_data['logout_time'];
		$calculated_work = $user_data['calculated_work'];
	}
	
	if ($time_id == $user_id){
		$session->msg('d',"You can't edit your own time data");
		echo "<script>window.location.href='timesheet_index.php';</script>"; 
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
				<?php 
					$query = $conn->query("SELECT complaint_notif FROM users WHERE id='$user_id'");
					while($user_data = mysqli_fetch_array($query)) {
						$complaint_notif = $user_data['complaint_notif'];
					}
				?>
				<?php echo display_msg($msg); ?>
				<nav class="breadcrumbs">
					<a href="time_index.php" class="breadcrumbs__item">Time and Attendance <?php if(!$complaint_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$complaint_notif; ?></span><?php } ?></a>
					<a href="timesheet_index.php" class="breadcrumbs__item is-active">Timesheet Management</a>
				</nav>
				
				<div class="col-md-12">
					<div class="panel">
						<div class="jumbotron text-center">
							<h2>Edit Time Data</h2></br>
							<?php
								if(isset($_POST['update'])) {
									$login_time_post = $_POST['type'];
									$logout_time_post = $_POST['type2'];
									
									$login_adv = strtotime($login_time_post);
									$logout_adv = strtotime($logout_time_post);
									#$interval = $login_adv->diff($logout_adv);
									
									if ($login_adv > $logout_adv){
										$session->msg('d',"Logout time should not be more advanced than the login time");
										echo "<script type='text/javascript'>window.location.href='';</script>";
										} else {
										
									$conn->query("UPDATE time_attendance set login_time='$login_time_post' WHERE time_id=$time_id");
									$conn->query("UPDATE time_attendance set logout_time='$logout_time_post' WHERE time_id=$time_id");
									
									$time1 = strtotime($login_time_post);
									$time2 = strtotime($logout_time_post);
									$result1 = round(abs($time1 - $time2) / 3600,2);
									$result2 = round(abs($time1 - $time2) / 60,2);
									
									$result = "$result1 Hours ($result2 Minutes)";
									$conn->query("UPDATE time_attendance SET calculated_work='$result' WHERE time_id='$time_id'");
									
									$session->msg('s',"Time data successfully updated");
									echo "<script>window.location.href='timesheet_index.php';</script>"; 
									}
									}
									?></br>
									<form method="post">
									<h4 style="text-align:left">Login time: <?#= htmlspecialchars($login_time) ?></h4>
									<input type="datetime" name="type" class="form-control" value="<?= htmlspecialchars($login_time) ?>"></br>
									
									<h4 style="text-align:left">Logout time: <?#= htmlspecialchars($logout_time) ?></h4>
									<input type="datetime" name="type2" class="form-control" value="<?= htmlspecialchars($logout_time) ?>"></br>
									
									<input style="float:right; margin-left: 20px; " type="submit" name="update" class="btn btn-success" value="Update">
									</form>
									<button style="float:right;" name="cancel" class="btn btn-danger" onclick="location.href='timesheet_index.php'">Cancel</button>
									</div>
									</div>
									</div>
									</div><?php include_once('layouts/footer.php'); ?>
									</body>
									</html>
																		