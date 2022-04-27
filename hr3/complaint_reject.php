<?php
	$page_title = 'Complaint Reject Prompt';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$user = current_user();
	$user_level = $user['user_level'];
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
	$complaint_id = $_GET['complaint_id'];
	$name = $user['name'];
	$username = $user['username'];
	
	$result = $conn->query("SELECT * FROM complaints WHERE complaint_id='$complaint_id'");
	while($user_data = mysqli_fetch_array($result))
	{
		$id = $user_data['user_id'];
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
			<div class="col-md-12">
				<?php echo display_msg($msg); ?>
				<nav class="breadcrumbs">
					<a href="timesheet_index.php" class="breadcrumbs__item">Timesheet Management</a>
					<a href="time_index.php" class="breadcrumbs__item is-active">Time and Attendance</a>
				</nav>
				<div class="col-md-12">
					<div class="panel">
						<div class="jumbotron text-center">
							<?php
								if(isset($_POST['yes'])) {
									$remarks = $_POST['remarks'];
									$read = 1;
									$query1 = $conn->query("SELECT * FROM complaints WHERE complaint_id='$complaint_id'");
									while($user_data = mysqli_fetch_array($query1)){
										$getusername = $user_data['username'];
										
										if ($getusername == $username){
											$session->msg('d',"You can't reject your own complaint");
											echo "<script>window.location.href='complaint_index.php';</script>";
											} else {
											$conn->query("UPDATE complaints SET status='Rejected by $name' WHERE complaint_id='$complaint_id'") or die(mysqli_error());
											$conn->query("UPDATE complaints SET accepted=2 WHERE complaint_id='$complaint_id'") or die(mysqli_error());
											$conn->query("UPDATE complaints SET remarks='$remarks' WHERE complaint_id='$complaint_id'") or die(mysqli_error());
											
											#$conn->query("UPDATE users SET complaint_notif=complaint_notif+$read WHERE id=$id");
											$session->msg('s',"Complaint Successfully Rejected");
										}
									}
									echo "<script>window.location.href='complaint_index.php';</script>";
								}
							?>
							<h2>Are you sure you want to reject?</h2>	
							<form method="post" action="">
								</br>
								<textarea placeholder="Remarks" rows="4" class="form-control" name="remarks" placeholder="" length="500" maxlength="500" required></textarea>
								</br>
								<button type="submit" name="yes" class="btn btn-primary" value="yes">Yes</button>
							</form></br>
							<button name="cancel" class="btn" onclick="location.href='complaint_index.php'">Cancel</button>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
	</html>
